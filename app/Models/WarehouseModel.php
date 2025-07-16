<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseModel extends Model
{
    use HasFactory;
     protected $table = 'warehouses'; 
    protected $fillable = ['name','location','email','phone'];
    
    public function inventoryItems()
{
    return $this->belongsToMany(InventoryItemModel::class, 'inventory_item_stock', 'warehouse_id', 'inventory_item_id');
}
}
