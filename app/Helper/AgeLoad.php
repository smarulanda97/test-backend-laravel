<?php

namespace App\Helper;

class AgeLoad
    {
    /**
     * Returns age load base on real age
     *
     * @param int $age
     * @return float|int|void
     */
    public static function getDecimal(int $age) {
          switch ($age) {
              case $age >= 18 && $age <= 30:
                  return 0.6;
              case $age >= 31 && $age <= 40:
                  return 0.7;
              case $age >= 41 && $age <= 50:
                  return 0.8;
              case $age >= 61 && $age <= 70:
                  return 1;
      }
    }
}
