<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = \Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = \Str::slug($category->name);

            // Cek apakah gambar berubah
            if ($category->isDirty('image')) {
                $originalImage = $category->getOriginal('image');
                if ($originalImage && \Storage::disk('public')->exists($originalImage)) {
                    \Storage::disk('public')->delete($originalImage);
                }
            }
        });

        static::deleting(function ($category) {
            if ($category->image && \Storage::disk('public')->exists($category->image)) {
                \Storage::disk('public')->delete($category->image);
            }
        });
    }
}
