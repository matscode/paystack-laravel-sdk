<?php

namespace Matscode\PaystackLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Paystack extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'paystack';
    }
} 