<?php
return array(
	//'配置项'=>'配置值'
    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__IMGS__'    => __ROOT__ . '/Public/'.MODULE_NAME.'/images',
    	'__IMG__'    => __ROOT__ . '/Public/'.MODULE_NAME.'/img',
        '__CSS__'    => __ROOT__ . '/Public/'.MODULE_NAME.'/css',
        '__JS__'     => __ROOT__ . '/Public/'.MODULE_NAME.'/js',
		'__UPLOADS__' => __ROOT__ . '/Uploads/',
    	'__UPIFY__' => __ROOT__ . '/Public/static/uploadify',
    ),

);