<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::pluck('title', 'id')->toArray();
        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'content' => 'required|string'
        ]);
        if ($request['parents']) {
            $request->validate([
                'parent_categories' => 'array|exists:categories',
            ]);
        }

        $category = new Category();
        $category->title = $request->title;
        $category->content = $request->content;
        $slug = Str::slug($request->title);

        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = Str::slug($request->title) . '-' . $counter;
            $counter++;
        }
        $category->slug = $slug;

        if ($request->parent_categories) {
            $category->parent_categories = implode(',', $request->parent_categories);
        }
        if ($request->hasFile('image')) {
            $folderPath = public_path('assets/images/Category/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file = $request->file('image');
            $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
            $imageName = time() . $imageoriginalname;
            $file->move($folderPath, $imageName);
            $category->image = 'assets/images/category/' . $imageName;
        }
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        $categories = Category::whereNot('id', $category->id)->pluck('title', 'id')->toArray();
        return view('categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $request->validate([
            'title' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'content' => 'required|string'
        ]);
        if ($request['parents']) {
            $request->validate([
                'parent_categories' => 'array|exists:categories',
            ]);
        }
        $category->title = $request->title;
        $category->content = $request->content;
        $slug = Str::slug($request->title);

        $counter = 1;
        while (Category::whereNot('id', $category->id)->where('slug', $slug)->exists()) {
            $slug = Str::slug($request->title) . '-' . $counter;
            $counter++;
        }
        $category->slug = $slug;

        if ($request->parent_categories) {
            $category->parent_categories = implode(',', $request->parent_categories);
        }
        if ($request->hasFile('image')) {
            $folderPath = public_path('assets/images/Category/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file = $request->file('image');
            $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
            $imageName = time() . $imageoriginalname;
            $file->move($folderPath, $imageName);
            $category->image = 'assets/images/category/' . $imageName;
        }
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $categoryId = $category->id;
        $categoriesWithComma = Category::pluck('parent_categories')->toArray();
        $allCategoryIds = explode(',', implode(',', $categoriesWithComma));
        $categoryIdExists = in_array($categoryId, $allCategoryIds);
        if ($categoryIdExists) {
            return redirect()->route('categories.index')->with('error', 'Category linked with child category!.');
        } else {
            $category->delete();
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
        }
    }
}