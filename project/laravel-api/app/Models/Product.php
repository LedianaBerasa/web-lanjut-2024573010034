<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'stock'];
}

Product::create([
    'name' => 'Laptop',
    'price' => 15000000,
    'description' => 'Laptop gaming terbaru',
    'stock' => 10
]);
