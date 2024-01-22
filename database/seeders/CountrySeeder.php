<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id'=>1, 'uuid'=>Str::uuid(), 'code'=>'id' ,'name'=>'Indonesia'],
            ['id'=>2, 'uuid'=>Str::uuid(), 'code'=>'en', 'name'=>'English'],
        ];
        
        
        Country::insert($data);
    }
}
