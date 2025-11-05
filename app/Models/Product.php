<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'judul',
        'slug',
        'tipe_produk',
        'thumbnail',
        'status',
        'deskripsi',
        'harga',
        'created_at',
        'updated_at',
    ];

    /**
     * Relasi ke tabel lp_programs (landing page program)
     * Satu product punya satu landing page
     */
    public function landingPage()
    {
        return $this->hasOne(LpProgram::class, 'product_id');
    }

    /**
     * Jika ingin generate slug otomatis berdasarkan judul
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->judul);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->judul);
        });
    }
}
