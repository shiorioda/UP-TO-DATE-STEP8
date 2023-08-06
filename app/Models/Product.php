<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{    
    use HasFactory;
    protected $table = 'products' ;
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'image_path',
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }
    
    public function index() {
        $products = DB::table('products')
            ->join('companies', 'products.company_id','=', 'companies.id')
            ->select('products.*','companies.company_name')
            ->paginate(5);
        return $products;
    }

    public function getProductSearch($searchProduct,$searchCompany,$min_price,$max_price,$min_stock,$max_stock) {
        $products = DB::table('products')
            ->join('companies', 'products.company_id','=', 'companies.id')
            ->select('products.*','companies.company_name');
            
            if($searchProduct) {
                $products->where('product_name', 'like', '%' . $searchProduct . '%');
            }
            if($searchCompany) {
                $products->where('companies.id', $searchCompany);
            }
            if($min_price) {
                $products->where('products.price', '>=',$min_price );
            }
            if($max_price) {
                $products->where('products.price', '<=',$max_price );
            }
            if($min_stock) {
                $products->where('products.stock', '>=',$min_stock );
            }
            if($max_stock) {
                $products->where('products.stock', '<=',$max_stock );
            }
        return $products->paginate(5);
    }

    public function store($data, $image_path) {
        $this->product_name = $data['product_name'];
        $this->price = $data['price'];
        $this->comment = $data['comment'];
        $this->stock = $data['stock'];
        $this->company_id = $data['company_id'];

        if ($image_path) {
            $original = $image_path->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            $image_path->move('storage/image', $name);
            $this->image_path=$name;
        }
        $this->save();
    }


    public function updateData($id, $data, $image_path) {
        $products = Product::find($id);
        $products->product_name = $data['product_name'];
        $products->price = $data['price'];
        $products->comment = $data['comment'];
        $products->stock = $data['stock'];
        $products->company_id = $data['company_id'];

        if ($image_path) {
            $original = $image_path->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            $image_path->move('storage/image', $name);
            $products->image_path=$name;
        }
        $products->save();
    }

    public function detail($id) {
        $products = DB::table('products')
            ->join('companies', 'products.company_id','=', 'companies.id')
            ->select('products.*','companies.company_name')
            ->where('products.id', $id)
            ->first();
        return $products;
    }

    public function deleteProduct ($id) {
        DB::table('products')->delete($id);
    }

    

}