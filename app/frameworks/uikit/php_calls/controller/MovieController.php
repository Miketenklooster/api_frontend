<?php
namespace controller;

require "../vendor/autoload.php";

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class MovieController
{
    /**
     * @var Client
     */
    private $client;

    /**
     * MovieController constructor.
     */
    public function __construct()
    {
        /**
         * basis url 127.0.0.1:8000
         */
        $this->client = new Client(["base_uri" => "127.0.0.1:8000"]);
    }

    /**
     * get all movies
     * @param $authorization
     * @return ResponseInterface
     */
    public function getAll($authorization)
    {
        return $this->client->request('GET', "/api/v8/movie", ['headers'=> ['Authorization' => 'Bearer '.$authorization]]);
    }

    /**
     * @param $id
     * @param $authorization
     * @return ResponseInterface
     */
    public function getOne($id, $authorization)
    {
        return $this->client->request('GET', "/api/v8/movie/$id", ['headers'=> ['Authorization' => 'Bearer '.$authorization]]);
    }

}

