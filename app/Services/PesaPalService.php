<?php
namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PesaPalService {

    protected $client;

    public function __construct() {
        $this->client = Http::baseUrl(config("services.pesapal.base_url.".config('services.pesapal.configuration.status')))
                            ->withHeaders([
                                'Accept'       => 'application/json',
                                'Content-Type' => 'application/json'
                            ]);                  
    }

    public function authenticate()
    {
        try {
            $response = $this->client->post(
                config('services.pesapal.endpoints.auth'), 
                [
                    'consumer_key'    => config('services.pesapal.configuration.consumer_key'),
                    'consumer_secret' => config('services.pesapal.configuration.consumer_secret')
                ]
            );

            return json_decode($response->getBody()->getContents());
        } catch(HttpException $error) {
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
        } catch(HttpException $error) {
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
     * @throws HttpException
     */
    public function order(array $data, string $auth)
    {
        try {
            return Http::baseUrl(config("services.pesapal.base_url.".config('services.pesapal.configuration.status')))
                        ->withHeaders([
                            'Accept'       => 'application/json',
                            'Content-Type' => 'application/json',
                            'Authorization' => "Bearer {$auth}"])
                        ->post(
                            config('services.pesapal.endpoints.orderRequest'),
                            Arr::only($data, [
                                'id',
                                'currency',
                                'amount',
                                'description',
                                'callback_url',
                                'notification_id',
                                'billing_address'
                            ])
                        )
                        ->throw()
                        ->json();            

        } catch (HttpException $error) {
            Log::error('PesaPal Order Error: ' . $error->getMessage());
            throw $error;
        } catch(RequestException $error){
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
     * @throws HttpException
     */
    public function registerIPN(array $data, string $auth)
    {
        try {
            
            return $this->client
                        ->withHeaders(['Authorization' => "Bearer {$auth}"])
                        ->post(config('services.pesapal.endpoints.registeripn'),$data)
                        ->throw()
                        ->json();

        } catch (HttpException $error) {

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
     * @throws HttpException
     */
    public function transactionStatus(string $trackingId, string $auth)
    {
        try {

            return $this->client
                        ->withHeaders(['Authorization' => "Bearer {$auth}"])
                        ->get(config('services.pesapal.endpoints.status') . "?orderTrackingId={$trackingId}")
                        ->json();

        } catch (HttpException $error) {
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
     * @throws HttpException
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
        } catch (HttpException $error) {
            Log::error('PesaPal Cancel Transaction Error: ' . $error->getMessage());
            throw $error;
        }
    }
}