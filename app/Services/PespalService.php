<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class PesaPalService {

    protected Client $client;
    protected string $baseUrl;
    protected string $apiKey;
    protected string $apiSecret;

    public function __construct() {
        $this->baseUrl   = config('services.pesapal.url');
        $this->apiKey    = config('services.pesapal.key');
        $this->apiSecret = config('services.pesapal.secret');
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 30.0,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    protected function authenticate()
    {
        try {
            $response = $this->client->post(
                config('services.pesapal.endpoints.auth'), 
                [
                    'json' => [
                        'consumer_key'    => $this->apiKey,
                        'consumer_secret' => $this->apiSecret
                    ]
                ]
            );

            return json_decode($response->getBody()->getContents());
        } catch(GuzzleException $error) {
            Log::error('PesaPal Authentication Error: ' . $error->getMessage());
            throw $error;
        }
    }

    public function request(string $method, string $endpoint, array $data = [])
    {
        try {
            $response = $this->client->request($method, $endpoint, [
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch(GuzzleException $error) {
            Log::error("PesaPal Request Error: {$method} {$endpoint}", [
                'message' => $error->getMessage(),
                'data' => $data
            ]);
            throw $error;
        }
    }    

     /**
     * Create an order with Pesapal
     *
     * @param array $data
     * @param string $auth
     * @return mixed
     * @throws GuzzleException
     */
    public function order(array $data, string $auth)
    {
        try {
            $response = $this->client->post(
                config('services.pesapal.endpoints.order_request'),
                [
                    'headers' => ['Authorization' => "Bearer {$auth}"],
                    'json' => Arr::only($data, [
                        'id',
                        'currency',
                        'amount',
                        'description',
                        'callback_url',
                        'notification_id',
                        'billing_address'
                    ])
                ]
            );

            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $error) {
            Log::error('PesaPal Order Error: ' . $error->getMessage());
            throw $error;
        }
    }

    /**
     * Register IPN URL with Pesapal
     *
     * @param array $data
     * @param string $auth
     * @return mixed
     * @throws GuzzleException
     */
    public function registerIPN(array $data, string $auth)
    {
        try {
            $response = $this->client->post(
                config('services.pesapal.endpoints.register_ipn'),
                [
                    'headers' => ['Authorization' => "Bearer {$auth}"],
                    'json' => [
                        'url' => $data['url'],
                        'ipn_notification_type' => $data['ipn_notification_type']
                    ]
                ]
            );

            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $error) {
            Log::error('PesaPal IPN Registration Error: ' . $error->getMessage());
            throw $error;
        }
    }

    /**
     * Get transaction status from Pesapal
     *
     * @param string $orderId
     * @param string $auth
     * @return mixed
     * @throws GuzzleException
     */
    public function transactionStatus(string $orderId, string $auth)
    {
        try {
            $response = $this->client->get(
                config('services.pesapal.endpoints.status') . "?orderTrackingId={$orderId}",
                [
                    'headers' => ['Authorization' => "Bearer {$auth}"]
                ]
            );

            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $error) {
            Log::error('PesaPal Transaction Status Error: ' . $error->getMessage());
            throw $error;
        }
    }

    /**
     * Cancel a transaction in Pesapal
     *
     * @param string $orderTrackingId
     * @param string $auth
     * @return mixed
     * @throws GuzzleException
     */
    public function cancelTransaction(string $orderTrackingId, string $auth)
    {
        try {
            $response = $this->client->post(
                config('services.pesapal.endpoints.cancel'),
                [
                    'headers' => ['Authorization' => "Bearer {$auth}"],
                    'json' => ['order_tracking_id' => $orderTrackingId]
                ]
            );

            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $error) {
            Log::error('PesaPal Cancel Transaction Error: ' . $error->getMessage());
            throw $error;
        }
    }
}