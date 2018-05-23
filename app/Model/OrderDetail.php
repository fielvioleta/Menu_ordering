<?php
App::uses('AppModel', 'Model');
/**
* Order details Model
*
**/
class OrderDetail extends AppModel {
	public $belongsTo = ['Product', 'Order'];
}
