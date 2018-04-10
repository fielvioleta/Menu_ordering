<?php
class TablesController extends AppController {
	public $uses = ['TableNumber'];

	public function beforeFilter() {
		parent::beforeFilter();
		if( in_array( $this->request->params['action'] , [ 'admin_delete' ] ) ) {
			$this->autoRender = false;
		}
		$delete_modal_header = 'Table number delete';

		$this->set(compact('delete_modal_header'));
	}

	public function admin_list() {
		$tables = $this->TableNumber->find('all',[
			'order' 	=> 'TableNumber.created DESC'
		]);

		$this->set(compact('tables'));
	}

	public function admin_register() {
		if( $this->request->is('post') ) {
			$this->TableNumber->set($this->request->data);
			if( $this->TableNumber->validates() ) {
				if( $this->TableNumber->save( $this->request->data )) {
					$this->Flash->success('Table number has been saved');
					return $this->redirect('/admin/tables/list');
				} else {
					$this->Flash->error('The table number could not be saved. Please, try again.');
				}
			}
		}
	}

	public function admin_delete() {
		if( $this->request->is('post') ) {
			if ( $this->TableNumber->delete($this->request->data['table_id']) ) {
				return true;
			}
			return false;
		}
	}
}