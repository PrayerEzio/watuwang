<?php
/**
 * 账户记录模块
 * @copyright  Copyright (c) 2014-2016 muxiangdao-cn Inc.(http://www.muxiangdao.cn)
 * @license    http://www.muxiangdao.cn
 * @link       http://www.muxiangdao.cn
 * @author     muxiangdao-cn Team Prayer (283386295@qq.com) && Caidahui (1156949976@qq.com)
 */
namespace Member\Controller;
use Think\Page;
class AccountController extends BaseController {
	public function __construct(){
		parent::__construct();
	} 
	 
	//账户余额
	public function balance(){
		$this->display();
	}
	
	//金币记录
	public function gold(){
		$this->display();
	}
	
	//充值奖励
	public function recharge(){
		$this->display();
	}	
	
	//登录日志
	public function log(){
		$where['member_id'] = session('member')['member_id'];
		$conut = M('member_login')->where($where)->count();
		$page = new Page($conut,10);
		$this->show = $page->show();
		$this->list = M('member_login')->where($where)->limit($page->listRows.','.$page->firstRow)->order('time desc')->select();
		$this->display();
	}	
	
	//我的求助
	public function help(){
		
	}
    

}