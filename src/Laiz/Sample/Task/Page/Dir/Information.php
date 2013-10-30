<?php

namespace Laiz\Sample\Task\Page\Dir;

use Laiz\Sample\Task\Model\MyModel;
use Laiz\Core\Annotation\Converter;
use Laiz\Sample\Task\Converter\PlusLengthConverter;
use Laiz\Sample\Task\Dto\DataShared;
use Laiz\Sample\Task\Dto\DataPrototype;

/**
 */
class Information
{
    /**
     * @Converter(["upper", PlusLengthConverter])
     */
    public $plainText;

    /** @var int */
    public $id;

    /** @var bool */
    public $flag;

    /**
     * @var stdClass
     */
    public $obj;

    /**
     * @var DataShared
     */
    public $shared1;
    /**
     * @var DataShared
     */
    public $shared2;

    /**
     * @var DataPrototype
     */
    public $proto1;
    /**
     * @var DataPrototype
     */
    public $proto2;

    public $showText;

    /**
     * @var MyModel
     * @Converter(["name" => "wordseparatortocamelcase",
     *             "value" => ["wordseparatortodash", "upper"]])
     */
    public $model;

    public function act(\stdClass $stdClass)
    {
        $this->varStdClass = var_export($stdClass, 1);

        $this->varPlainText = var_export($this->plainText, 1);
        $this->varId = var_export($this->id, 1);
        $this->varFlag = var_export($this->flag, 1);
        $this->varObj = var_export($this->obj, 1);
        $this->varModel = var_export($this->model, 1);

        $this->showText = 'Hello';
        $this->model->assignValue('otherText', 'World!');

        $this->shared = var_export($this->shared1 === $this->shared2, 1);
        $this->proto  = var_export($this->proto1 === $this->proto2, 1);
    }
}
