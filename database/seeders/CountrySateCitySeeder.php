<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySateCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = Country::create(['country_name' => 'United State']);

        $state = State::create(['country_id' => $country->id, 'state_name' => 'Florida']);

        City::create(['state_id' => $state->id, 'city_name' => 'Miami']);
        City::create(['state_id' => $state->id, 'city_name' => 'Tampa']);

        /*------------------------------------------
        --------------------------------------------
        India Country Data
        --------------------------------------------
        --------------------------------------------*/
        $country = Country::create(['country_name' => 'India']);

        $state = State::create(['country_id' => $country->id, 'state_name' => 'Gujarat']);

        City::create(['state_id' => $state->id, 'city_name' => 'Rajkot']);
        City::create(['state_id' => $state->id, 'city_name' => 'Surat']);
    }
}
