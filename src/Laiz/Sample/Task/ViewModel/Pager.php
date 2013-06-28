<?php

namespace Laiz\Sample\Task\ViewModel;

use Laiz\Db\Pager as Db_Pager;


class Pager extends Db_Pager
{
    public function __construct($iterator, $pageCount = 10, $pageLength = 10)
    {
        parent::__construct($iterator, $pageCount, $pageLength, 'n');

        $this->setDecoratePrefix('<li>');
        $this->setDecorateSuffix('</li>');
        $this->setDecorateCurrentPrefix('<li class="active">');
        $this->setDecorateDisabledPrefix('<li class="disabled">');
        $this->setRenderEndsForce(true);
    }

    public static function html($iterator, $count = 10, $length = 10){
        $self = new Pager($iterator, $count, $length);
        return $self->getHtml();
    }
}
