<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use app\index\model\User;
use think\Db;

if (!function_exists('check_incubate')) {
    /**
     * @param $enterprise_id
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 检查这个企业是不是扶持企业
     */
    function check_incubate($enterprise_id)
    {
        $res = Db::name('IncubateList')
            ->where('incubate_id', $enterprise_id)
            ->find();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $enterprise_name
     * @return mixed
     * 根据企业id获取企业名称
     */
    function get_enterprise_id_by_enterprise_name($enterprise_name)
    {
        $res = Db::name('IncubateList')
            ->where('incubate_name', $enterprise_name)
            ->value('incubate_id');
        return $res;
    }

    /**
     * @param $session
     * @return array|null|PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据session中的企业id获取该企业的信息
     */
    function get_incubate_info_by_session($session)
    {
        $enterprise_name = Db::name('User')->where('id', $session)->value('username');
        $enterprise_info = Db::name('IncubateList')->where('incubate_name', $enterprise_name)->find();
        return $enterprise_info;
    }

    /**
     * @param $incubate_id
     * @param $year
     * @return mixed
     * 根据孵化企业的id获取某年的年报状态
     */
    function check_annual_reports_status($incubate_id, $year)
    {
        $status = Db::name('AnnualReports')
            ->where('incubate_id', $incubate_id)
            ->whereBetweenTime('create_time', $year . '-' . '01' . '-' . '01', ($year + 1) . '-' . '01' . '-' . '01')
            ->value('status');
        return $status;
    }

    /**
     * @param $id
     * @return string
     * 返回技术领域中文名
     */
    function get_TDF7L121_by_id($id)
    {
        switch ($id) {
            case 1:
                return '电子信息 ';
                break;
            case 2:
                return '先进制造 ';
                break;
            case 3:
                return '航空航天 ';
                break;
            case 4:
                return '现代交通 ';
                break;
            case 5:
                return '生物医药与医疗器械 ';
                break;
            case 6:
                return '新材料 ';
                break;
            case 7:
                return '新能源与节能 ';
                break;
            case 8:
                return '环境保护 ';
                break;
            case 9:
                return '地球、空间与海洋 ';
                break;
            case 10:
                return '核应用技术 ';
                break;
            case 11:
                return '现代农药 ';
                break;
            default:
                return '其他';
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws \think\Exception\DbException
     * 根据用户id获取用户名
     */
    function get_user_name_by_id($id)
    {
        $userInfo = User::get($id);
        return $userInfo['username'];
    }
}