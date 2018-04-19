<?php
class ApisController extends AppController {
	public $uses = ['Product', 'Category'];

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('getProducts', 'getCategories');
		$this->autoRender = false;
	}

	public function getProducts() {
		$products = $this->Product->find('all', [
			'fields' => ['id', 'name', 'description']
		]);
		return json_encode($products);
	}

	public function getCategories () {
		$categories = $this->Category->find('all', [
			'fields' => ['id', 'name', 'description']
		]);
	 	return json_encode($categories);
	}
}