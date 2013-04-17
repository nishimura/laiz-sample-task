<?php

namespace Laiz\Sample\Task\Filter;

use Zend\Stdlib\RequestInterface as Request;
use Laiz\Core\Action;

class Menu
{
    private $config;
    public $active;
    public function __construct($iniFile)
    {
        $this->config = parse_ini_file($iniFile);
    }
    public function display(Action $action)
    {
        $this->active = new \stdClass();
        $menus = array();
        foreach ($this->config as $k => $v){
            $menus[$k] = $this->item($k, $v);
            $this->active->$k = '';
        }
        foreach ($menus as $k => &$v){
            if ($v->parent) // replace string to object
                $v->parent = $menus[$v->parent];
        }


        $pageName = $action->getPageName();
        $active = str_replace('/', '_', ltrim($pageName, '/'));
        if (!isset($menus[$active]))
            return;

        // set active string to current menu
        $current = $menus[$active];
        while ($current) {
            $this->active->{$current->name} = 'active';
            $current = $menus[$current->name]->parent;
        }
    }
    private function item($k, $v)
    {
        $item = new \stdClass();
        $item->name = $k;
        $item->parent = $v;
        return $item;
    }
}
