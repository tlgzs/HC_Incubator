<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/11/13
 * Time: 17:32
 */

namespace app\admin\model;


use think\Model;

/**
 * Class IncubateList
 * @package app\admin\model
 */
class IncubateList extends Model
{
    /**
     * @var bool
     */
    protected $autoWriteTimestamp = true;

    public function incubateInfo()
    {
        return $this->hasOne('EnterpriseList', 'id', 'incubate_id');
    }

    public function getIncubateListByCondition($year, $status, $key)
    {
        $map = [];
        if (empty($year)) {
            $year = \date('Y');
        }
        if (!empty($status)) {
            $map['status'] = $status;
        }

        $list = self::with('incubateInfo')
            ->where($map)
            ->whereLike('incubate_name', '%' . $key . '%')
            ->whereBetweenTime('create_time', $year . '-' . '01' . '-' . '01', ($year + 1) . '-' . '01' . '-' . '01')
            ->paginate(10);
        return $list;
    }
}