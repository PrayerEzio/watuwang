<?php
// +----------------------------------------------------------------------
// | 哇途网个人后台数据
// +----------------------------------------------------------------------
// | Copyright (c) http://www.muxiangdao.cn
// +----------------------------------------------------------------------
// | 功能区块:首页数据
// +----------------------------------------------------------------------
// | Author: 开发团队
// +----------------------------------------------------------------------
namespace Member\Controller;
class UserController extends BaseController {
	
	public function __construct(){
		parent::__construct();
	} 
	 
	//个人求助
	public function help(){
		$this->display();
	}
	
	//我的帮助
	public function assist(){
		$this->display();
	}
	
	//个人资料
	public function personal(){
		if(IS_POST){
			$nickname = str_rp(trim($_POST['nickname']));
			$member_qq = str_rp(trim($_POST['member_qq']));
			$gender = str_rp(intval($_POST['gender']));
			$province = str_rp(intval($_POST['province']));
			$city = str_rp(intval($_POST['city']));
			$area = str_rp(intval($_POST['area']));
			$member_birthday = str_rp(strtotime(trim($_POST['member_birthday'])));
			$data = array(
					'member_id'=>session('member')['member_id'],
					'nickname'=>$nickname,
					'member_qq'=>$member_qq,
					'gender'=>$gender,
					'province'=>$province,
					'city'=>$city,
					'area'=>$area,
					'member_birthday'=>$member_birthday
			);
			
		    $res = M('member')->save($data);
			    //上传用户图片
			    if(!empty($_FILES['avatar']['size'])){
			    	//删除原图
			    	if(!empty(user_data($data['member_id'])['avatar'])){
			    		unlink('./Uploads/'.user_data($data['member_id'])['avatar']);
			    	}
			    	//上传新图片
				    $param = array('savePath'=>'user/','subName'=>'','files'=>$_FILES['avatar'],'saveName'=>'info_'.NOW_TIME,'saveExt'=>'');				
					$up_return = upload_one($param);
					if($up_return == 'error'){
						$this->error('图片上传失败');
						exit;	
					}else{	
						$data_img = array(
							'member_id'=>session('member')['member_id'],
							'avatar'=>$up_return,
						);
						M('member')->save($data_img);
					}	
		    	}
			$this->redirect('Member/User/personal');
			exit;
		}
		//Ajax城市
		$this->province = M('district')->where(array('level'=>1))->order('d_sort asc')->select();
		$this->display();
	}
		
