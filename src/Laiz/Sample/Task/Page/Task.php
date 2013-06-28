<?php

namespace Laiz\Sample\Task\Page;

use Laiz\Db\Db;
use Laiz\Db\Vo;
use Laiz\Db\Vo\Task as Vo_Task;
use Laiz\Db\Exception;
use Laiz\Session\Message;
use Laiz\Session\Exception\RedirectMessageException;
use Laiz\Core\Annotation\Validator;
use Zend\Authentication\AuthenticationService;
use Laiz\Session\TransactionToken;
use Laiz\Request\Exception\RedirectException;

use Laiz\Sample\Task\ViewModel\Pager;

class Task
{
    public $action;
    public $pager;
    public $TASKS;

    /**
     * @var TransactionToken
     * @Validator("transactiontoken.ini")
     */
    public $transaction;

    /**
     * @var Vo_Task
     * @Validator("task.ini")
     */
    public $task;

    /**
     * @Validator("check.ini")
     * @var bool
     */
    public $check;

    public function index(Db $db)
    {
        $iterator = $db->from('Task')
            ->order(array('subject', 'taskId'))
            ->iterator();

        $pager = new Pager($iterator, 5);
        $this->pager = $pager->getHtml();
        $this->TASKS = $iterator;
    }

    public function info()
    {
        if (!$this->task->taskId)
            // task_edit.html => push back button
            throw new RedirectException('/task.html');
    }

    public function add(Db $db, AuthenticationService $auth, $valid = null)
    {
        $this->action = "Create New Task";
        if ($valid === null)
            $this->task->userName = $auth->getIdentity();

        $this->editInternal($db, $valid, 'Task was created.');
        return 'task_edit.html';
    }
    public function edit(Db $db, $valid = null)
    {
        $this->action = "Edit the Task";
        if ($valid === true)
            $this->task->updatedAt = date('Y-m-d H:i:s');

        $this->editInternal($db, $valid, 'Task was edited.');
    }
    private function editInternal($db, $valid, $msg)
    {
        if ($valid !== true)
            return;

        try {
            $db->save($this->task);
            throw new RedirectMessageException('/task_info.html?task[taskId]='
                                               . $this->task->taskId,
                                               $msg,
                                               Message::SUCCESS);
        }catch (Exception $e){
            Message::add($e->getMessage(), Message::ERROR);
        }
    }
    public function delete(Db $db)
    {
        try {
            $db->delete($this->task);
            throw new RedirectMessageException('/task.html',
                                               'Task was deleted.',
                                               Message::SUCCESS);
        }catch (Exception $e){
            Message::add($e->getMessage(), Message::ERROR);
            return;
        }
    }
}
