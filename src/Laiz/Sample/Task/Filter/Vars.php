<?php

namespace Laiz\Sample\Task\Filter;

use Laiz\Session\Message;
use Zend\Authentication\AuthenticationService;

class Vars
{
    /** @var int */
    public $LOGGED_IN;
    public $MESSAGES;
    public function filter(AuthenticationService $auth)
    {
        $this->MESSAGES = array();
        $messages = Message::removeMessages();
        foreach ($messages as $message){
            $alert = new \stdClass();
            $alert->alertType = $message['level'] ?: '';
            $alert->alertTypeText = ucfirst($alert->alertType);
            $alert->message = $message['message'];
            $this->MESSAGES[] = $alert;
        }
        $this->LOGGED_IN = $auth->hasIdentity();
    }
}
