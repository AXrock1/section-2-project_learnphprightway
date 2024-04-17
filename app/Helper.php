<?php

namespace App;

class Helper
{
    public function formatteDollar(float $amount): string
    {
        $isNegative = $amount < 0;
        return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
    }

    public function formatDate(string $date): string
    {

        return date('M j, Y', strtotime($date));
    }
}
