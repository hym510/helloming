<?php

namespace App\Library\Token;

use App\Contracts\Token\ApiToken as ApiTokenContract;

class ApiToken implements ApiTokenContract
{
    public function genToken()
    {
        return md5(openssl_random_pseudo_bytes(16).microtime());
    }
}
