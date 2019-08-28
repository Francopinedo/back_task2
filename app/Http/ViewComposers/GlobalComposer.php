<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

// Para consumir APIs
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

class GlobalComposer {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
    	if (Auth::check()) {
			$client = new GuzzleHttpClient();
			$params['http_errors'] = false;

			$url = env('API_PATH').'favorites/fromUser/'.Auth::id();

			$res = $client->request('GET', $url, $params);
			$favorites = json_decode($res->getBody()->__toString(), TRUE)['data'];
			$view->with('favorites', $favorites);
		}
    }

}