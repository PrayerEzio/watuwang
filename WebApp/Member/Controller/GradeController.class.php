<?php
/**
 * 会员等级模块
 * @copyright  Copyright (c) 2014-2016 muxiangdao-cn Inc.(http://www.muxiangdao.cn)
 * @license    http://www.muxiangdao.cn
 * @link       http://www.muxiangdao.cn
 * @author     muxiangdao-cn Team Prayer (283386295@qq.com)
 */
namespace Member\Controller;
class GradeController extends BaseController {
	public function __construct(){
		parent::__construct();
	} 
	//个人等级
	public function index(){
		$this->display();
	}
}