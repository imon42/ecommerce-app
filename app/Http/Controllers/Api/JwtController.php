<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenDecoded;

class JwtController extends Controller
{
    //token create;
    public static function createToken()
    {

        $secretKey = env('JWT_SECRECT_KEY');

        $payload = [
            'iat' => time(),
            'exp' => time() + 3600,
        ];

        $tokenDecoded = new TokenDecoded([
            'payload' => $payload,
        ]);

        $tokenEncoded = $tokenDecoded->encode($secretKey, JWT::ALGORITHM_HS256);

        $token = $tokenEncoded->toString();

        return response()->json([
            'message' => 'token created successfull',
            'token' => $token,
        ])->cookie('jwt_token', $token, 60, null, null, false, true);
    }

    //remove jwt token from cookies;
    public function removeToken()
    {
        return response()->json(['message' => 'token removed successfull'])->cookie('jwt_token', '', -1);
    }
}
