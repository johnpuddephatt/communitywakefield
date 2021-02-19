<?php

namespace App\Traits;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

trait WardTrait {
    public function getWardData($postcode) {
        if($postcode) {
            try  {
                $client = new Client(['http_errors' => false]);

                $response = $client->request('GET', 'https://api.postcodes.io/postcodes/' . $postcode);
                if ($response->getStatusCode() == 200) {
                    $response_body = $response->getBody();
                    $response_json = json_decode($response_body, true);
                    return $response_json['result']['admin_ward'];
                }
            }
            catch (Exception $e) {

            }
        }
        return null;
     }
}
