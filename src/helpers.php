<?php

if (!function_exists('paystack')) {
    /**
     * Get the Paystack SDK instance from the service container.
     *
     * @return \Matscode\PaystackLaravel\Paystack
     */
    function paystack()
    {
        return app('paystack');
    }
}