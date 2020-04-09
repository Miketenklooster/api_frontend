<?php

namespace controller;

require "../vendor/autoload.php";

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class LoginController
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
     * @param $method
     * @param $type
     * @param $authorization
     * @return ResponseInterface
     */
    public function Login($method, $type, $authorization)
    {
        // bWlrZUB0ZXN0LmNvbToxMjM=    is gelijk aan    mike@test.com:123

        var_dump($this->client->request("POST", "/api/v8/login", ['headers' => ['Authorization' => "bWlrZUB0ZXN0LmNvbToxMjM="]]));
        //return $this->client->request($method, "/api/v3/login", ['headers' => ['Authorization' => $type . $authorization]]);
        //return "this";
    }
}

///**
// * create movie
// */
// $response = $client->request('POST', "/api/v3/movie",
//     [
//         'headers'=> ['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpZCI6IjQ1OTMzMDA5LWRkODQtNDE0Mi04N2Q4LTI4MjQ1YzcyMjcwOCIsImNyZWF0ZWRfYXQiOiIyMDIwLTAzLTIzVDEzOjUxOjQyKzAxMDAiLCJleHBpcmVzX2F0IjoiMjAyMC0wMy0yM1QxNDo1MTo0MiswMTAwIiwidXNlciI6eyJpZCI6IjQ1OTMzMDA5LWRkODQtNDE0Mi04N2Q4LTI4MjQ1YzcyMjcwOCIsInJvbGVzIjpbIlJPTEVfVVNFUiIsIlJPTEVfQURNSU4iXX19.hfEEWOa1eVQ1C96eX2IMS0pf8QCp2RuQ1PHZcJgDWLCsoctBf4ihKWBUxfnJzQTeEHAjyH6HkdmvVi5DYRAmt_49hxAX27HLBbaZsrzm0UOR5h9by8BietHywEoTvWYULbXEkzDHC9F5AiFmOJxhJdbK1NIbDDhQyn_5XR1PC1pItenRHYZ9--gps0at4rNSeyoB8Vg9_Kh5qtJfJ-T0NO5zNC-ou6Boz3USxFpLuh2LXtADfUKhg8k_wlx1zegwb8iNRTsxYwJFaJPM7C8-ZpDFQ-yBZNUds903q_6hl55OjdVdWZ7L0G_anDij9agnaJmD52q4FghGKY1WKTTByUThket_x7_G1AKcejNO_Kpmb6hZEK7zT22keSFT5XLkutVCfb1lZUk8NDwbevlZLAJFHy4P0_oFNkyKyMwPbAY-pMtVC1SVKHLVV0dB2e5_VDiKwIJ6ruGoM3z6qTwGJDWRCUZnmhfhD1iOYl3sjfuH-BNbyUeykiJOHjuRYWJAoW7jOY9bF-To8lEjfi17hTxeARk2jOtL1oOt87fnoYvuNIQbloYKDlCzrPSnpWjjthdPvBJSoeSUyRcWMTCM6PWB59YH1d4Y42jo2mw0j6JzVZJSPjna3GR839nt8cSz-phwVl7iTvtsjquJthQqjZQjYUOr3TAOYX1GRMr8m1k'],
//         'form_params'   => [
//                         'name'       => 'this title name 7',
//                         'description'=> 'This is the seventh description'
//                             ]
//     ]
// );

///**
// * Login / refresh token
// */
//$response = $client->request('POST', "api/v3/login",
//    [
//        'headers'=> ['Authorization' => ['email', 'password']]
//    ]
//);


//echo $response->getBody();
//use GuzzleHttp\Client;
//
// // Gives error because the port isn't open
// // Create a client with a base URI
// $client = new GuzzleHttp\Client(['base_uri' => 'https://127.0.0.1:8000/']);
// // Send a request to https://127.0.0.1/movie
// $response = $client->request('GET', 'movie');

