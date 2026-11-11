<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'Makanan Berat',
        'Makanan Ringan / Cemilan',
        'Minuman',
        'Makanan Cepat Saji',
        'Dessert / Makanan Penutup',
        'Roti dan Kue',
        'Makanan Tradisional',
        'Lainnya',
    ];

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }
}
