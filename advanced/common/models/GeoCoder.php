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
    private $endpoint;

    function __construct()
    {
        $this->endpoint = "https://maps.googleapis.com/maps/api/geocode/json";
        $this->client = new Client();
    }

    /**
     * @param  $address \common\models\Address
     * @return array
     * @throws Exception
     */
    public function makeLatLngFromAddress($address) {

        try {
            $response = $this->client->get($this->endpoint, ['query' => [
                'address' => $address->fullFormat,
                'key' => \yii::$app->params['googleAPIKey']
            ]]);

            $rawBody = $response->getBody()->getContents();

            try {
                $resultArray = json_decode($rawBody, true);
            } catch (\InvalidArgumentException $e) {
                $resultArray = array();
            }

            return $resultArray;
        } catch (ClientException $e) {
            throw new Exception($e->getResponse()->getBody());
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if ($response instanceof ResponseInterface) {
                // sometimes the response body is thrown as an exception but should be parsed
                $rawBody = $e->getResponse()->getBody()->getContents();
                return json_decode($rawBody, true);
            }

            throw new Exception($e->getMessage());
        }
    }
}