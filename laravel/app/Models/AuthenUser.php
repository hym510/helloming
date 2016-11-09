<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class AuthenUser implements AuthenticatableContract
{
    use Authenticatable;

    protected $user;

    public function __construct($user)
    {
       $this->user = $user;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}
