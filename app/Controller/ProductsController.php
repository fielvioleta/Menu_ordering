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
			$tmpFoldername = str_shuffle(time().mt_rand());
			$tmpFolder = WWW_ROOT. 'files/products/tmp/'.$tmpFoldername;
			if (!is_dir( $tmpFolder )) {
				mkdir($tmpFolder, 0777, true);
			}

			if(!move_uploaded_file($this->request->data['Product']['image']['tmp_name'], $tmpFolder . '/' . $this->request->data['Product']['image']['name'])) {
				$this->Flash->success('Error in saving image please try again');
				return $this->redirect('/admin/products/register');
			}
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
		$this->set(compact('categories', 'available', 'image_data'));
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