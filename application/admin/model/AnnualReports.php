<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/11/15
 * Time: 13:43
 */

namespace app\admin\model;


use think\Model;

/**
 * Class AnnualReports
 * @package app\admin\model
 */
class AnnualReports extends Model
{
    /**
     * @return \think\model\relation\BelongsTo
     * 关联孵化企业模型
     */
    public function incubate()
    {
        return $this->belongsTo('IncubateList', 'incubate_id', 'incubate_id');
    }

    /**
     * @param $year
     * @param $status
     * @param $key
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getReportListByCondition($year, $status, $key)
    {
        $map = [];
        if (empty($year)) {
            $year = \date('Y');
        }
        if (!empty($status)) {
            $map['status'] = $status;
        }

        $list = self::with('incubate')
            ->where($map)
            ->whereLike('incubate_name', '%' . $key . '%')
            ->whereBetweenTime('create_time', $year . '-' . '01' . '-' . '01', ($year + 1) . '-' . '01' . '-' . '01')
            ->paginate(10);
        return $list;
    }

    /**
     * @param $id
     * @param $year
     * @return \think\Paginator
     * @throws \think\exception\DbException
     * 获取某个企业的某年的年报列表
     */
    public function getReportListByIncubateId($id, $year)
    {
        if (empty($year)) {
            $year = \date('Y');
        }
        $list = self::with('incubate')
            ->where('incubate_id', $id)
            ->whereBetweenTime('create_time', $year . '-' . '01' . '-' . '01', ($year + 1) . '-' . '01' . '-' . '01')
            ->paginate(10);
        return $list;
    }

    /**
     * @param $status
     * @return string
     * 返回年报的状态中文字
     */
    public function getStatusAttr($status)
    {
        if ($status == 1) {
            return '未填写';
        }

        if ($status == 2) {
            return '已提交';
        }

        if ($status == 3) {
            return '已审批';
        }
    }
}