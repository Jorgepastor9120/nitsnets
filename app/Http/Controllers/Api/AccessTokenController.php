<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class AccessTokenController extends Controller
{
    /**
     * Issue an access token for a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function issueToken(Request $request)
    {
        $params = [
            'grant_type' => 'password',
            'client_id' => $request->clientId,
            'client_secret' => $request->clientSecret,
            'email' => $request->username,
            'password' => $request->password,
            'scope' => '',
        ];

        $request->request->add($params);

        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
    }
}