<?php

namespace Laiz\Sample\Task\View;

use Laiz\Core\View\LaizView;
use Laiz\Db\Vo;

class EasySupportJsonView extends LaizView
{
    private $type;
    public function setFile($file, $type = 'html')
    {
        $this->type = $type;
        if ($type !== 'json')
            parent::setFile($file, $type);
    }

    public function show($vars)
    {
        if ($this->type === 'json'){
            $obj = new \stdClass();
            foreach ($vars as $k => $v){
                if ($v instanceof Vo)
                    $obj->$k = $v;
            }
            echo json_encode($obj);
        }else{
            parent::show($vars);
        }
    }
}
