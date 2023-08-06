<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies' ;
    protected $fillable = [
        'id',
        'company_name',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function index() {
        $companies = DB::table('companies')->get();
        return $companies;
    }


}
