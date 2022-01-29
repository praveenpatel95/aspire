<?php


namespace App\Services\Auth;


use App\Exceptions\BadRequestException;
use App\Http\Helpers\JsonResponse;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($username, $password){
        $user = $this->userRepository->getByUsername($username);
        if(!$user || !Hash::check($password, $user->password)){
            return null;
        }
        return $user->withToken();
    }

    public function create($data){
        try{
            $user = $this->userRepository->create($data);
            return $user->withToken();
        }
        catch (\Exception $e){
            throw new BadRequestException($e->getMessage());
        }

    }
}
