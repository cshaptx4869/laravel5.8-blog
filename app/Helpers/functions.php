<?php

/**
 * 操作成功跳转方法
 * @param  mixed     $msg 提示信息
 * @param  string    $url 跳转的URL地址
 * @param  mixed     $data 返回的数据
 * @param  integer   $wait 跳转等待时间
 * @return void
 */
if (!function_exists('success')){
    function success($msg = '', $url = null, $data = '', $wait = 3)
    {
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : url($url);
        }

        $result = [
            'code' => 1,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        return $result;
    }
}

/**
 * 操作错误跳转的方法
 * @param  mixed     $msg 提示信息
 * @param  string    $url 跳转的URL地址
 * @param  mixed     $data 返回的数据
 * @param  integer   $wait 跳转等待时间
 * @return void
 */
if (!function_exists('error')){
    function error($msg = '', $url = null, $data = '', $wait = 3)
    {
        if (is_null($url)) {
            $url = request()->ajax() ? '' : 'javascript:history.back(-1);';
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : url($url);
        }

        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        return $result;
    }
}

/* 自动分页*/
if (!function_exists('auto_pagesize')){
    function auto_pagesize()
    {
        $pagesize = 15;
        if (isset($_COOKIE['wes_w'])){
            $w = (int)$_COOKIE['wes_w'];
            if ($w >= 1280){
                $row_height = 40;
            } else if ($w >= 1024){
                $row_height = 45;
            } else {
                $row_height = 60;
            }
            $screen_height = (int)$_COOKIE['wes_h'];
            $pagesize = (int)(($screen_height - 320) / $row_height);
        }
        return $pagesize;
    }
}
