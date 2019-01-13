<?php

namespace App\Http\Controllers;

use App\Response;

use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * The app controller.
 *
 * @author igronus
 */
class AppController extends Controller
{
    /**
     * Getting devices data.
     *
     * @param Request $request
     *
     * @return string
     */
    public function fetchData(Request $request)
    {
        try {
            $devices = unserialize(config('app.devices'));


            $data = [];

            foreach ($devices as $key => $device) {
                $d = new \stdClass();
                $d->name = $key;
                $d->rawData = file_get_contents($device);

                $data[] = $d;
            }
        } catch (\Exception $e) {
            return new Response(false, $e->getMessage());
        }

        return new Response(true, $data);
    }

    /**
     * Emulating devices data.
     *
     * @param Request $request
     *
     * @return string
     */
    public function emulateData(Request $request)
    {
        $datetime = Carbon::now()->toDateTimeString();

        $registers = [
            21 => rand(64000, 65000),

            33 => rand(14000, 15000),
            34 => rand(16000, 17000),

            92 => rand(700, 999),
        ];

        return view('feed', compact('datetime', 'registers'));
    }
}
