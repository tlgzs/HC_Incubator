<?php

namespace app\admin\controller;

use app\admin\model\AnnualReports;
use app\admin\model\EnterpriseList;
use app\admin\model\IncubateList;
use app\index\model\User;
use think\Db;

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
        $key2 = \input('key2', '');
        $status = \input('status');
        $year = \input('year');
        $enterpriseModel = new EnterpriseList();
        $list = $enterpriseModel->getEnterpriseListByCondition($key);

        //这里不应该是孵化企业列表,而应该是报表列表!!!  下次回来改
        $reportModel = new AnnualReports();
        $report_list = $reportModel->getReportListByCondition($year, $status, $key2);

//        \halt($report_list);
        //年份的数组
        $min_year = Db::name('IncubateList')->min('create_time');
        $min_year = \date('Y', $min_year);
        $now_year = \date('Y');
        for ($i = $min_year; $i <= $now_year; $i++) {
            $years[] = \intval($i);
        }
        $this->assign('report_list', $report_list);
        $this->assign('years', $years);
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * @return \think\response\Json
     * @throws \Exception
     * 添加孵化企业的操作
     */
    public function selectIncubate()
    {
        $input = \input();
        $ids = $input['data'];
        foreach ($ids as $id) {
            $incubate_info = EnterpriseList::get($id)->toArray();
            $sqldata[] = [
                'incubate_id' => $id,
                'incubate_name' => $incubate_info['enterprise_list_name'],
            ];

            //这两个可以合并一张表的,但是登录已经写好了就懒得改了
            $sqldata2[] = [
                'username' => $incubate_info['enterprise_list_name'],
                'password' => '88888888',
            ];
        }
        $incubatemodel = new IncubateList();
        $res = $incubatemodel->saveAll($sqldata);
        $userModel = new User();
        $res2 = $userModel->saveAll($sqldata2);
        if ($res && $res2) {
            return \json(['code' => 1, 'msg' => 'Ok']);
        } else {
            return \json(['code' => 0, 'msg' => 'Fail']);
        }
    }


    /**
     * @return mixed
     * @throws \think\exception\DbException
     * 企业的登录信息
     */
    public function accountInfo()
    {
        $userModel = new User();
        $key = \input('key', '');
        $list = $userModel->where('group', 2)
            ->whereLike('username', '%' . $key . '%')
            ->paginate(10);
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * @return \think\response\Json
     * @throws \Exception
     * 管理员发送填写年报要求
     */
    public function sendReport()
    {
        $modelAnnual = new AnnualReports();
        $modelIncubate = new IncubateList();
        $incubdate_ids = $modelIncubate->column('incubate_id');
        foreach ($incubdate_ids as $id) {
            $incubdate_name = Db::name('IncubateList')
                ->where('incubate_id', $id)
                ->value('incubate_name');
            $sqldata[] = [
                'incubate_id' => $id,
                'incubate_name' => $incubdate_name,
                'status' => 1,
            ];
        }
        $res = $modelAnnual->saveAll($sqldata);
        if ($res) {
            return \json(['code' => 1, 'msg' => 'OK']);
        } else {
            return \json(['code' => 0, 'msg' => 'Fail']);
        }
    }

    public function checkReport(){
        return $this->fetch();
    }
}
