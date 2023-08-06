<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales' ;
    protected $fillable = [
        'product_id',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function detail($id) {
        $products = DB::table('products')
            ->where('id', $id)
            ->first();
        return $products;
    }

    public function purchase($quantity, $id) {
        $product = DB::table('products')
            ->where('id', $id)
            ->first();
        if($product->stock >= $quantity) {
            $product->stock -= $quantity;

            DB::table('products')
                ->where('id', $id)
                ->update([
                    'stock' => $product->stock
                ]);

            DB::table('sales')
                ->insert([
                    'product_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);  
            return 'success';

        } else {
            return 'out of order';
        }
    }

    
}

