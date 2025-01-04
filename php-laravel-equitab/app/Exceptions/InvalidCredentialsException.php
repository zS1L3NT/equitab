<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvalidCredentialsException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    public function render(): Response
    {
        return response([
            'error' => [
                'type' => 'Invalid credentials',
                'message' => 'The username or password provided is incorrect.'
            ]
        ], \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);
    }
}
