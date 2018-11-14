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
}