<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// Para consumir APIs
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Hace una llamada al api
     * @param  string $verb   GET; POST; etc
     * @param  string $route  Ruta sin tener en cuenta la url base del api
     * @param  array $params parametros segun el verbo
     */
    public function apiCall($verb, $route, $params = [])
    {
    	$client = new GuzzleHttpClient();
    	$params = ['form_params' => $params];
    	$params['http_errors'] = false;
        $res=$client->request($verb, env('API_PATH').$route, $params);
    	
        return $res;
        }

    public function getFromApi($verb, $route, $params = [])
    {
    	$client = new GuzzleHttpClient();
    	$params = ['form_params' => $params];
    	$params['http_errors'] = false;

    	$res = $client->request($verb, env('API_PATH').$route, $params);

    	return isset(json_decode($res->getBody()->__toString())->data)?json_decode($res->getBody()->__toString())->data:array();
    }
     public function iredmailApiCall($verb, $route, $params = [])
    {
        $client = new GuzzleHttpClient(['verify' => false]);
        $params = ['form_params' => $params];
        $params['http_errors'] = false;
        $res=$client->request($verb, env('IREDMAIL_API_HOST').$route, $params);

        return $res;
    }
}
