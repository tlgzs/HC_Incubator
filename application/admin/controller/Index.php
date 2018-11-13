<?php

namespace app\admin\controller;

use app\admin\model\EnterpriseList;
use app\admin\model\IncubateList;

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
        $input = \input();
        $ids = $input['data'];
        foreach ($ids as $id) {
            $sqldata[] = [
                'incubate_id' => $id,
            ];
        }
        $model = new IncubateList();
        $res = $model->saveAll($sqldata);
        if ($res) {
            return \json(['code' => 1, 'msg' => 'Ok']);
        } else {
            return \json(['code' => 0, 'msg' => 'Fail']);
        }
    }
}
