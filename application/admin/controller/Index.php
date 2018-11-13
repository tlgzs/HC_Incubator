<?php

namespace app\admin\controller;

use app\admin\model\EnterpriseList;

/**
 * Class Index
 * @package app\admin\controller
 */
class Index extends AdminBase
{
    /**
     * @return mixed
     * @throws \think\exception\DbException
     * 企业列表
     */
    public function index()
    {
        $key = \input('key', '');
        $enterpriseModel = new EnterpriseList();
        $list = $enterpriseModel->getEnterpriseListByCondition($key);
//        \halt($list);
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function selectIncubate()
    {
        \halt(\input());
    }
}
