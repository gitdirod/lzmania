<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CategoryImage;
use Illuminate\Support\Facades\File;
use App\Http\Resources\CategoryCollection;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CategoryCollection(Category::all());
        // $categories = Category::all();
        // $categories = $categories->map(function ($category) {

        //     return [
        //         'group_name' => $category->group->name,
        //         'group_id' => $category->group->id,
        //         'id' => $category->id,
        //         'image' => $category->image,
        //         'name'  => $category->name,
        //         'images' => $category->images()->select('id', 'name')->get(),
        //         'show' => $category->isShowed(),
        //     ];
        // });
        // return response()->json(['data' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $user = $request->user();
        if ($user->role != "admin") {
            return [
                'message' => "Usuario NO autorizado",
                'state' => false
            ];
        }

        $datos = $request->validated();
        $category = Category::create([
            'name' => $datos['name'],
            'group_id' => $datos['group_id']
        ]);
        $category->insertImages($datos);
        return [
            'message' => "Categoría creada",
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $group = $category->group()->get();
        return [
            'id' => $category->id,
            'name'  => $category->name,
            'image' => $category->image,
            'images' => $category->images()->select('id', 'name')->get(),
            'group_id' => $category->group_id,
            'group_name' => $group[0]['name'],
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $user = $request->user();
        if (!$user->isAdmin()) {
            return [
                'message' => "Usuario NO autorizado",
                'state' => false
            ];
        }

        $datos = $request->validated();
        $imgs_stored = $category->images()->select('name', 'id')->get();
        if (isset($datos['images'])) {
            $category->insertImages($datos);
            if (count($imgs_stored)) {
                foreach ($imgs_stored as $imgs) {

                    $path_file = "categories/" . $imgs->name;
                    if (File::exists($path_file)) {
                        File::delete($path_file);
                    }
                    $toDelete = CategoryImage::find($imgs->id);
                    $toDelete->delete();
                }
            }
        }
        $category->updateCategory($datos);
        return [
            'message' => "Categoría actualizada",
            'state' => true
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
