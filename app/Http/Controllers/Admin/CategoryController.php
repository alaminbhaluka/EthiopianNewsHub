<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('admin.category.index', compact('languages'));
    }

    public function create()
    {
        $languages = Language::all();
        return view('admin.category.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'language' => ['required', 'exists:languages,lang'],
            'name' => ['required', 'string', 'max:150'],
            'show_at_nav' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ]);

        $category = new Category();
        $category->language = $data['language'];
        $category->name = $data['name'];
        $category->slug = Str::slug($data['name']);
        $category->show_at_nav = $data['show_at_nav'];
        $category->status = $data['status'];
        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'ক্যাটাগরি তৈরি হয়েছে।');
    }

    public function show($id)
    {
        return redirect()->route('admin.category.edit', $id);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $languages = Language::all();

        return view('admin.category.edit', compact('category', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'language' => ['required', 'exists:languages,lang'],
            'name' => ['required', 'string', 'max:150'],
            'show_at_nav' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ]);

        $category = Category::findOrFail($id);
        $category->language = $data['language'];
        $category->name = $data['name'];
        $category->slug = Str::slug($data['name']);
        $category->show_at_nav = $data['show_at_nav'];
        $category->status = $data['status'];
        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'ক্যাটাগরি হালনাগাদ হয়েছে।');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->news()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'এই ক্যাটাগরিতে সংবাদ রয়েছে; আগে সংবাদগুলো অন্য ক্যাটাগরিতে সরান।',
            ], 422);
        }

        $category->delete();

        return response()->json(['status' => 'success', 'message' => 'ক্যাটাগরি মুছে ফেলা হয়েছে।']);
    }
}
