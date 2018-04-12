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

	public function admin_edit( $id = null ) {
		if( !$id ) {
			throw new BadRequestException();
		}
		pr($this->Category->find);

		if( $this->request->is(['post','put']) ) {
			$this->Category->set($this->request->data);
			if( $this->Category->validates() ) {
				$this->Category->id = $id;
				if( $this->Category->save($this->request->data) ) {
					$this->Flash->success('The category has been edited');
					return $this->redirect('/admin/categories/edit/'.$id);
				} else {
					$this->Flash->error('The category could not be edited. Please, try again.');
				}
			}
		}

		if( !$this->Category->findById($id) ) {
			$this->Flash->error('Invalid User');
			return $this->redirect('/admin/categories/list');
		}
		$this->request->data = $this->Category->findById($id);
	}

	public function admin_delete() {
		if( $this->request->is('post') ) {
			$categoryId = $this->request->data['cateogry_id'];
			if ( $this->Category->delete( $categoryId ) ) {
				return true;
			}
			return false;
		}
	}
}