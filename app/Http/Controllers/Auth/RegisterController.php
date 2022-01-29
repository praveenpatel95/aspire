<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\BadRequestException;
use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request, AuthService $authService){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:6',
            'password_confirmation'=>'required|min:6',
        ]);
        if ($validator->fails()) {
            throw new BadRequestException($validator->errors()->first());
        }
        $register = $authService->create($request->all());
        return JsonResponse::success($register);
    }
}
