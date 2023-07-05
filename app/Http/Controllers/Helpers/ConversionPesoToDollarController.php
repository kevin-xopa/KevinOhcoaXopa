<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConversionPesoToDollarController extends Controller
{
    public function convertToDollars($cash)
    {
        $api_key = env('BANXICO_API_KEY');
        $api_url = "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno?token={$api_key}";

        $response = file_get_contents($api_url);
        $data = json_decode($response, true);

        $tasaCambio = $data['bmx']['series'][0]['datos'][0]['dato'];

        // conversion
        $dollars = $cash / $tasaCambio;

        return number_format($dollars, 2);
    }
}
