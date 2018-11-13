<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/11/13
 * Time: 10:51
 */

namespace app\admin\controller;


use app\index\model\User;
use think\Controller;

/**
 * Class AdminBaes
 * @package app\admin\controller
 */
class AdminBase extends Controller
{
    //tp5.1的初始化方法和tp5不一样了,没有"_"
    public function initialize()
    {
        parent::initialize();
        if (empty(\session('admin_id'))) {
            $this->redirect('Index/index/index');
        }

        $user_info = User::get(\session('admin_id'));
        $this->assign('user_info', $user_info);
    }
}