<?php

namespace App\Domains\Suppliers\Pipelines;

use Closure;

class SanitizeMonthlyPayment
{
    /**
     * Handle an incoming data.
     *
     * @param  string|float  $monthlyPayment
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($monthlyPayment, Closure $next): float
    {
        $sanitizeMonthlyPayment = convert_currency_from_PTRB($monthlyPayment);
        $sanitizeMonthlyPayment = filter_var($sanitizeMonthlyPayment, FILTER_SANITIZE_STRING);
        $sanitizeMonthlyPayment = number_format($sanitizeMonthlyPayment, 2, '.', '');

        // to the next pipe
        return $next($sanitizeMonthlyPayment);
    }
}
