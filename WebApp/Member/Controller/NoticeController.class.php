<?php
// +----------------------------------------------------------------------
// | 哇途网通知模块
// +----------------------------------------------------------------------
// | Copyright (c) http://www.muxiangdao.cn
// +----------------------------------------------------------------------
// | 功能区块:首页数据
// +----------------------------------------------------------------------
// | Author: 开发团队
// +----------------------------------------------------------------------
namespace Member\Controller;
use Think\Page;
class NoticeController extends BaseController {
	public function __construct(){
		parent::__construct();
		$this->user;
	} 
	 
	//站内信
	public function mail(){
		if(IS_POST){
			$nickname = str_rp(trim($_POST['nickname']));
			$title = str_rp(trim($_POST['title']));
			$content = str_rp(trim($_POST['content']));
			$status = str_rp(trim($_POST['status']));
			
			//检索网站中是否存在此昵称存在  在检索出收件人  Id
			$res = M('member')->where(array('nickname'=>$nickname))->find();
			if(empty($res)){
				$this->error('没有检索到此用户');
				exit;
			}
			if(empty($title)){
				$this->error('发送标题不能为空');
				exit;
			}
			if(empty($content)){
				$this->error('发送内容不能为空');
				exit;
			}
			$data = array(
				'number'=>order_sn(),					
				'out_id'=>$this->user['member_id'],
				'collect'=>$res['member_id'],
				'title'=>$title,
				'content'=>$content,
				'enclosure'=>'',
				'time' => NOW_TIME
			);
			M('mail')->add($data);
			if(!empty($status)){
				$m_data = array(
					'id'=>$status,
					'status'=>1
				);
				M('mail')->save($m_data);
			}
			$this->redirect('Member/Notice/mail',array('type'=>1));
			exit;
		}elseif(IS_GET){
			$type = intval($_GET['type']);
			//1 为 发送的数据
			if($type == 1){
				$where['out_id'] = $this->user['member_id'];
			}else{
				$where['collect'] = $this->user['member_id'];
			}
			$count = M('mail')->where($where)->count();
			$page = new Page($count,10);
			$this->show = $page->show();
			$this->list = M('mail')->where($where)->limit($page->listRows.','.$page->firstRow)->select();

			$this->display();
		}
	}
	//站内信删除
	public function mail_del(){
		if(IS_AJAX){
			$id = trim($_POST['id']);
			$id = substr($id,1);
			$res = M('mail')->delete($id);
			if(empty($res)){
				echo -1;
				exit;
			}
			echo 1;
		}
	}
	
		
    //举报申诉
    public function report(){
    	$this->display();
    }

    //发起申诉
    public function report_add(){
    	$this->display();
    }
    
    //查看申诉
    public function report_check(){
    	$this->display();
    }
}