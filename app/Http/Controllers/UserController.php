<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;

class UserController extends Controller
{
    public function save(UserRepository $repo)
    {
        return $repo->save([
            'name' => 'John Doe',
            'email' => 'test@gmail.com',
            'password' => bcrypt(request('password'))
        ]);
    }
}
