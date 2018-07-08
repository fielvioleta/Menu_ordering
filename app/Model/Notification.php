<?php
App::uses('AppModel', 'Model');
/**
* Notification details Model
*
**/
class Notification extends AppModel {
	public $belongsTo = 'Order';	
}
