<?php

namespace app\enterprise\controller;


use app\admin\model\IncubateList;

/**
 * Class Index
 * @package app\enterprise\controller
 */
class Index extends EnterpriseBase
{

    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $session = \session('enterprise_id');
        $incubate_info = \get_incubate_info_by_session($session);
        $this->assign('i_info', $incubate_info);
        return $this->fetch();
    }

    /**
     *添加企业基本信息
     */
    public function addInfo()
    {
        $sqldata = \input();
        $sqldata['TDF7L121'] = \implode(',', $sqldata['TDF7L121']);
        $sqldata['TDF7L117'] = \implode(',', $sqldata['TDF7L117']);
        $incubateModel = new IncubateList();
        $res = $incubateModel
            ->allowField(true)
            ->save($sqldata, ['incubate_id' => $sqldata['enterprise_id']]);
        if ($res) {
            $this->success('保存成功');
        } else {
            $this->error('保存失败');
        }
    }
}
