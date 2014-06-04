<?php

namespace Laiz\Sample\Task\Page;

use Laiz\Db\Db;
use Laiz\Db\Exception;
use Laiz\Session\Message;
use Laiz\Session\Exception\RedirectMessageException;
use Zend\Authentication\AuthenticationService;
use Laiz\Request\Exception\RedirectException;

use Laiz\Sample\Task\ViewModel\Pager;

use Laiz\Sample\Task\RequestDatabaseMapper as Mapper;

class Task
{
    public $action;
    public $pager;
    public $TASKS;

    public function index(Db $db)
    {
        $iterator = $db->from('Task')
            ->order(array('subject', 'taskId'))
            ->iterator();

        $pager = new Pager($iterator, 5);
        $this->pager = $pager->getHtml();
        $this->TASKS = $iterator;
    }

    /**
     * @db Task
     */
    public $task;

    /**
     * @var boolean
     */
    public $check;

    /**
     * @bind task
     */
    public function info()
    {
        if (!$this->task->taskId)
            throw new RedirectException('/task.html');
    }

    /**
     * @bind task
     * @bind check
     */
    public function add(AuthenticationService $auth)
    {
        $this->action = "Create New Task";

        $this->task->userName = $auth->getIdentity();
        return 'task_edit.html';
    }

    public function _add()
    {
        $this->_save('task was created');
    }

    public function _validateAdd()
    {
        return $this->_validateEdit();
    }

    /**
     * @bind task
     * @bind check
     */
    public function edit()
    {
        $this->action = "Edit the Task";
        return;
    }

    public function _edit()
    {
        $this->task->updatedAt = date('Y-m-d H:i:s');
        $this->_save('task was updated');
    }

    public function _save($msg)
    {
        try {
            $this->task->save();
            throw new RedirectMessageException('/task_info.html?task[taskId]='
                                               . $this->task->taskId,
                                               $msg,
                                               Message::SUCCESS);
        }catch (Exception $e){
            Message::add($e->getMessage(), Message::ERROR);
        }
    }

    public function _validateEdit()
    {
        $ret = array();

        if (!$this->check)
            $ret['check'] = 'confirm is required';
        if (strlen($this->task->subject) === 0)
            $ret['task']['subject'] = 'subject is required';

        return $ret;
    }

    /**
     * @bind task
     */
    public function delete()
    {
        throw new RedirectMessageException('/task.html',
                                           'Task was deleted.',
                                           Message::SUCCESS);
    }

    public function _delete()
    {
        try {
            $this->task->delete();
        }catch (Exception $e){
            throw new RedirectMessageException('/task_edit.html?task[taskId]='
                                               . $this->task->taskId,
                                               $e->getMessage(),
                                               Message::ERROR);
        }
    }
}
