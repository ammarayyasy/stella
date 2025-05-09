<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['category'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = \Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = \Str::slug($product->name);

            // Cek apakah gambar berubah
            if ($product->isDirty('image')) {
                $originalImage = $product->getOriginal('image');
                if ($originalImage && \Storage::disk('public')->exists($originalImage)) {
                    \Storage::disk('public')->delete($originalImage);
                }
            }
        });

        static::deleting(function ($product) {
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }
        });
    }
}
