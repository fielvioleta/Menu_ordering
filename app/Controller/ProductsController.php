<?php

class ProductsController extends AppController {

	public $uses = ['Product', 'Category'];

	public function beforeFilter() {
		parent::beforeFilter();
		if( in_array( $this->request->params['action'] , [ 'admin_delete' ] ) ) {
			$this->autoRender = false;
		}
		$delete_modal_header = 'Product delete';

		$this->set(compact('delete_modal_header'));
	}

	public function admin_list() {
		$products = $this->Product->find('all', [
			'order' 	=> 'Product.created DESC'
		]);

		$this->set(compact('products'));
	}

	public function admin_register() {
		if($this->request->is('post')) {
			pr($this->request->data);
			// $this->Product->set($this->request->data);
			// if( $this->Product->validates() ) {
			// 	if( $this->Product->save($this->request->data) ) {
			// 		$this->Flash->success('The product has been saved');
			// 		return $this->redirect('/admin/products/list');
			// 	} else {
			// 		$this->Flash->error('The product could not be saved. Please, try again.');
			// 	}
			// }
		}
		$categories = $this->Category->find('list' , [
			'fields' => ['id' , 'name']
		]);
		$available = [ 0 => 'Available', 1 => 'Not available'] ;
		$this->set(compact('categories', 'available'));
	}

	public function admin_delete() {
		if( $this->request->is('post') ) {
			$productId = $this->request->data['cateogry_id'];
			if ( $this->Category->delete( $categoryId ) ) {
				return true;
			}
			return false;
		}
	}
}