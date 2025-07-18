<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class FAQController extends Controller
{
    public function index(Request $request)
    {
        $faqs = $this->data($request);

        return Inertia::render('Faq/Index', [
            'faqs' => $faqs
        ]);
    }

    public function data(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $search = $request->search;
        $sort = $request->sort ?? 'id';
        $order = $request->order ?? 'desc';

        $faqs =  FAQ::when($search, function ($q) use ($search) {
            $q->whereRaw('LOWER(question_en) LIKE ?', '%'. $search .'%')
                ->orWhereRaw('LOWER(question_id) LIKE ?', '%'. $search .'%');
        })->orderBy($sort, $order)
        ->paginate($perPage);

        $faqs->setCollection(
            $faqs->getCollection()->map(function ($cat) {
                return [
                    ...$cat->toArray(),
                    'question' => [
                        'en' => $cat->question_en,
                        'id' => $cat->question_id
                    ],
                    'answer' => [
                        'en' => $cat->answer_en,
                        'id' => $cat->answer_id
                    ],
                    'category' => [
                        'en' => $cat->category_en,
                        'id' => $cat->category_id
                    ],
                ];
            })
        );

        return $faqs;
    }

    public function create()
    {
        return Inertia::render('Faq/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_en' => 'required|min:6|max:50',
            'question_id' => 'required|min:6|max:50',
            'answer_en' => 'required',
            'answer_id' => 'required',
            'category_en' => 'required',
            'category_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $faq = Faq::create([
                'question_en' => $request->question_en,
                'question_id' => $request->question_id,
                'answer_en' => $request->answer_en,
                'answer_id' => $request->answer_id,
                'category_en' => $request->category_en,
                'category_id' => $request->category_id,
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

    public function edit(Faq $faq)
    {
        return Inertia::render('Faq/Edit', [
            'faq' => $faq
        ]);
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question_en' => 'required|min:6|max:50',
            'question_id' => 'required|min:6|max:50',
            'answer_en' => 'required',
            'answer_id' => 'required',
            'category_en' => 'required',
            'category_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $faq->update([
                'question_en' => $request->question_en,
                'question_id' => $request->question_id,
                'answer_en' => $request->answer_en,
                'answer_id' => $request->answer_id,
                'category_en' => $request->category_en,
                'category_id' => $request->category_id,
            ]);

            DB::commit();

            return back()->with('success', 'Data updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            throw ValidationException::withMessages([
                'error' => 'Something went wrong'
            ]);;
        }
    }

    public function destroy(Faq $faq)
    {
        try {
            $faq->delete();

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
}
