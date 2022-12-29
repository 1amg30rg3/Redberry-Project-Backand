<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

use Illuminate\Support\Facades\DB;

use App\Models\countries;
use App\Models\statistics;

class countryDataController extends Controller
{

    public function getCountryDetails(){
        $countries = countries::get();

        if ( is_countable($countries) && count($countries) == 0 ){
            return response()->json([
                'status' => "database is empty",
            ]);
        }

        foreach ($countries as $c) {
            $statistics = statistics::where('country_id', $c->id)->first();
            

            if ( is_countable($statistics) && count($statistics) == 0 ){
                return response()->json([
                    'status' => "database is empty",
                ]);
            }

            $c->name_en = json_decode($c->name)->en;
            $c->name_ka = json_decode($c->name)->ka;
            unset($c->name);

            $c->confirmed = $statistics->confirmed;
            $c->recovered = $statistics->recovered;
            $c->death = $statistics->death;

        }

        return $countries;
    }

    public function getCountryDetailsTotal(){
        $countries = countries::get();

        if ( is_countable($countries) && count($countries) == 0 ){
            return response()->json([
                'status' => "database is empty",
            ]);
        }

        $totalConfirmed = 0;
        $totalRecovered = 0;
        $totalDeath = 0;

        foreach ($countries as $c) {
            $statistics = statistics::where('country_id', $c->id)->first();

            if ( is_countable($statistics) &&  count($statistics) == 0 ){
                return response()->json([
                    'status' => "database is empty",
                ]);
            }

            $totalConfirmed += $statistics->confirmed;
            $totalRecovered += $statistics->recovered;
            $totalDeath += $statistics->death;    
        }

        return response()->json([
            "totalConfirmed" => number_format($totalConfirmed, 0, ',', ' '),
            "totalRecovered" => number_format($totalRecovered, 0, ',', ' '),
            "totalDeath" =>  number_format($totalDeath, 0, ',', ' ')
        ]);
    }
}
