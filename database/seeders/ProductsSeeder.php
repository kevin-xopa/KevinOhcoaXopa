<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\ProductTranslation;
use Faker\Factory as Faker;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        Product::newFactory()->count(200)->create();

        $products = Product::get();
        foreach ($products as $key => $item) {
            $name = $faker->randomElement(
                [
                    "Cerveza Botella Schneider x 1 Un",
                    "REJILLA COMPACTA COL",
                    "REJ.SECAVAJ.43X55CM",
                    "REJILLA AUTO 50X50CM",
                    "LECHE L.V.ENTERA",
                    "Trapo Piso Blanco Consorcio x 1 Un",
                    "presentacion",
                    "Trapo Piso Gris Consorcio x 1 Un",
                    "Caguama",
                    "Trapo Piso Mil Usos x 1 Un",
                    "Salvo",
                    "PAÃ‘O FRANELA CALIDAD",
                    "Cerveza Blanca Botella Salta x 1 Un",
                    "ESQUELETO CERV BLANC",
                    "Cerveza Negra Botella Salta x 1 Un",
                    "ESQUELETO CERV NEGRA",
                    "ENVASE CERVEZA 1890",
                    "ESQUELETO CERV 1890",
                    "Huevo de Chocolate Kinder con Sorpresa Caja x 20 Gr",
                    "Desmaquillador de Ojos Bifasico en Botella Nivea x 125 Ml",
                    "Crema Facial Cuidado Nivea x 100 Ml",
                    "Desodorante Antitranspirante en Barra V8 Rexona x 50 Gr",
                    "Desodorante Stick Nutritivo Rexona x 50 Gr",
                    "Desodorante Original Dove x 50 Gr",
                    "Cerveza Corona x 335 Cc",
                    "Repelente Crema Off x 60 Gr",
                    "Galletitas BanÌƒadas con Chocolate con Relleno de Limon Terrabusi Tita x 18 Gr",
                    "Obleas Rellena Bagley Opera x 55 Gr",
                    "Obleas Rellena Bagley Opera x 92 Gr",
                    "Alfajor Mousse Triple Milka x 55 Gr",
                    "Alfajor Triple Dulce de Leche Terrabusi x 70 Gr",
                    "Whisky Criadores En Petaca x 195 Cc"
                ]


            );
            ProductTranslation::newFactory()->create([
                'name' => $name,
                'url' => Str::slug("$item->sku $name es", "-"),
                'language' => 'es',
                'product_id' => $item->id,
            ]);
            ProductTranslation::newFactory()->create([
                'name' => $name,
                'url' => Str::slug("$item->sku $name en", "-"),
                'language' => 'en',
                'product_id' => $item->id,
            ]);
        }
    }
}
