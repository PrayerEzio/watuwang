	//导航部分 
	$(function(){
		 $(window).scroll(function(){
		 	 var i=$(this).scrollTop();
		 	 if(i>45)
		 	 {
		 	 	$('.seek-box').addClass('fixed');
		 	 }
		 	 if(i<45)
		 	 {
		 	 	$('.seek-box').removeClass('fixed');
		 	 }
		 });

		 //关闭提示窗口
		$('.b-ico-close').click(function(){
		 	$('.modal-dialog-bg').hide();
		 	$('.modal-wrapper').hide();
		 });



		 //悬赏成功提示  
		 $('#affirm').click(function(){
		 	$('.modal-dialog-bg').show();
		 	$('.modal-item-2').show();
		 });

		//我的专辑 点击删除按钮
		$(".b-ico-del").click(function(){
			$(this).parent().next('.qued-del').show();
		});

		$('.spec-cancle').click(function(){
			$(this).parents('.qued-del').hide();
		});

		//充值奖励页充值选中
		$('#select-fs li a').click(function(){
			$('#select-fs li').each(function(){
				$(this).removeClass('selec');
			});
			$(this).parent().addClass('selec');
		});
		//充值奖励页充值选中
		$('.privilege-vip-box span a').click(function(){
			$('.privilege-vip-box span').each(function(){
				$(this).removeClass('selec');
			});
			$(this).parent().addClass('selec');
		});


	
});

// 全选
	function selectall(){
		var inp =document.getElementsByTagName('input');
		for(var i=0; i<inp.length; i++)
		{
			if (inp[i].type=="checkbox")
			{     
				if(inp[i].checked)
				{
				   inp[i].checked=false;	
				}
				else
				{
					inp[i].checked=true;	
				}
			}	
		}
	}

//  收藏
	function collect(obj)
	{
		var txt=$(obj).text();
		if(txt=="收藏")
		{
			$(obj).html('<i class="b-ico-face"></i>');
		}
		else
		{
			$(obj).html('收藏');
		}

	}


// 收藏改进效果
	function collects(obj)
	{
		var txt=$(obj).text();
		if(txt=="收藏")
		{	
			$(obj).prev().addClass('approves');
			$(obj).text('取消收藏');
			setTimeout(function(){$(obj).prev().removeClass('approves');},1000);
		}
		else
		{
			$(obj).html('收藏');
		}
	}





 //关闭提示窗口
 	function closeplay(){
 		$('.modal-dialog-bg').hide();
		$('.modal-wrapper').hide();
 	}

//添加专辑
	function addspecial(){
		$('.modal-dialog-bg').show();
		$('.modal-wrapper-big').show();
	}

//编辑专辑
	function editspecial(){
		$('.modal-dialog-bg').show();
		$('.modal-wrapper-edit').show();
	}

//操作成功弹窗
    function succeedplay(){
    	$('.modal-dialog-bg').show();
    	$('.succeed-play').show();
    }

//专辑页操作失败弹窗
    function failplay(){
    	$('.modal-dialog-bg').show();
    	$('.failplay').show();
    }
//账户余额充值 弹窗
    function rechargeplay(){
    	$('.modal-dialog-bg').show();
    	$('.rechargeplay').show();
    }
//站内信发送或回复 弹窗
    function Messagepaly(){
    	$('.sitesmessage').hide();
    	$('.modal-dialog-bg').show();
    	$('.Message-paly').show();
    }

//站内信删除确认 弹窗
    function issuepaly(){
    	$('.modal-dialog-bg').show();
    	$('.issuepaly').show();
    }
//站内信详情 弹窗
    function sitesmessage(){
    	$('.modal-dialog-bg').show();
    	$('.sitesmessage').show();
    }

//绑定手机号 弹窗
    function binding(){
    	$('.modal-dialog-bg').show();
    	$('.binding').show();
    }

//解除绑定 弹窗
    function relieveplay(){
    	$('.modal-dialog-bg').show();
    	$('.relieveplay').show();
    }

//锁定任务 弹窗
    function lockplay(){
    	$('.modal-dialog-bg').show();
    	$('.lockplay').show();
    }

//最加悬赏 弹窗
    function addbounty(){
    	$('.modal-dialog-bg').show();
		$('.modal-item-4').show();
    }

//悬赏弹窗
	function rewardplay(){
		$('.modal-dialog-bg').show();
		 	$('.modal-item-1').show();
	}

//取回赏金确认 弹窗
	function takeback(){
		$('.modal-dialog-bg').show();
		 	$('.modal-item-7').show();
	}

//取回赏金成功 弹窗
	function backsucceed(){
		$('.modal-dialog-bg').show();
		 	$('.backsucceed').show();
	}

//修改封面 弹窗
	function upamend(){
		$('.modal-dialog-bg').show();
		 	$('.upamend').show();
	}

//支付确认 弹窗
	function seekhelp(){
		$('.modal-dialog-bg').show();
		 	$('.seekhelp').show();
	}
