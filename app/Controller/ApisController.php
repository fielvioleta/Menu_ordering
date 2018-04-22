<?php
header("Access-Control-Allow-Origin: *");

class ApisController extends AppController {
	public $uses = [
		'Product',
		'Category',
		'TableNumber'
	];

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow([
			'getProducts',
			'getCategories',
			'occupyTable'

		]);
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

	public function occupyTable($table_id = null) {
		if( !$table_id ) {
			throw new BadRequestException();
		}

		if($this->request->is('get')) {
			$this->TableNumber->id = $table_id;
			if($this->TableNumber->saveField('is_occupied', true)) {
				return true;
			}
			return false;
		}
	}
}