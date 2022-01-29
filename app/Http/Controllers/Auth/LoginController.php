<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\BadRequestException;
use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request, AuthService $authService){
        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required',
        ]);
        if($validator->fails()){
            throw new BadRequestException($validator->errors()->first());
        }
        $user = $authService->login($request->get('email'), $request->get('password'));
        if(!$user){
           return JsonResponse::fail(__('auth.failed'), 401);
        }
        return JsonResponse::success($user);

    }
}
