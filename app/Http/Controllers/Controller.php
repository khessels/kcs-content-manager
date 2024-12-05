<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function criticalException($request, $e, $file, $function, $line, $payload = null): void
    {
        if(!empty($e)){
            error_log($e->getMessage());
        }
    }
}
