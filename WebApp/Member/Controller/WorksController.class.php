<?php
// +----------------------------------------------------------------------
// | 哇途网个人作品模块
// +----------------------------------------------------------------------
// | Copyright (c) http://www.muxiangdao.cn
// +----------------------------------------------------------------------
// | 功能区块:首页数据
// +----------------------------------------------------------------------
// | Author: 开发团队
// +----------------------------------------------------------------------
namespace Member\Controller;
use Think\Page;
class WorksController extends BaseController {
	public function __construct(){
		parent::__construct();
	} 
	 
	//作品上传
		//插件上传  上传执行程序   Public控制器中
	public function piece_uploads(){
		$this->display();
	}
	//作品上传完成处理页面
	public function uploads_add(){
		$this->display();
	}
	
		
	//作品管理
	public function piece_manage(){
		//所属状态
		$where['goods_status'] = I('get.goods_status',0); 
		
		$count = M('goods')->where($where)->count();
		$page = new Page($count,5);
		$this->show = $page->show();
		$this->list = M('goods')->where($where)->order('goods_time desc')->limit($page->firstRow.','.$page->listRows)->select();
		
		$this->goods_status = I('get.goods_status',0);
		//按照状态进行统计
		$this->not_num = M('goods')->where(array('goods_status'=>-1))->count();	//未通过
		$this->ben_num = M('goods')->where(array('goods_status'=>0))->count();	//未处理
		$this->off_num = M('goods')->where(array('goods_status'=>1))->count();	//已通过
		$this->display();
	}
	//作品删除
	public function piece_manage_del(){
		if(IS_POST){
			
			$del_id = $_POST['del_id'];
			if(is_array($del_id)){
				$id = '';
				foreach ($del_id as $key=>$value){
					$id.=$value.',';
				}
			}
			$id = substr($id, 0,-1);
			$res = M('goods')->delete($id);
			if(empty($res)){
				$this->error('删除失败');
				exit;
			}
			$this->success('删除成功',U('piece_manage'));
			exit;
		}
		
		
	}
	//作品编辑
	public function piece_manage_edit(){
		if(IS_POST){
			$goods_id = intval($_POST['goods_id']);
			if(empty($goods_id)){
				$this->error('非法操作');
				exit;
			}
			$img_id = str_rp(trim($_POST['img_id']));
			if(empty($img_id)){
				$this->error('实景效果图不能为空');
				exit;
			}
			$goods_name = str_rp($_POST['goods_name']);
			if(empty($goods_name)){
				$this->error('作品名字不能为空');
				exit;
			}
			$goods_key = str_rp($_POST['goods_key']);
			if(empty($goods_key)){
				$this->error('关键字不能为空');
				exit;
			}
			$goods_type = str_rp($_POST['goods_type']);
			if(empty($goods_type)){
				$this->error('分类不能为空');
				exit;
			}
			
			$album_id = str_rp($_POST['goods_album']);
			if(empty($album_id)){
				$this->error('专辑不能为空');
				exit;
			}
			$goods_reward = str_rp($_POST['goods_reward']);
			if(empty($goods_reward)){
				$this->error('悬赏哇图币不能为空');
				exit;
			}
			$goods_colour = str_rp($_POST['goods_colour']);
			if(empty($goods_colour)){
				$this->error('图片颜色不能为空');
				exit;
			}
			
			$goods_edition = str_rp($_POST['goods_edition']);
			if(empty($goods_edition)){
				$this->error('作图工具版本不能为空');
				exit;
			}
			$goods_width = str_rp($_POST['goods_width']);
			if(empty($goods_width)){
				$this->error('尺寸宽度不能为空');
				exit;
			}
			$goods_height = str_rp($_POST['goods_height']);
			if(empty($goods_height)){
				$this->error('尺寸高度不能为空');
				exit;
			}
			$goods_file_width = str_rp($_POST['goods_file_width']);
			if(empty($goods_file_width)){
				$this->error('文档宽度不能为空');
				exit;
			}
			$goods_file_higth = str_rp($_POST['goods_file_higth']);
			if(empty($goods_file_higth)){
				$this->error('文档高度不能为空');
				exit;
			}
			$goods_desc = str_rp($_POST['goods_desc']);
			$data['img_id'] = $img_id;
			$data['goods_name'] = $goods_name;
			$data['goods_key'] = $goods_key;
			$data['goods_type'] = $goods_type;
			$data['album_id'] = $album_id;
			$data['goods_reward'] = $goods_reward;
			$data['goods_colour'] = $goods_colour;
			$data['goods_edition'] = $goods_edition;
			$data['goods_width'] = $goods_width;
			$data['goods_height'] = $goods_height;
			$data['goods_file_width'] = $goods_file_width;
			$data['goods_file_higth'] = $goods_file_higth;
			$data['goods_desc'] = $goods_desc;
			//添加程序
			$res = M('goods')->where(array('goods_id'=>$goods_id))->save($data);
			if(empty($res)){
				$this->error('添加失败');
				exit;
			}
			$this->success('作品添加成功',U('Member/Works/piece_manage',array('goods_status'=>1)));			
			exit;
		}
		$this->member = user_data($this->user['member_id']);
		$goods = M('goods')->where(array('goods_id'=>$_GET['goods_id']))->find();
		//获取图
		$img = explode(',', $goods['img_id']);
		array_pop($img);
		$img_data = array();
		$goods_img = M('goods_img')->select();
		foreach ($goods_img as $key=>$val){
			/* P($goods_img[$key]['img_id']); */
			foreach ($img as $k=>$v){
				if($goods_img[$key]['img_id'] == $img[$k]){
					$img_data[] = $goods_img[$key];
					unset($goods_img[$key]);
				}
			}
		}
		$this->assign('img_data',$img_data);
		$this->assign('goods',$goods);
		$this->album_list = M('goods_album')->where(array('member_id'=>$this->user['member_id']))->select();
		$this->display();
	}
	
		
	//专辑管理
	public function album__manage(){
		$where['member_id'] = $this->user['member_id'];
		$this->list = M('goods_album')->where($where)->select();
		$this->display();
	}
	
	//专辑增加
	public function album_add(){
		$data['member_id'] =  $this->user['member_id'];
		$data['album_name'] = str_rp(trim($_GET['add_name']));
		$data['album_desc'] = str_rp(trim($_GET['add_desc']));
		$data['album_time'] = NOW_TIME;
		$res = M('goods_album')->add($data);
		if(empty($res)){
			echo -1;
			exit;
		}
		echo 1;
	}
	//专辑修改
	public function album_edit(){
		if(IS_POST){
			$data['album_id'] = intval($_POST['add_id']);
			$data['member_id'] =  $this->user['member_id'];
			$data['album_name'] = str_rp(trim($_POST['add_name']));
			$data['album_desc'] = str_rp(trim($_POST['add_desc']));
			if(empty($data['album_id'])){
				echo '-1';
				exit;
			}
			$res = M('goods_album')->save($data);
			if(empty($res)){
				echo '-1';
				exit;
			}		
			echo 1;	
			exit;
		}
			$res = M('goods_album')->where(array('album_id'=>$_GET['id']))->find();
			echo json_encode($res);
	}
	//专辑删除
	public function album_del(){
		$res = M('goods_album')->delete($_GET['del_id']);
		if(empty($res)){
			echo -1;
			exit;
		}
		echo 1;
	}
	
		
	//我的收藏
	public function my(){
		$this->display();
	}
	
    

}