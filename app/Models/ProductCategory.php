<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function products() {
        return $this->hasMany(Product::class, 'categories_id', 'id');
    }

    public static function count() {
        $cat = ProductCategory::all();
        foreach ($cat as $cate) {
            $count = $cate->products->count();
        }
    }

    public function parname() 
    { 
        return $this->belongsTo(ProductCategory::class, 'parent_id', 'id');
    }

    public function parent() {
        $categories = ProductCategory::all();
        foreach ($categories as $category) {
            if ($category->parent_id != null) {
                return $this->belongsTo(ProductCategory::class, 'parent_id', 'id')->select(['name']);
            }
        }
    }

    public static function tree() { 
        $allCategories = ProductCategory::withCount(['products'])->with('products')->get();

        $rootCategories = $allCategories->whereNull('parent_id');

        self::formatTree($rootCategories, $allCategories);

        return $rootCategories;
    }

    private static function formatTree($categories, $allCategories) {
        foreach ($categories as $category) {
            $category->children = $allCategories->where('parent_id', $category->id)->values();

            if ($category->children->isNotEmpty()) {
                self::formatTree($category->children, $allCategories);
            }
        }
    }

}
