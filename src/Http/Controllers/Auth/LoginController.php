<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 19.10.2022
 * Time: 12:21
 */

namespace AppTesting\Http\Controllers\Auth;


use AppTesting\OrderPlacedEvent;
use Illuminate\Http\Request;


class LoginController
{

    public function login(Request $request)
    {
        $email = $request->get('email');
        $Json = new \Illuminate\Http\JsonResponse(array(
            'token' => $email,
            'expires_in' => $email,
            'token_type' => 'bearer'
        ));
        $Response = new \Illuminate\Http\Response($Json->getContent(), 200, [
            'Content-Type' => $request->header('Content-Type'),
        ]);
        return $Response;
    }


    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $token = $request->get('token');
        $Response = new \Illuminate\Http\Response('', 200, [
            'Content-Type' => $request->header('Content-Type'),
        ]);
        return $Response;
        #$this->guard()->logout();
    }


    public function current(Request $request)
    {
        $email = $request->get('email');
        $Json = new \Illuminate\Http\JsonResponse(array(
            'email' => $email,
        ));
        $Response = new \Illuminate\Http\Response($Json->getContent(), 401, [
            'Content-Type' => $request->header('Content-Type'),
        ]);
        return $Response;
    }
}
