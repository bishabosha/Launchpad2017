<?php

namespace common\models;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\json_decode;

class GeoCoder
{
    private $client;

    function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param  $address \common\models\Address
     * @return \stdClass
     */
    public function geoCodeAddress($address) {
        $endpoint = "https://maps.googleapis.com/maps/api/geocode/json";
        try {
            $response = $this->client->get($endpoint, ['query' => [
                'address' => $address->fullFormat,
                'key' => \yii::$app->params['googleAPIKey']
            ]]);

            $rawBody = $response->getBody()->getContents();

            try {
                $resultArray = json_decode($rawBody);
            } catch (\InvalidArgumentException $e) {
                $resultArray = array();
            }

            return $resultArray;
        }catch (RequestException $e) {
            $response = $e->getResponse();

            if ($response instanceof ResponseInterface) {
                // sometimes the response body is thrown as an exception but should be parsed
                $rawBody = $e->getResponse()->getBody()->getContents();
                return json_decode($rawBody);
            }
        }
    }

    /**
     * @param  $address \common\models\Address
     * @return array
     * @throws Exception
     */
    public function makeLatLngFromAddress($address) {

        $coded = $this->geoCodeAddress($address);

        if (isset($coded)) {
            return $coded->results[0]->geometry->location;
        }
        return null;
    }
}