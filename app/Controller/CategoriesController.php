<?php

class CategoriesController extends AppController {

	public $uses = ['Category'];

	public function beforeFilter() {
		parent::beforeFilter();
		if( in_array( $this->request->params['action'] , [ 'admin_delete' ] ) ) {
			$this->autoRender = false;
		}
		$delete_modal_header = 'Category delete';

		$this->set(compact('delete_modal_header'));
	}

	public function admin_list() {
		$categories = $this->Category->find('all', [
			'order' 	=> 'Category.created DESC'
		]);

		$this->set(compact('categories'));
	}

	public function admin_register() {
		if($this->request->is('post')) {
			$this->Category->set($this->request->data);
			if( $this->Category->validates() ) {
				if( $this->Category->save($this->request->data) ) {
					$this->Flash->success('The category has been saved');
					return $this->redirect('/admin/categories/list');
				} else {
					$this->Flash->error('The category could not be saved. Please, try again.');
				}
			}
		}
	}

	public function admin_delete() {
		if( $this->request->is('post') ) {
			$categoryId = $this->request->data['cateogry_id'];
			if ( $this->Category->delete( $categoryId ) ) {
				$categoryFolder = WWW_ROOT. 'images/category/'.$categoryId;
				array_map('unlink', glob("$categoryFolder/*.*"));
				rmdir($categoryFolder);
				return true;
			}
			return false;
		}
	}
}