<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvemtoryItemController;
use App\Http\Controllers\Api\InventoryItemTransferController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\WarehouseInventoryItemController;
use App\Models\InventoryItemModel;
use App\Models\WarehouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('add_warehouse',[WarehouseController::class,'store']);
    Route::post('add_inventory_item',[InvemtoryItemController::class,'store']);
    Route::post('add_new_stock_transfer',[InventoryItemTransferController::class,'store']);
    Route::post('add_warehouse_inventory_item',[WarehouseController::class,'store_warehouse_inventory_item']);
});     
Route::get('inventory',[WarehouseController::class,'store_warehouse_inventory_item']);
Route::get('inventory_per_warehouse',[WarehouseInventoryItemController::class,'index']);
Route::get('warehouses/{id}/inventory',[WarehouseController::class,'show']);


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);



