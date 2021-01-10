<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Log;

class CustomDbException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {

    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return \response()->json(['error' => $this->getMessage(), 'code' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
    }
}