<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST', 'PUT');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

class ApisController extends AppController {
	public $uses = [
		'Product',
		'Category',
		'TableNumber',
		'Order',
		'OrderDetail'
	];

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow([
			'getProducts',
			'getCategories',
			'getProductsByCategoryId',
			'getOrderData',
			'getAllOrders',
			'getProductsForKitchen',
			'occupyTable',
			'saveOrders',
			'updateKitchenStatus',
			'updateAvailability'
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

	public function getProductsByCategoryId($category_id = null) {
		if( !$category_id ) {
			throw new BadRequestException();
		}

		$products = $this->Product->find('all', [
			'fields'		=> ['id', 'name', 'description', 'category_id', 'image_path', 'price', 'is_not_available'],
			'conditions'	=> ['category_id' => $category_id, 'is_not_available' => 0],
		]);

		return json_encode($products);
	}

	public function getOrderData( $order_id = null ) {
		if( !$order_id ) {
			throw new BadRequestException();
		}
		$data = $this->OrderDetail->find('all', [
			'conditions' 	=> ['order_id' => $order_id],
			'fields'		=> ['OrderDetail.id', 'OrderDetail.quantity', 'OrderDetail.kitchen_status', 'OrderDetail.sub_total',
								'Product.name', 'Product.image_path', 'Product.price'],
			'order'			=> ['OrderDetail.created' => 'asc']
		]);
		$returnData = [];

		foreach ($data as $key => $value) {
			$returnData[$key]['order_id'] = $value['OrderDetail']['id'];
			$returnData[$key]['quantity'] = $value['OrderDetail']['quantity'];
			$returnData[$key]['kitchen_status'] = $value['OrderDetail']['kitchen_status'];
			$returnData[$key]['sub_total'] = $value['OrderDetail']['sub_total'];
			$returnData[$key]['name'] = $value['Product']['name'];
			$returnData[$key]['image_path'] = $value['Product']['image_path'];
			$returnData[$key]['price'] = $value['Product']['price'];
		}

		return json_encode($returnData);
	}

	public function getAllOrders() {
		$data = $this->OrderDetail->find('all', [
			'fields'	=> [
				'Order.table_id',
				'OrderDetail.id',
				'OrderDetail.quantity',
				'OrderDetail.kitchen_status',
				'Product.name',
				'Product.image_path'
			],
			'order' 	=> [
				'OrderDetail.kitchen_status' => 'ASC',
				'OrderDetail.created' => 'DESC'
			]
		]);
		$return_data = [];
		foreach ($data as $key => $value) {
			$return_data[$key]['table_id'] = $value['Order']['table_id'];
			$return_data[$key]['order_detail_id'] = $value['OrderDetail']['id'];
			$return_data[$key]['quantity'] = $value['OrderDetail']['quantity'];
			$return_data[$key]['kitchen_status'] = $value['OrderDetail']['kitchen_status'];
			$return_data[$key]['product_name'] = $value['Product']['name'];
			$return_data[$key]['product_image_path'] = $value['Product']['image_path'];
		}
		return json_encode($return_data);
	}

	public function getProductsForKitchen() {
		$data = $this->Category->find('all', [
			'contain' 			=> [
		        'Product' 		=> [
		       		'fields' 	=> [
		       			'Product.id',
		       			'Product.name',
		       			'Product.image_path',
		       			'Product.is_not_available'
		       		]
		        ]
		    ],
		    'fields' 			=> [
		    	'Category.name'
		    ],
		    'order' 			=> ['Category.id' => 'ASC']
		]);		
		return json_encode($data);
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

	public function saveOrders() {
		
		if($this->request->is('post')){
			$data = $this->request->input ( 'json_decode', true);
			$order_detail_data = $data['orders'];

			if ( $data['order_id'] === '' ) {
				return $this->newOrder($data, $order_detail_data);
			} else {
				return $this->followUpOrder($data, $order_detail_data);
			}
			
		}
	}

	public function newOrder($data, $order_detail_data) {
		$datasource = $this->Product->getDataSource();

		try {
			$datasource->begin();
			if ( $this->Order->save($data) ) {
				$order_id = $this->Order->getLastInsertID();
				foreach ($order_detail_data as $key => $value) {
					$order_detail_data[$key]['order_id'] = $order_id;
				}
				$this->OrderDetail->saveAll($order_detail_data);
			}

			$datasource->commit();
			return $order_id;
		} catch(Exception $e) {
			$datasource->rollback();
		}
	}

	public function followUpOrder($data, $order_detail_data) {
		$datasource = $this->OrderDetail->getDataSource();

		try {
			$datasource->begin();

			$order_id = $data['order_id'];
			foreach ($order_detail_data as $key => $value) {
				$order_detail_data[$key]['order_id'] = $order_id;
			}
			$this->OrderDetail->saveAll($order_detail_data);

			$datasource->commit();
			return $order_id;
		} catch(Exception $e) {
			$datasource->rollback();
		}
	}

	public function updateKitchenStatus() {
		if($this->request->is('post')){
			$data = $this->request->input ( 'json_decode', true);

			if( !$data['id'] ) {
				throw new BadRequestException();
			}
			$this->OrderDetail->id = $data['id'];
			if($this->OrderDetail->saveField('kitchen_status', 1)) {
				return true;
			}
			return false;
		}
	}

	public function updateAvailability() {
		if($this->request->is('post')){
			$data = $this->request->input ( 'json_decode', true);

			if( !$data['id'] ) {
				throw new BadRequestException();
			}
			$this->Product->id = $data['id'];
			if($this->Product->saveField('is_not_available', $data['availability'])) {
				return true;
			}
			return false;
		}
	}
}