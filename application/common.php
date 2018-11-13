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
}