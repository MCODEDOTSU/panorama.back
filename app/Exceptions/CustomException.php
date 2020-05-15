<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
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
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \App\Exceptions\CustomException)  {
            return $exception->render($request);
        }

        return parent::render($request, $exception);
    }
}