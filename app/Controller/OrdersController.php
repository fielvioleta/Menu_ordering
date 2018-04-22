<?php
class OrdersController extends AppController {

	public $uses = ['Order'];

	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function admin_list() {
		$orders = $this->Order->find('all', [
			'order' 	=> 'Order.created DESC'
		]);

		$this->set(compact('orders'));
	}

}