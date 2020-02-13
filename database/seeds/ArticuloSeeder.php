<?php

use App\Articulo;
use Illuminate\Database\Seeder;

class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            DB::table('articulos')->truncate();

            Articulo::create([
                'nombre'=>'Raton',
                'categoria'=>'Electronica',
                'precio'=>15,
                'stock'=>20,
            ]);
        }
    }
}
