<?php

namespace App\Rules;

use App\Models\InventoryItemModel;
use App\Models\InventoryStockModel;
use App\Models\WarehouseModel;
use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckInvItemStock implements Rule
{
    
     public function passes($attribute, $value)
    {

        $from_inv_id= request()->input("from_inv_id");
        $inv_item_id = request()->input("inv_item_id");
        $quantity=request()->input('quantity');
        return $this->check($from_inv_id, $inv_item_id,$quantity);


    }
     public function message()
    {
        $inv_item_id = request()->input("inv_item_id");
        $from_inv_id= request()->input("from_inv_id");
        $inv_item=InventoryItemModel::where('id',$inv_item_id)->first();
        $warehouse=WarehouseModel::where('id',$from_inv_id)->first();
        $inv_item_name=(isset($inv_item))?$inv_item->name:'';
        $warehouse_name=(isset($warehouse))?$warehouse->name:'';
        if($inv_item_name!=''&&$warehouse_name!=''){
        return 'Insufficient stock balance for '.$inv_item_name.'in '.$warehouse_name;

        }else{
        return 'Insufficient stock balance for the item in the warehouse';

        }
    }
     public function check($from_inv_id, $inv_item_id,$quantity) {
      
        $warehuse_item=InventoryStockModel::where(['inventory_item_id'=>$from_inv_id,'warehouse_id'=>$inv_item_id])->first();
        $item_qty=$warehuse_item->quantity;
        $final_qty= $item_qty-$quantity;
        if($final_qty<0){
            return false; 
        }else{
            return true;
        }
       
           
    }
}
