<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransferModel extends Model
{
    use HasFactory;
    protected $table='inventory_item_transfers';
    protected $fillable=['from_warehouse_id','to_warehouse_id','inventory_item_id'];

   
}
