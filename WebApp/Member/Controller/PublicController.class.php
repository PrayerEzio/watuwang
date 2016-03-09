<?php
// +----------------------------------------------------------------------
// | 哇途网用户后台公共
// +----------------------------------------------------------------------
// | Copyright (c) http://www.muxiangdao.cn
// +----------------------------------------------------------------------
// | 功能区块:
// +----------------------------------------------------------------------
// | Author: 开发团队
// +----------------------------------------------------------------------
namespace Member\Controller;
use Think\Controller;
use Think\Image;

class PublicController extends Controller {
	 
	//插件上传图片
	public function uploadify(){
		//上传新图片
		$param = array('savePath'=>'goods_file/','subName'=>'','files'=>$_FILES['Filedata'],'saveName'=>'info_'.NOW_TIME,'saveExt'=>'');
		$up_return = upload_one($param);
		if($up_return == 'error'){
			echo -3;
			exit;
		}else{
			$image = new Image();
			$image->open( './Uploads/'.$up_return);
			//原图后缀
			$wei = get_extension($_FILES['Filedata']['name']);
			//缩略图图片地址
			$link = 'goods_file/thum_'.NOW_TIME;
			$image->thumb(100,80)->save('./Uploads/'.$link.'.'.$wei);
			
			$data = array(
					'good_file_name' =>$_FILES['Filedata']['name'],
					'goods_file_size' =>$_FILES['Filedata']['size'],
					'goods_file_suffix' => get_extension($_FILES['Filedata']['name']),
					'goods_file_thum'=>$link.'.'.$wei,
					'goods_order_sn'=>order_sn(),
					'member_id'=>$_GET['session'],
					'goods_file'=>$up_return,
					'goods_time'=>NOW_TIME
			);
			$res = M('goods')->add($data);
			if(!empty($res)){
				echo $res;
				die;
			}
			echo -2;
		}
	}
	
	
	//插件上传图片(后台编辑上传预览图)
	public function uploadify_edit(){
		//上传新图片
		$param = array('savePath'=>'goods_file/','subName'=>'','files'=>$_FILES['Filedata'],'saveName'=>'edit_'.NOW_TIME,'saveExt'=>'');
		$up_return = upload_one($param);
		if($up_return == 'error'){
			echo -3;
			exit;
		}else{
			$data = array(
					'member_id'=>$_GET['session'],
					'img_link'=>$up_return,
					'time'=>NOW_TIME,
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