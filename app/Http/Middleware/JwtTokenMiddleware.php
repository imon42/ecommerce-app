<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Nowakowskir\JWT\Exceptions\AlgorithmMismatchException;
use Nowakowskir\JWT\Exceptions\IntegrityViolationException;
use Nowakowskir\JWT\Exceptions\TokenExpiredException;
use Nowakowskir\JWT\Exceptions\TokenInactiveException;
use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenEncoded;
use Symfony\Component\HttpFoundation\Response;

class JwtTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $jwtToken = $request->cookie('jwt_token');

        if (!$jwtToken) {
            return response()->json(['message' => 'Unauthorized user']);
        }

        try {

            $secretKey = env('JWT_SECRECT_KEY');

            //validate token;
            $tokenEncoded = new TokenEncoded($jwtToken);
            $tokenEncoded->validate($secretKey, JWT::ALGORITHM_HS256);

            //decode token;
            $tokenDecoded = $tokenEncoded->decode();
            $payload = $tokenDecoded->getPayload();

            // Attach payload to the request for use in controllers
            $request->attributes->set('jwt_payload', $payload);
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token has expired'], 401);
        } catch (TokenInactiveException $e) {
            return response()->json(['message' => 'Token is not yet active'], 401);
        } catch (IntegrityViolationException | AlgorithmMismatchException $e) {
            return response()->json(['message' => 'Invalid token'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
