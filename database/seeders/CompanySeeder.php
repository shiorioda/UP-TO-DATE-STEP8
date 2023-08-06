<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'company_name' => 'キリン',
        ]);
        Company::create([
            'company_name' => 'カナダドライ',
        ]);
        Company::create([
            'company_name' => 'サントリー',
        ]);
        

    }
}
