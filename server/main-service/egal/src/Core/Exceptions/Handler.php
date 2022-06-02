<?php

namespace Egal\Core\Exceptions;

use App\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        $debug = config('app.debug');

        if (!$debug) {
            return response()->json(['exception' => $e->getMessage()])->setStatusCode($e->getCode());
        } else {
            return parent::render($request, $e);
        }
    }
}
