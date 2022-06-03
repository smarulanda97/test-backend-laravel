<?php

namespace App\Helper;

class Calculate
{
    /**
     * Returns the total value of a quotation according to ages, fixed rate and $quantityDays
     *
     * @param array $ages
     * @param int $quantityDays
     * @return mixed
     */
    public static function getQuotationTotal(array $ages, int $quantityDays) {
        return array_reduce($ages, function ($carry, $age) use ($quantityDays) {
            $ageLoad = AgeLoad::getDecimal((int) $age);
            $carry += (FixedRate::BY_DAY * $ageLoad * $quantityDays);
            return $carry;
        });
    }
}