	//身份认证
	public function certified(){
		if(IS_AJAX){
			$apply_name = str_rp(trim($_POST['apply_name']));
			$apply_number = str_rp(trim($_POST['apply_number']));
			$mobile = str_rp(trim($_POST['mobile']));
			$address = str_rp(trim($_POST['address']));
			$cards = str_rp(trim($_POST['cards']));
			$name = str_rp(trim($_POST['name']));
			$area = str_rp(trim($_POST['area']));
			$city = str_rp(trim($_POST['city']));
			$province = str_rp(trim($_POST['province']));
			
			$telephone = str_rp(trim($_POST['telephone']));
			$fax = str_rp(trim($_POST['fax']));
			if(empty($apply_name) || empty($apply_number) || empty($mobile) || empty($address) || empty($cards) || empty($name) || empty($area) || empty($city) || empty($province)){
				echo -1;//不能为空
				exit;
			}
			$result = M('identity')->where(array('member_id'=>session('member')['member_id']))->find();
			
			if(empty($result)){
				$data = array(
						'member_id'=>session('member')['member_id'],
						'apply_name'=>$apply_name,
						'apply_number'=>$apply_number,
						'mobile'=>$mobile,
						'address'=>$address,
						'cards'=>$cards,
						'name'=>$name,
						'area'=>$area,
						'city'=>$city,
						'province'=>$province,
						'telephone'=>$telephone,
						'fax'=>$fax,
				);
				$res = M('identity')->add($data);
				if(empty($res)){
					echo -2;//数据插入失败
					exit;
				}
				echo 1;				
			}else{
				$data = array(
						'apply_name'=>$apply_name,
						'apply_number'=>$apply_number,
						'mobile'=>$mobile,
						'address'=>$address,
						'cards'=>$cards,
						'name'=>$name,
						'area'=>$area,
						'city'=>$city,
						'province'=>$province,
						'telephone'=>$telephone,
						'fax'=>$fax,
				);
				$res = M('identity')->where(array('member_id'=>session('member')['member_id'],))->save($data);
				if(empty($res)){
					echo -3;//数据插入失败
					exit;
				}
				echo 2;				
			}
			

			exit;
		}
		//Ajax城市
		$this->province = M('district')->where(array('level'=>1))->order('d_sort asc')->select();
		$this->identity = M('identity')->where(array('member_id'=>session('member')['member_id']))->find();
		$this->display();
	}
    
	
	//密码修改
	public function changed(){
		if(IS_AJAX){
			
			$type = intval($_POST['type']);
			switch ($type){
				//登录密码
				case 1:
					//登录密码
					$oldpwd = str_rp(trim($_POST['oldpwd']));
					$pwd = str_rp(trim($_POST['pwd']));
					$payment_pwd = str_rp(trim($_POST['payment_pwd']));
					
					if(empty($oldpwd) || empty($pwd) || empty($payment_pwd)){
						echo -1;//不能为空
						exit;
					}
					if($pwd !== $payment_pwd){
						echo -2; //两次密码不一致
						exit;
					}
					$res = M('member')->where(array('member_id'=>session('member')['member_id']))->find();
					if(empty($res)){
						echo -10; //非法操作
						exit;
					}
					if($res['pwd'] != re_md5($oldpwd)){
						echo -3; //原始密码错误
						exit;
					}
					$data = array(
						'member_id'=>session('member')['member_id'],
						'pwd'=>re_md5($pwd)
					);
					M('member')->save($data);
					echo 1;//成功
					break;
				case 2:
					//支付密码
					$oldpayment = str_rp(trim($_POST['oldpayment']));
					$payment = str_rp(trim($_POST['payment']));
					$payment_payment = str_rp(trim($_POST['payment_payment']));

					
			/* 		P(re_md5($oldpayment));die; */
					if(empty($oldpayment) || empty($payment) || empty($payment_payment)){
						echo -1;//不能为空
						exit;
					}
					if($payment !== $payment_payment){
						echo -2; //两次密码不一致
						exit;
					}
					$res = M('member')->where(array('member_id'=>session('member')['member_id']))->find();
					if(empty($res)){
						echo -10; //非法操作
						exit;
					}
					if($res['payment'] != re_md5($oldpayment)){
						echo -3; //原始密码错误
						exit;
					}
					$data = array(
							'member_id'=>session('member')['member_id'],
							'payment'=>re_md5($payment)
					);
					M('member')->save($data);
					echo 1;	//成功
					break;
				default:
					echo -999;	//非法
			}
			exit;
		}
		$this->display();
	}
	
	//账户绑定管理
	public function binding(){
		$this->display();
	}
	
	

	
	
	//ajax城市
	public function problem(){
		if(IS_AJAX){
			$province = $_GET['province'];
			if(!empty($province)){
				$city = M('district')->where(array('upid'=>$province))->order('d_sort asc')->select();
				echo '<option value=""></option>';
				foreach ($city as $key => $val){
					echo '<option value="'.$val["id"].'">'.$val['name'].'</option>';
				}
				die;
			}
	
			$city = $_GET['city'];
			if(!empty($city)){
				$city = M('district')->where(array('upid'=>$city))->order('d_sort asc')->select();
				echo '<option value=""></option>';
				foreach ($city as $key => $val){
					echo '<option value="'.$val["id"].'">'.$val['name'].'</option>';
				}
			}
		}
	}	
	
	
	
	

}