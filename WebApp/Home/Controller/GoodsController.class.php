<?php
// +-------------------------------------------------------------------------------------
// | 哇途网列表页
// +-------------------------------------------------------------------------------------
// | Copyright (c) http://www.muxiangdao.cn
// +-------------------------------------------------------------------------------------
// | 功能区块:  结构视图
// +-------------------------------------------------------------------------------------
// | Author: 开发团队
// +-------------------------------------------------------------------------------------
namespace Home\Controller;
use Think\Page;
class GoodsController extends BaseController {
	public function __construct(){
		parent::__construct();
	} 
	//找图
    public function images(){	
    	
		$where['goods_type'] = 'images';
		$tag = str_rp(trim($_GET['tag']));
		switch ($tag){
			case 'time':
				$order = 'goods_time desc';
				break;
			case 'money':
				$order = 'goods_reward desc';
				break;
			case 'num':
				$order = '';
				break;
			case '1':
				$where['goods_bid_status'] = 1;
				break;
		}
		if(empty($tag)){
			$order = 'goods_time desc';
		}
		$where['goods_status'] = 1;
		$conut = M('goods')->where($where)->count();
		$page = new Page($conut,10);
		$this->show = $page->show();
		$list = M('goods')->where($where)->order('goods_time desc')->limit($page->firstRow.','.$page->listRows)->select();
		foreach ($list as $key => $val){
			$img = $list[$key]['img_id'];
			$img = explode(',', $img);
			array_pop($img);
			$list[$key]['img_list'] = M('goods_img')->where(array('img_id'=>$img[0]))->getField('img_link');
		}
		$this->list = $list;
		$this->tag = $tag;
    	$this->display();
    }
    
    //字体
    public function font(){
		$where['goods_type'] = 'font';
		$tag = str_rp(trim($_GET['tag']));
		switch ($tag){
			case 'time':
				$order = 'goods_time desc';
				break;
			case 'money':
				$order = 'goods_reward desc';
				break;
			case 'num':
				$order = '';
				break;
			case '1':
				$where['goods_bid_status'] = 1;
				break;
		}
		$where['goods_status'] = 1;
		$conut = M('goods')->where($where)->count();
		$page = new Page($conut,10);
		$this->show = $page->show();
		$list = M('goods')->where($where)->order('goods_time desc')->limit($page->firstRow.','.$page->listRows)->select();
		foreach ($list as $key => $val){
			$img = $list[$key]['img_id'];
			$img = explode(',', $img);
			array_pop($img);
			$list[$key]['img_list'] = M('goods_img')->where(array('img_id'=>$img[0]))->getField('img_link');
		}
		$this->list = $list;
		$this->tag = $tag;
    	$this->display();
    }
    
    //画图
    public function drawing(){
		$where['goods_type'] = 'drawing';
		$tag = str_rp(trim($_GET['tag']));
		switch ($tag){
			case 'time':
				$order = 'goods_time desc';
				break;
			case 'money':
				$order = 'goods_reward desc';
				break;
			case 'num':
				$order = '';
				break;
			case '1':
				$where['goods_bid_status'] = 1;
				break;
		}
		$where['goods_status'] = 1;
		$conut = M('goods')->where($where)->count();
		$page = new Page($conut,10);
		$this->show = $page->show();
		$list = M('goods')->where($where)->order('goods_time desc')->limit($page->firstRow.','.$page->listRows)->select();
		foreach ($list as $key => $val){
			$img = $list[$key]['img_id'];
			$img = explode(',', $img);
			array_pop($img);
			$list[$key]['img_list'] = M('goods_img')->where(array('img_id'=>$img[0]))->getField('img_link');
		}
		$this->list = $list;
		$this->tag = $tag;
    	$this->display();
    }

    //折扣下载
    public function rebate(){
		$where['goods_type'] = 'rebate';
		$tag = str_rp(trim($_GET['tag']));
		switch ($tag){
			case 'time':
				$order = 'goods_time desc';
				break;
			case 'money':
				$order = 'goods_reward desc';
				break;
			case 'num':
				$order = '';
				break;
			case '1':
				$where['goods_bid_status'] = 1;
				break;
		}
		$where['goods_status'] = 1;
		$conut = M('goods')->where($where)->count();
		$page = new Page($conut,10);
		$this->show = $page->show();
		$list = M('goods')->where($where)->order('goods_time desc')->limit($page->firstRow.','.$page->listRows)->select();
		foreach ($list as $key => $val){
			$img = $list[$key]['img_id'];
			$img = explode(',', $img);
			array_pop($img);
			$list[$key]['img_list'] = M('goods_img')->where(array('img_id'=>$img[0]))->getField('img_link');
		}
		$this->list = $list;
		$this->tag = $tag;
    	$this->display();
    }

    //购图
    public function concept(){
		$where['goods_type'] = 'concept';
		$conut = M('goods')->where($where)->count();
		$page = new Page($conut,10);
		$this->show = $page->show();
		$list = M('goods')->where($where)->order('goods_time desc')->limit($page->firstRow.','.$page->listRows)->select();
		foreach ($list as $key => $val){
			$img = $list[$key]['img_id'];
			$img = explode(',', $img);
			array_pop($img);
			$list[$key]['img_list'] = M('goods_img')->where(array('img_id'=>$img[0]))->getField('img_link');
		}
		$this->list = $list;
    	$this->display();
    }    
// +-------------------------------------end------------------------------------------------  
	//找图详情
    public function images_details(){
    	$this->display();
    }

    //字体
    public function font_details(){
    	$this->display();
    }
    
    //画图
    public function drawing_details(){
    	$this->display();
    }
    
    //折扣下载
    public function rebate_details(){
    	$this->display();
    }

    //购图
    public function concept_details(){
    	$this->display();
    }
    
}