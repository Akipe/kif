<?php

namespace Akipe\Lib\Test;

use DateTimeImmutable;
use Exception;

class DateTimeFormatGeneration
{
    public static function get(string $format, string $input): DateTimeImmutable
    {
        $dateFormatted = DateTimeImmutable::createFromFormat($format, $input);

        if (empty($dateFormatted)) {
            throw new Exception(
                'Can\'t format date "' . $input . '" into ' . $format
            );
        }

        return $dateFormatted;
    }
}
