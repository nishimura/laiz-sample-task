<?php

namespace Laiz\Sample\Task\Model;

use Laiz\Core\Response;

class MyModel
{
    private $response;
    public $name;
    public $value;
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function assignValue($name, $value)
    {
        $this->response->$name = $value;
    }
}
