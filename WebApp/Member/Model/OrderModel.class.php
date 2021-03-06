<?php
/**
 * 订单模型
 * @copyright  Copyright (c) 2014-2030 muxiangdao-cn Inc.(http://www.muxiangdao.cn)
 * @license    http://www.muxiangdao.cn
 * @link       http://www.muxiangdao.cn
 * @author	   muxiangdao-cn Team
 */
namespace Home\Model;
use Think\Model\RelationModel;

class OrderModel extends RelationModel{
	protected $_link = array(
		'OrderGoods' => array(             
			'mapping_type' => self::HAS_MANY,         
			'class_name' => 'OrderGoods', 
			'foreign_key' => 'order_id',
			'mapping_name'  => 'goods',
			'mapping_fields' => 'goods_id,goods_name,goods_price,goods_num,goods_image',
			'mapping_order' => 'goods_id desc',
		),
		'OrderAddress' => array(
			'mapping_type' => self::HAS_ONE,
			'class_name' => 'OrderAddress',
			'foreign_key' => 'order_id',
			'mapping_name' => 'address',
			'mapping_fields' => '',
		),
		'OrderLog' => array(
			'mapping_type' => self::HAS_ONE,
			'class_name' => 'OrderLog',
			'foreign_key' => 'order_id',
			'mapping_name' => 'Log',
			'mapping_fields' => '',
		),
	);
}
