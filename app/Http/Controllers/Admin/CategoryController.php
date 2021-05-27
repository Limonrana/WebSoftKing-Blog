<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return response()->json($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'categoryName'              => 'required|unique:categories|max:25',
        ]);

        $category                       = new Category();
        $category->categoryName         = $request->categoryName;
        $category->iconImage            = $request->iconImage;
        $category->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'categoryName'              => 'required',
        ]);

        $category                       = Category::find($id);
        $category->categoryName         = $request->categoryName;
        $category->iconImage            = $request->iconImage;
        $category->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $photo = 'uploads/category/'.$category->iconImage;
        if ($category->iconImage) {
            @unlink($photo);
        }
        $category->delete();
    }

    /**
     * Store a newly image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request)
    {
        $validation = $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,bmp,webp',
        ]);
        $photo_name = Str::random(20).time().'.'.$request->file->extension();
        Image::make($request->file)->resize(175, 150)->save(public_path('uploads/category/' . $photo_name));
        return $photo_name;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Request
     * @return \Illuminate\Http\Response
     */
    public function deleteImage(Request $request)
    {
        $filename = $request->imageName;
        $pathname = public_path('/uploads/category/'.$filename);
        if (file_exists($pathname)) {
            unlink($pathname);
        }
    }
}
