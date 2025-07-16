<?php

namespace App\Rules;

use App\Models\InventoryStockModel;
use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckWarehouseHasItem implements Rule
{
    
     public function passes($attribute, $value)
    {

        $item_id = request()->input("inventory_item_id");
        $warehouse_id = request()->input("warehouse_id");
        return $this->check($item_id, $warehouse_id);


    }
     public function message()
    {
        return 'item already in warehouse';
    }
     public function check($item_id, $warehouse_id) {
      
        $warehuse_item=InventoryStockModel::where(['inventory_item_id'=>$item_id,'warehouse_id'=>$warehouse_id])->exists();
        if(($warehuse_item)){
            return false; 
        }else{
            return true;
        }
       
           
    }
}
