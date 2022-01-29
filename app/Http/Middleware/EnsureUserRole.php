<?php


namespace App\Http\Middleware;
use App\Exceptions\ForbiddenException;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, $role){
        $user = Auth::user();
        if($user->role == $role){
            return $next($request);
        }
        throw new ForbiddenException("You don't have access");

    }
}
