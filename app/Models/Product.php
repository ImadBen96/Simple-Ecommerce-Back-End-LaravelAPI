<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        "category_id",
        "product_name",
        "old_price",
        "current_price",
        "qty",
        "main_image",
        "others_images","sizes","colors","description","short_description","is_active"];

    /**
     * Get the phone associated with the user.
     */
    public function category(): HasOne
    {
        return $this->hasOne(Category::class,"id","category_id");
    }


    }


