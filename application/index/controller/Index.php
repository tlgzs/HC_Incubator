<?php
namespace app\index\controller;

use think\Controller;

/**
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }
    public function dologin(){
        \halt(\input());
    }
}
