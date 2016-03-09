<?php
// +----------------------------------------------------------------------
// | 哇途网需求发布页面
// +----------------------------------------------------------------------
// | Copyright (c) http://www.muxiangdao.cn
// +----------------------------------------------------------------------
// | 功能区块:首页数据
// +----------------------------------------------------------------------
// | Author: 开发团队
// +----------------------------------------------------------------------
namespace Home\Controller;
class DemandController extends BaseController {
	public function __construct(){
		parent::__construct();
		if(empty($this->user)){
			$this->error('请先登录后在进行发布');
			exit;
		}
	} 
	 
	//需求发布
    public function goods_add(){	
    	if(IS_POST){
    		$data['goods_type'] = str_rp(trim($_POST['goods_type']));
    		
    		$img_id = str_rp(trim($_POST['img_id']));
    		if(!empty($img_id)){
    			$data['img_id'] = $img_id;
    		}
    		$goods_name = str_rp(trim($_POST['goods_name']));
    		if(!empty($goods_name)){
    			$data['goods_name'] = $goods_name;
    		}
    		$goods_reward = str_rp(trim($_POST['goods_reward']));
    		if(!empty($goods_reward)){
    			$data['goods_reward'] = $goods_reward;
    		}
    		
    		//缺少时间
/*     		$goods_end_time = str_rp(trim($_POST['goods_end_time']));
    		if(!empty($goods_end_time)){
    			$data['goods_end_time'] = strtotime($goods_end_time);
    		} */
    		$goods_degree = str_rp(trim($_POST['goods_degree']));
    		if(!empty($goods_degree)){
    			$data['goods_degree'] = $goods_degree;	
    		}
    		$goods_format = str_rp(trim($_POST['goods_format']));
    		if(!empty($goods_format)){
    			$data['goods_format'] = $goods_format;
    		}
    		$goods_other = str_rp(trim($_POST['goods_other']));
    		if(!empty($goods_other)){
    			$data['goods_other'] = $goods_other;
    		}
    		$goods_width = str_rp(trim($_POST['goods_width']));
    		if(!empty($goods_width)){
    			$data['goods_width'] = $goods_width;
    		}
    		$goods_height = str_rp(trim($_POST['goods_height']));
    		if(!empty($goods_height)){
    			$data['goods_height'] = $goods_height;
    		}
    		$goods_order_sn = str_rp(trim($_POST['goods_order_sn']));
    		if(!empty($goods_order_sn)){
    			$data['goods_order_sn'] = $goods_order_sn;
    		}
    		$goods_desc = str_rp(trim($_POST['goods_desc']));
    		if(!empty($goods_desc)){
    			$data['goods_desc'] = $goods_desc;
    		}
    		$data['member_id'] = $this->user['member_id'];
    		
    	//开始处理数据
    		//提交数据
    		$res = M('goods')->add($data);
    		if(!empty($res)){
    			//文件上传
    			if(!empty($_FILES['goods_file']['size'])){
    				$param = array('savePath'=>'goods_file/','subName'=>'','files'=>$_FILES['goods_file'],'saveName'=>'info_'.NOW_TIME,'saveExt'=>'');
    				$up_return = upload_file($param);
    				if($up_return == 'error'){
    					$this->error('文件上传失败');
    					exit;
    				}
    				$data_file['goods_file'] = $up_return;
    				$res_file = M('goods')->where(array('goods_id'=>$res))->save($data_file);
    				if(empty($res_file)){
    					$this->error('发布失败');
    				}
    			}


    			$this->success('发布成功',U('Home/Demand/goods_add'));
    		}else{
    			$this->error('发布内容失败');
    		}
    		exit;
    	}
    	//作品编号生成
    	$this->order_sn = order_sn();
    	$this->member = user_data($this->user['member_id']);
		$this->display();
    }
    
    
    
    
    //支付操作
    public function payment(){
    	if(IS_AJAX){
    		$payment = re_md5(str_rp(trim($_POST['payment'])));
    		$res = M('member')->where(array('member_id'=>$this->user['member_id']))->find();
    		if(empty($res)){
    			echo -1; 	//非法操作
    			exit;
    		}
    		if($res['payment'] !== $payment){
    			echo -2;	//支付密码错误
    			exit;
    		}
    		echo 1;
    	}
    }

    
    

    
    
}