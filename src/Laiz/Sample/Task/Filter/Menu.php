<?php

namespace Laiz\Sample\Task\Filter;

use Zend\Http\PhpEnvironment\Request;

class Menu
{
    private $config;
    public $active;
    public function __construct($iniFile)
    {
        $this->config = parse_ini_file($iniFile);
    }

    public function accept()
    {
        return true;
    }

    public function postFilter()
    {
        $request = new Request();
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


        $path = $request->getUri()->getPath();
        $path = ltrim($path, '/');
        $path = str_replace('.html', '', $path);
        if (!$path)
            $path = 'index';
        $active = str_replace('/', '_', $path);
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
