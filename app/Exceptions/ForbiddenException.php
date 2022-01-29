<?php

namespace App\Exceptions;

use App\Helpers\JsonResponse;
use Exception;
use Illuminate\Http\Request;

class ForbiddenException extends Exception
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(Request $request)
    {
        return JsonResponse::fail($this->message ?? __('auth.forbidden'),403);
    }
}
