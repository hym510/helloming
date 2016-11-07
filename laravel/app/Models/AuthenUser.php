<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class AuthenUser implements AuthenticatableContract
{
    use Authenticatable;

    public $user;

    public function __construct($userId)
    {
       $this->user = $userId;
   }
}
