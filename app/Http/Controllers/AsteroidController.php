<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AsteroidController extends Controller
{
    protected $api_url;

    public function __construct()
    {
        $this->api_url = 'https://api.nasa.gov/neo/rest/v1/feed?api_key=9tVh7kPc6CG3IEjmYO1Zb8IkQhk9EgY34RxO1kLw';
    }

    public function getAstroidDataByDateRange(Request $request)
    {
        $url = $this->api_url . '&start_date=' . $request->startDate . '&end_date=' . $request->endDate;
        $output = $this->callAPI('GET', $url, false);
        $response = json_decode($output, true);
        $result = $this->asteroidResult($response);
        return ['data' => $response, 'result' => $result];
    }

    private function asteroidResult($neo_api_data)
    {
        $result = array(
            'fastest_aseroid_id' => 0,
            'fastest_aseroid' => 0,
            'closest_aseroid_id' => 0,
            'closest_aseroid' => 0,
            'avarage_size_aseroid' => 0,
        );

        $count = 0;
        foreach ($neo_api_data['near_earth_objects'] as $value) {
            $astroids = array_values($value);
            $count += count($astroids);
            foreach ($astroids as $astroid) {
                $result['avarage_size_aseroid'] += $astroid['estimated_diameter']['kilometers']['estimated_diameter_max'];
                foreach ($astroid['close_approach_data'] as $close_approach_data) {
                    if ($close_approach_data['relative_velocity']['kilometers_per_hour'] > $result['fastest_aseroid']) {
                        $result['fastest_aseroid_id'] = $astroid['id'];
                        $result['fastest_aseroid'] = $close_approach_data['relative_velocity']['kilometers_per_hour'];
                    }
                    if ($close_approach_data['miss_distance']['kilometers'] < $result['closest_aseroid'] || $result['closest_aseroid_id'] == 0) {
                        $result['closest_aseroid_id'] = $astroid['id'];
                        $result['closest_aseroid'] = $close_approach_data['miss_distance']['kilometers'];
                    }
                }
            }
        }

        $result['avarage_size_aseroid'] = $result['avarage_size_aseroid'] / $count;
        return $result;
    }

    private function callAPI($method, $url, $data)
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        return $result;
    }
}
