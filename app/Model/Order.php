<?php
App::uses('AppModel', 'Model');
/**
* Products Model
*
**/
class Order extends AppModel {
	public $hasMany = 'OrderDetail';
	public $validate = [];
}
