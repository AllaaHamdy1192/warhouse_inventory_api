<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemModel extends Model
{
    use HasFactory;
    protected $table = 'inventory_items'; 
    protected $fillable = ['name', 'sku', 'price'];
    public function scopeSearch($query, $keyword)
{
      $keyword= "%$keyword%";
      return $query->where('name', 'LIKE', $keyword)->orWhere('price', 'LIKE', $keyword);
   
}
}
