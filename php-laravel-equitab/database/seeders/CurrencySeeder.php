<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data from https://gist.github.com/ksafranski/2973986

        $file = file_get_contents(storage_path('app/currencies.json'));
        $currencies = array_values(json_decode($file, true));
        $currencies = array_map(fn($c) => [
            'code' => $c['code'],
            'name' => $c['name'],
            'symbol' => $c['symbol_native']
        ], $currencies);

        Currency::insert($currencies);
    }
}
