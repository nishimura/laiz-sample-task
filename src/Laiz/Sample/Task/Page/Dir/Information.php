<?php

namespace Laiz\Sample\Task\Page\Dir;

use Laiz\Sample\Task\Model\MyModel;
use Laiz\Core\Annotation\Converter;
use Laiz\Sample\Task\Converter\PlusLengthConverter;

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
    }
}
