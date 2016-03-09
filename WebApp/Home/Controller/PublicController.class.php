<?php
// +----------------------------------------------------------------------
// | 公共逻辑													
// +----------------------------------------------------------------------
// | Copyright (c) http://www.muxiangdao.cn
// +----------------------------------------------------------------------
// | 功能区块: 登录  注册 	忘记密码
// +----------------------------------------------------------------------
// | Author: 开发团队
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {
	public function __construct(){
		parent::__construct();
		$this->member = M('member');
	} 
		
	//登录
    public function login($member_name,$pwd=null,$verify=null){	
    	if(IS_POST){
    		$member_name = trim($_POST['member_name']);
    		$pwd = re_md5(trim($_POST['pwd']));
    		$verify = trim($_POST['verify']);
    		
    		//判断验证码
    		if(!check_verify($verify)){
    			$this->error('验证码输入错误！');
    			exit;
    		}
    		//检测用户名密码
    		if($member_name == '' || $pwd == '')
    		{
    			$this->error('用户名或密码为空！',U('login'));
    			exit;
    		}
			//开始登陆
				//条件设置
			$where['member_name'] = $member_name;
			$res = $this->member->where($where)->find();	
			if(!empty($res)){
				if($res['pwd'] === trim($pwd)){
					$data = array(
						'member_id'=>$res['member_id'],
						'login_time'=>NOW_TIME,
						'login_ip'=>get_client_ip(1),
					);
					$this->member->where(array('member_id'=>$res['member_id']))->save($data);
					//记录seesion
					session('member',$data);
					session('member_login',usersign($data));
					//登录记录
					record($res['member_id'],getBrowser());
					//跳转后台首页
					$this->success('登陆成功',U('Member/Index/index'));
				}else{
					$this->error('登陆密码错误');
				}
			}else{
				$this->error('该会员不存在');
			}
    		exit;
    	}
		$this->display();
    }
    
    
    
    
    
    //退出登录
    public function logout(){
    	session('member',null);
    	session('member_login',null);
    	$this->success('退出成功',U('login'));
    }
    
    
    /**
     * 生成验证码
     */
    public function verify()
    {
    	$config = array(
    			'fontSize'    => 14,
    			'length'      => 4,
    			'imageW'      => 100,
    			'imageH'    => 38,
    			'useNoise' => false,
    			//'useCurve' => false,
    	);
    	$verify = new \Think\Verify($config);
    	$verify->entry(1);
    }
    
    

    //插件上传图片
    public function uploadify(){
    	//上传新图片
    	$param = array('savePath'=>'goods_file/','subName'=>'','files'=>$_FILES['Filedata'],'saveName'=>'info_'.NOW_TIME,'saveExt'=>'');
    	$up_return = upload_one($param);
    	if($up_return == 'error'){
    		echo -3;
    		exit;
    	}else{
    		$data = array(
    				'member_id'=>$_GET['session'],
    				'img_link'=>$up_return,
    				'time'=>NOW_TIME,
    				'goods_type'=>$_GET['action'],
    		);
    		$res = M('goods_img')->add($data);
    		if(!empty($res)){
    			$data['res_id'] = $res;
    			$data['res_goods_file'] = $up_return;
    			echo json_encode($data);
    			die;
    		}
    		echo -2;
    		die;
    	}
    }  
    
}