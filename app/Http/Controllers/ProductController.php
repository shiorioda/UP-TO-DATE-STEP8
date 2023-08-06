<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;




class ProductController extends Controller
{

    // 商品一覧画面
    public function index() {
        $product_model = new Product();
        $company_model = new Company();
        $products = $product_model->index();
        $companies = $company_model->index();
        return view('index', ['products' => $products,'companies' => $companies]);        
    }
    
    // 検索機能
    public function search(Request $request) {
        $search_product = $request->input('keyword');
        $search_company = $request->input('company');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');
        $min_stock = $request->input('min_stock');
        $max_stock = $request->input('max_stock');
        DB::beginTransaction();

        try {
            $product_model = new Product();
            $company_model = new Company();
            $companies = $company_model->index();
            $products = $product_model->getProductSearch($search_product, $search_company, $min_price, $max_price, $min_stock, $max_stock);
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            return back();
        }
        // return view('index', ['products' => $products,'companies' => $companies]);  
        return response()->json($products);
    }

    // 新規登録画面の表示
    public function create() {
        $company_model = new Company();
        $companies = $company_model->index();
        return view('create', ['companies' => $companies]);
    }

    // 新規登録
    public function store(ProductRequest $request) {
        $data = $request->all();
        $image_path = $request->file('image_path');
        DB::beginTransaction();

        try {
            $product_model = new Product();
            $product_model->store($data, $image_path);
            DB::commit();
            return redirect()->route('index')->with('success', config('message.create_success'));
        } catch (\Exception $e){
            return redirect()->route('index')->with('success', config('message.create_fail'));
        }
        
    }

    // 詳細画面の表示
    public function show ($id) {
        $product_model = new Product();
        $product = $product_model->detail($id);            
        return view('show',['product' => $product]);
    }

    // 編集画面の表示
    public function edit ($id) {
        $product_model = new Product();
        $company_model = new Company();
        $product = $product_model->detail($id);
        $companies = $company_model->index();

        return view('edit',['product' => $product, 'companies' => $companies]);
    }

    // 更新
    public function update(ProductRequest $request, $id) {
        $data = $request->all();
        $image_path = $request->file('image_path');
        DB::beginTransaction();

        try {
            $product_model = new Product();
            $product_model->updateData($id, $data, $image_path);
            DB::commit();
            return redirect()->route('index')->with('success',config('message.update_success'));
        } catch (\Exception $e){
            return redirect()->route('index')->with('success',config('message.update_fail'));

        }
    }

    // 削除
    public function destroy($id) {
        DB::beginTransaction();
        
        try {
            $model = new Product();
            $product = $model->deleteProduct($id);
            DB::commit();
            return response()->json([
                'message' => config('message.delete_success')
            ]);
        } catch (\Exception $e){
            return response()->json([
                'message' => config('message.delete_fail')
            ]);
        }
        // return redirect()->route('index')->with('success', config('message.delete_success'));

    }

    // 購入画面の表示
    public function cart($id) {
        $sale_model = new Sale();
        $product = $sale_model->detail($id);            
        return view('cart',['product' => $product]);       
    }

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
