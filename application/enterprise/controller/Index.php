<?php

namespace app\enterprise\controller;


use app\admin\model\AnnualReports;
use app\admin\model\IncubateList;
use think\Db;
use think\facade\Request;

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
        //企业基本信息
        $incubate_info = \get_incubate_info_by_session($session);
        //企业年报列表
        $annualModel = new AnnualReports();
        $year = \input('year', '');
        $report_list = $annualModel->getReportListByIncubateId($incubate_info['incubate_id'], $year);
        //年份的数组
        $min_year = Db::name('IncubateList')->min('create_time');
        $min_year = \date('Y', $min_year);
        $now_year = \date('Y');
        for ($i = $min_year; $i <= $now_year; $i++) {
            $years[] = \intval($i);
        }
        $this->assign('years', $years);
        $this->assign('i_info', $incubate_info);
        $this->assign('list', $report_list);
        return $this->fetch();
    }

    /**
     *添加企业基本信息
     */
    public function addInfo()
    {
        $sqldata = \input();
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

    /**
     * @return mixed
     * @throws \think\Exception\DbException
     * 填写报表页面
     */
    public function editReport()
    {
        $sqldata = \input();
        $report_id = \input('id');
        $sqldata['fill_time'] = \time();
        if (Request::isPost()) {
            $annualModel = new AnnualReports();
            $res = $annualModel->allowField(true)->save($sqldata, ['id' => $sqldata['report_id']]);
            if ($res) {
                $this->success('提交成功');
            } else {
                $this->error('提交失败');
            }
        } else {
            $reportInfo = AnnualReports::get($report_id);
            $this->assign('report', $reportInfo);
        }
        return $this->fetch();
    }
}
