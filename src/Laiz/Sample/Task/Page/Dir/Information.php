<?php

namespace Laiz\Sample\Task\Page\Dir;

use Laiz\Sample\Task\Model\MyModel;
use Laiz\Sample\Task\Converter\PlusLengthConverter;
use Laiz\Sample\Task\Dto\DataShared;
use Laiz\Sample\Task\Dto\DataPrototype;
use stdClass;

/**
 */
class Information
{
    public $varStdClass;
    public $varPlainText;

    public $plainText;

    /**
     * @var Laiz\Sample\Task\Model\MyModel
     */
    public $model;

    /**
     * @var int
     */
    public $id;

    /**
     * @var boolean
     */
    public $flag;

    /**
     * @bind model
     * @bind id
     * @bind flag
     */
    public function index(stdClass $stdClass)
    {
        $this->varStdClass = var_export($stdClass, 1);

        $this->varPlainText = var_export($this->plainText, 1);

        $this->showText = 'Hello';

        $this->varId = var_export($this->id, 1);
        $this->varFlag = var_export($this->flag, 1);
        $this->model->assignValue('World!');
        $this->varModel = var_export($this->model, 1);
    }
}
