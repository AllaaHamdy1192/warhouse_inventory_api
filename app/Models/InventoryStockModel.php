<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryStockModel extends Model
{
    use HasFactory;
     protected $table = 'inventory_item_stock'; 
     protected $fillable=['inventory_item_id','warehouse_id'];
     public function inventory_item(){
       return $this->belongsTo(InventoryItemModel::class,'inventory_item_id');

    }
     public function warehouse(){
       return $this->belongsTo(WarehouseModel::class);

    }
   
    
}
