<?php

namespace app\common\tool;

class RequsetTool
{
    /**
     * @name 关于get请求参数过滤
     */
    public static function getParameters($parameterName)
    {
        $parameter = input('get.' . $parameterName);
        $parameter = addslashes(trim(stripslashes($parameter)));
        return $parameter;
    }

    /**
     * @name 关于get请求参数过滤
     */
    public static function postParameters($parameterName)
    {
        $parameter = input('post.' . $parameterName);
        $parameter = addslashes(trim(stripslashes($parameter)));
        return $parameter;
    }
}