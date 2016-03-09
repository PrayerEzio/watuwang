<?php
// +----------------------------------------------------------------------
// | 哇途网用户登录
// +----------------------------------------------------------------------
// | Copyright (c) http://www.muxiangdao.cn
// +----------------------------------------------------------------------
// | 功能区块:首页数据
// +----------------------------------------------------------------------
// | Author: 开发团队
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
class LogController extends Controller {
	public function __construct(){
		parent::__construct();
	} 
	
	//注册
	public function logon(){
		if(IS_POST){
			$member_name = str_rp(trim($_POST[member_name]));
			$email = str_rp(trim($_POST[email]));
			
			$pwd = str_rp(trim($_POST[pwd]));
			$payment_pwd = str_rp(trim($_POST[payment_pwd]));
			
			$payment = str_rp(trim($_POST[payment]));
			$payment_payment = str_rp(trim($_POST[payment_payment]));
			$mobile = str_rp(trim($_POST[mobile]));
			
			if(empty($member_name) || empty($email)  || empty($pwd)  || empty($payment_pwd) || empty($payment) || empty($payment_payment) || empty($mobile)){
				$this->error('请认真填写信息');
				exit;
			}
			
			//验证邮箱
			if(empty(testing($email,'email'))){
				$this->error('邮箱错误');
				exit;
			}
			//验证手机号
			if(empty(testing($mobile,'moebl'))){
				$this->error('手机号输入错误');
				exit;
			}
			
			//检索数据库是否存在用户名
			$data_name = M('member')-> where(array('member_name'=>$member_name))->find();
			if(!empty($data_name)){
				$this->error('此用户名已被注册');
				exit;
			}

			//检索数据库是否存在邮箱
			$data_name = M('member')-> where(array('email'=>$member_name))->find();
			if(!empty($data_name)){
				$this->error('此邮箱已被注册');
				exit;
			}
			
			//检索数据库是否存在手机
			$data_name = M('member')-> where(array('mobile'=>$member_name))->find();
			if(!empty($data_name)){
				$this->error('此手机号已被注册');
				exit;
			}
			
			if($pwd !== $payment_pwd){
				$this->error('两次密码输入不一致');
				exit;
			}
			
			if($payment !== $payment_payment){
				$this->error('两次支付密码输入不一致');
				exit;
			}
			
			$data = array(
				'member_name'=>$member_name,
				'email'=>$email,
				'pwd'=>re_md5($pwd),
				'payment'=>re_md5($payment),
				'mobile'=>$mobile,
				'status'=>1
			);
			
			//注册写入数据库
			$res = M('member')->add($data);
			if(empty($res)){
				$this->error('注册失败,请刷新页面重新注册!');
				exit;
			}
			$session_data = array(
					'member_id'=>$res,
					'login_time'=>NOW_TIME,
					'login_ip'=>get_client_ip(1),
			);
			$m_res = M('member')->where(array('member_id'=>$res))->save($session_data);
			if(empty($m_res)){
				$this->error('注册失败,请刷新页面重新注册!');
				exit;
			}
			//记录seesion
			session('member',$session_data);
			session('member_login',usersign($session_data));
			//登录记录
			record($res,getBrowser());
			//跳转
			$this->redirect('Member/Index/index');
		exit;
		}
		$this->display();
	}
	
	//忘记密码-绑定邮箱
	public function forget(){
		$this->display();
	}
	//忘记密码-邮箱发送成功
	public function email_success(){
		$this->display();
	}
	//忘记密码-修改密码
	public function amend(){
		$this->display();
	}
	//忘记密码-修改成功
	public function success(){
		$this->display();
	}
	
	

}