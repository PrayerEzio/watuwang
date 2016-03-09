<?php
/**
 * 基类
 * @package    Base
 * @copyright  Copyright (c) 2014-2030 muxiangdao-cn Inc.(http://www.muxiangdao.cn)
 * @license    http://www.muxiangdao.cn
 * @link       http://www.muxiangdao.cn
 * @author	   muxiangdao-cn Team
 */
namespace Member\Controller;
use Think\Controller;

class BaseController extends Controller{
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
		//检测是否登录
		$session_member = session('member');
		$session_member_login = session('member_login');
		if(empty($session_member) && empty($session_member_login)){
			$this->error('未登录,请先登录',U('Home/Public/login'));
			exit;
		}
		//签名认证
		if(usersign($session_member) !== $session_member_login){
			$this->error('非法操作',U('Home/Public/login'));
			exit;
		}
		//用户信息
		$this->user = user_data(session('member')['member_id']);
	}

	
}