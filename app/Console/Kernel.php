<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

use Illuminate\Support\Facades\DB;

use App\Models\countries;
use App\Models\statistics;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
                    // Getting Country Data
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'https://devtest.ge/countries');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    
                    
                    $headers = array();
                    $headers[] = 'Accept: application/json';
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    
                    $countries = json_decode(curl_exec($ch));
                    if (curl_errno($ch)) {
                        return "Error Fetching Country Data.";
                    }
                    curl_close($ch);
                
                // Writing Data in DB
                    foreach ($countries as $c) {
                        
                        //Checking if DB has country or not;
                            $checkCountryInDB = count(DB::table('countries')->where('code', '=', "$c->code")->get());
                            
                            if ( !$checkCountryInDB ){
                                $cTable = new countries;
                                $cTable->code = $c->code;
                                $cTable->name = json_encode($c->name);
                                $cTable->save();
                            }
        
                        
                        // Second part Getting statistics
                            
                            $code = "{\n  \"code\": \"" . $c->code . "\"\n}";
        
                            $ch = curl_init();
                
                            curl_setopt($ch, CURLOPT_URL, 'https://devtest.ge/get-country-statistics');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $code);
                        
                            $headers = array();
                            $headers[] = 'Accept: application/json';
                            $headers[] = 'Content-Type: application/json';
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        
                            $countryDetails = json_decode(curl_exec($ch));
                    
                             
                            if (curl_errno($ch)) {
                                return "Error Fetching Country Statistics Data.";
                            }
                            curl_close($ch);
                            
                        // Writing Statisctics in DB
                            $country_id = DB::table('countries')->where('code', '=', $countryDetails->code)->get('id')[0]->id;
        
                            $checkStatIfExists = DB::table('statistics')->where('country_id', '=', $country_id)->get('id');
                            
        
                            // Checking if statisctics already there.
                            if ( count($checkStatIfExists) > 0 ){
                                $StatID = $checkStatIfExists[0]->id;
        
                                $statistics = statistics::find($StatID);
                                $statistics->country_id = $country_id;
                                $statistics->confirmed = $countryDetails->confirmed;
                                $statistics->recovered = $countryDetails->recovered;
                                $statistics->death = $countryDetails->deaths;
                                $statistics->save();
                            }else{
                                $statistics = new statistics;
                                $statistics->country_id = $country_id;
                                $statistics->confirmed = $countryDetails->confirmed;
                                $statistics->recovered = $countryDetails->recovered;
                                $statistics->death = $countryDetails->deaths;
                                $statistics->save();
                            }
                           
                    }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
