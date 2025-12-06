<?php

namespace Database\Seeders;

use App\Categorie;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $cats = Categorie::cases();
        
        for ($i = 0; $i < 30; $i++){
            
            $newProd = New Product();
            $newProd->nome = $faker->word();
            $newProd->descrizione = implode(" ", $faker->paragraphs(rand(2, 4)));
            $newProd->categoria = $cats[array_rand($cats)];
            $taglie = [
                "XS",
                "S",
                "M",
                "L",
                "XL",
                "XXL",
            ];
            $scelte = collect($taglie)->shuffle()->take(rand(2, count($taglie)))->values()->all();
            $newProd->taglie = $scelte;
            $newProd->img = "prod_$i.jpg";
            $newProd->prezzo = rand(35, 120);
            $isDiscounted =  $faker->boolean("30");
            $newProd->scontato = $isDiscounted;
            if ($isDiscounted) {
                $newProd->sconto = rand(5, 50);
            }
            
            $newProd->save();

        }

    }
}
