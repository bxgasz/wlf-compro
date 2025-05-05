<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Mail\CreateUserMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {   
        $users = $this->data($request);

        return Inertia::render('User/Index', [
            'users' => $users
        ]);
    }

    public function data(Request $request)
    {
        $perPage = $request->perpage ?? 10;
        $search = $request->search;
        $role = $request->role;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $users = User::when($search, function ($q) use ($search) {
            $q->where('name', 'like', '%'. $search .'%')
                ->orWhere('email', 'like', '%'. $search .'%');
        })->when($role, function ($q) use ($role) {
            $q->where('role', $role);
        })->where('id' ,'!=', Auth::user()->id);
        
        if (Auth::user()->role == 'manager') {
            $users = $users->where('role', '!=', 'admin');
        } else if (Auth::user()->role == 'staff') {
            $users = $users->where('role', 'staff');
        }

        return $users->orderBy($sort, $order)
        ->paginate($perPage);
    }

    public function create()
    {
        return Inertia::render('User/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'role' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $defaultPass = Str::random(16);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($defaultPass),
                'profile_pic' => asset('assets/img/default-profile-pic.jpg')
            ]);

            $mailData = [
                'title' => 'Your Account Credentials',
                'password' => $defaultPass,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'url' => route('auth.login')
            ];

            Mail::to($user->email)->send(new CreateUserMail($mailData));

            DB::commit();
            
            return redirect(route('user.index'));

        } catch (\Throwable $th) {
            DB::rollBack();

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return Inertia::render('User/Edit', [
            'user' => $user
        ]);
    }
    
    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'role' => 'required',
            'password' => 'confirmed|min:5|nullable'
        ]);

        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            if ($request->password) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            DB::commit();

            return redirect(route('user.index'));

        } catch (\Throwable $th) {
            DB::rollBack();

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'errors' => $th->getMessage()
            ]);
        }
    }

    public function getProfile()
    {
        return Inertia::render('Profile/Index');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',       
            'email' => Auth::user()->email == $request->email ? 'required|email' : 'required|email|unique:users,email',     
            'profile_pic' => 'sometimes|nullable|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail(Auth::user()->id);

            if ($request->hasFile('profile_pic')) {
                $oldImagePath = str_replace(url('/storage/'), '', $user->profile_pic);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                $fileName = time() . '_' . $request->file('profile_pic')->getClientOriginalName();
                $filePath = Storage::disk('public')->putFileAs('/users', $request->file('profile_pic'), $fileName);

                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'profile_pic' => asset('/storage/' . $filePath)
                ]);
            } else {
                $user->update([
                    'username' => $request->username,
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            }

            DB::commit();

            return back()->with('success', 'Data updated successfully');

        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:5|max:20',
            'new_password' => 'required|min:5|max:20|confirmed',
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            throw ValidationException::withMessages(['old_password' => 'Wrong password']);
        }

        $user = User::findOrFail(Auth::user()->id);

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return back()->with('success', 'Password updated successfully');
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function updateStatus(User $user)
    {
        try {
            $user->is_active = !$user->is_active;
            $user->update();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'errors' => $th->getMessage()
            ]);
        }
    }
}
