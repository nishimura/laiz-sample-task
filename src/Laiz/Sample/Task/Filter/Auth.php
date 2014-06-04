<?php

namespace Laiz\Sample\Task\Filter;

use Laiz\Session\Auth\Auth as LaizAuth;

class Auth extends LaizAuth
{
    public function accept($path)
    {
        if (preg_match('|^/$|', $path) ||
            preg_match('|^/login\.html$|', $path) ||
            preg_match('|^/session_.+\.html$|', $path) ||
            preg_match('|^/dir/|', $path)
            )
            return false;

        return true;
    }


    public function preFilter()
    {
        $this->filter();
    }
}
