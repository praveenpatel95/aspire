<?php


namespace App\Repositories\User;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

    public function getByUsername($username){
        return User::where('email', $username)->first();
    }

    public function create($data){
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }


}
