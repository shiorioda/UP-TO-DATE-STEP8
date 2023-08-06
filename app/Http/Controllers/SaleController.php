<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

class SaleController extends Controller
{
    // 購入処理
    public function purchase(Request $request, $id) {
        $quantity = $request->input('quantity');
        DB::beginTransaction();

        try {
            $sale_model = new Sale();
            $message = $sale_model->purchase($quantity, $id);   
            DB::commit();

        } catch (\Exception $e){
            DB::rollback();
            return back();
        }
        return response()->json([
            'message' => $message
        ]);
        
    }
}

