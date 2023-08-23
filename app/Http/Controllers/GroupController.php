<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Models\Group;
use App\Http\Resources\GroupCollection;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Category;

class GroupController extends Controller
{
    public function index()
    {
        // return response()->json(['groups' => Group::all()]);
        // $groups = Group::all();

        // $groups = $groups->map(function ($group) {
        //     $categories = $group->categories;
        //     $categories = $categories->map(function ($category) {
        //         return $category->products()->get();
        //     });
        //     return [
        //         'id' => $group->id,
        //         'name' => $group->name,
        //         'show' => $categories
        //     ];
        // });
        // return response()->json(['data' => $groups]);

        return new GroupCollection(Group::all());
    }

    public function store(StoreGroupRequest $request)
    {
        $user = $request->user();
        if ($user->role != "admin") {
            return [
                'message' => "Usuario NO autorizado",
                'state' => false
            ];
        }

        $datos = $request->validated();
        $group = Group::create([
            'name' => $datos['name']
        ]);
        return [
            'message' => "Grupo creado.",
            'state' => true,
            'data' => $group
        ];
    }

    public function show(Group $group)
    {
        return [
            'id' => $group->id,
            'name'  => $group->name,
        ];
    }

    public function update(UpdateGroupRequest $request, Group $group)
    {
        $user = $request->user();
        if ($user->role != "admin") {
            return [
                'message' => "Usuario NO autorizado",
                'state' => false
            ];
        }

        $datos = $request->validated();

        $group->name = $datos["name"];
        $group->save();

        return [
            'message' => "Grupo actualizado",
            'state' => true
        ];
    }
}
