<?php

namespace Laiz\Sample\Task\Model;

class MyModel
{
    public $name;
    public $value;
    public function __construct()
    {
    }

    public function assignValue($value)
    {
        $this->value = $value;
    }
}
