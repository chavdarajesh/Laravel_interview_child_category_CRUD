<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'image', 'content', 'parent_categories'];

    static public function getNamesFromIds($ids)
    {
        $idArray = explode(',',$ids);
        $names = Category::whereIn('id', $idArray)->pluck('title')->toArray();
        return implode(', ', $names);
    }
}