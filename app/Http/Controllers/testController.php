<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

class testController extends Controller
{
	public function test(){
		$client = new \GuzzleHttp\Client(['auth' => ['username', 'password'],'base_uri' => 'http://mflf.io/ss-dev/api/']);
		$response = $client->request('POST', 'v1.0/users/login', [
		    'form_params' => [
		        'username' => 'lapat@doitung.org',
		        'password' => '107043',
		    ]
		]);
		
		$clientHandler = $client->getConfig('handler');
		// Create a middleware that echoes parts of the request.
		dd($clientHandler);
	}
}
