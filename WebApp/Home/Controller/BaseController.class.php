<?php
/**
 * 基类
 * @package    Base
 * @copyright  Copyright (c) 2014-2030 muxiangdao-cn Inc.(http://www.muxiangdao.cn)
 * @license    http://www.muxiangdao.cn
 * @link       http://www.muxiangdao.cn
 * @author	   muxiangdao-cn Team
 */
namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller{
	public function _initialize(){
		//用户信息
		$this->user = user_data(session('member')['member_id']);
	}
	
	
	
	/**
	 * 用处 :账户余额明细
	 * @param  	商品id
	 * @return  返回是否写入成功
	 * */
	final protected function money_log($money,$success,$goods_id=null){
		$data = array(
				'member_id'=>$this->user['member_id'],
				'goods_id'=>$goods_id,
				'money_detailed' => $money,
				'money_success' => $success,
				'moeny_time'=>NOW_TIME
		);
		$res = M('goods_money')->add($data);
		if(empty($res)){
			return false;
			exit;
		}
		//记录成功
		return true;
	}
	
	/**
	 * 
	 * 用处:用户经验操作记录
	 * @param 
	 * @return
	 * */
	final protected function experience_log(){
		
	}
	
	
	
	/**
	 * 
	 * 用处:
	 * 
	 * 
	 * */
	
	
	
	
	
	
	
}