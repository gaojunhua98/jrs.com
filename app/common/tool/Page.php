<?php

namespace app\common\tool;

use app\common\tool\RequestTool;

/**
 * @name 分页相关
 */
class Page
{
    /**
     * @name 关于get请求参数过滤
     */
    public static function getPageParameters()
    {
    	$page = RequestTool::getParameters('page');
        $pageNum = RequestTool::getParameters('pageNum');
        if(!$page || !$pageNum) 
    	{
	    	return  false;
    	}
		$pageData = [
			'page' => $page,
			'pageNum' => $pageNum,
		];
        return $pageData;
    }

}