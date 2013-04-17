<?php

namespace Laiz\Sample\Task\Converter;

class PlusLengthConverter
{
    public function __invoke($value)
    {
        return $value . ':' . strlen($value);
    }
}
