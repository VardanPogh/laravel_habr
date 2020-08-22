<?php

use App\GeneralCategories;
use Illuminate\Database\Seeder;

class GeneralCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'name' => 'Servizi Digitali',
            ],
            [
                'name' => 'Servizi Energia',
            ],
            [
                'name' => 'Servizi Persona',
            ]
        ];

        foreach($datas as $data){
            GeneralCategories::create($data);
        }
    }
}
