<?php

namespace Laiz\Sample\Task\Page;

use Laiz\Session\Exception\RedirectMessageException;
use Laiz\Session\Auth\Auth;
use Laiz\Session\Message;

class Session
{
    public $id;
    public $password;

    public function delete(Auth $auth)
    {
        $auth->logout();
        throw new RedirectMessageException('/', 'logout now');
    }
    public function add(Auth $auth)
    {

        $result = $auth->login($this->id, $this->password);
        if ($result->isValid())
            $auth->resumeUri('/');
        else
            throw new RedirectMessageException('/login.html',
                                               'incorrect id or password',
                                               Message::ERROR);
    }
}
