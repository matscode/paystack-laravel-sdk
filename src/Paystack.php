<?php

namespace Matscode\PaystackLaravel;

use Matscode\Paystack\Paystack as PS;

class Paystack extends PS
{
    // A neccesary evil to support laravel facades
    public function __call($method, $arguments)
    {
        return $this->{$method};
    }
}
