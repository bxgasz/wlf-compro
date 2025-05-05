<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        $inboxes = $this->data($request);

        return Inertia::render('Inbox/Index', [
            'inboxes' => $inboxes
        ]);
    }

    public function data(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $inboxes =  Inbox::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(full_name) LIKE ?', '%'. $search .'%');
        })->orderBy($sort, $order)
        ->paginate($perPage);

        return $inboxes;
    }

    public function show(Inbox $inbox)
    {
        $inbox->is_read = true;
        $inbox->save();
        
        return Inertia::render('Inbox/Show', [
            'inbox' => $inbox
        ]);
    }

    public function create()
    {
        return Inertia::render('Inbox/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $inbox = Inbox::create([
                'full_name' => $request->full_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            DB::commit();

            return back()->with('success', 'Data created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());
            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);
        }
    }

}
