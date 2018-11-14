<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/11/14
 * Time: 14:50
 */

namespace app\enterprise\controller;


use app\index\model\User;
use think\Controller;

/**
 * Class EnterpriseBase
 * @package app\enterprise\controller
 */
class EnterpriseBase extends Controller
{
    /**
     * @throws \think\Exception\DbException
     */
    public function initialize()
    {
        parent::initialize();
        if (empty(\session('enterprise_id'))){
            $this->redirect('/');
        }else{
            $enterprise_info = User::get(\session('enterprise_id'));
            $this->assign('info', $enterprise_info);
        }
    }
}