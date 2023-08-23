<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function categories()
    {
        return $this->hasMany(Category::class, 'group_id');
    }
    public function isShowed()
    {
        $categories = $this->categories()->get();

        $thereCategories = $categories->filter(function ($category) {
            return $category->isShowed();
        });

        $isShow = $thereCategories->isNotEmpty();
        return $isShow ? true : false;
    }
}
