<?php
class UsersController extends AppController {
	public $uses = ['User'];

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('admin_login','admin_logout');
		if( in_array( $this->request->params['action'] , [ 'admin_logout', 'admin_delete' ] ) ) {
			$this->autoRender = false;
		}
		$delete_modal_header = 'User delete';

		$this->set(compact('delete_modal_header'));
	}

	public function admin_login() {
		if( $this->request->is( 'post' ) ) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error('Invalid username or password, try again');
		}
	}

	public function admin_logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function admin_register() {
		if( $this->request->is('post') ) {
			$this->User->set($this->request->data);
			if( $this->User->validates() ) {
				$this->User->create();
				$user_count = $this->User->find('count',[
					'conditions' => [
						'OR' => [
							'User.username' => $this->request->data['User']['username'],
							'User.email' => $this->request->data['User']['email'],
						],
						'User.deleted' => [0,1]
					]
				]);
				if( $user_count > 0) {
					$this->Flash->success('The user is existing');
					return $this->redirect('/admin/users/register');
				}

				if( $this->User->save( $this->request->data )) {
					$this->Flash->success('The user has been saved');
					return $this->redirect('/admin/users/list');
				} else {
					$this->Flash->error('The user could not be saved. Please, try again.');
				}
			}
		}
	}

	public function admin_list() {
		$users = $this->User->find('all', [
			'order' 	=> 'User.created DESC'
		]);

		$this->set(compact('users'));
	}

	public function admin_delete() {
		if( $this->request->is('post') ) {
			if ( $this->User->delete($this->request->data['user_id']) ) {
				return true;
			}
			return false;
		}
	}

	public function admin_edit( $id = null ) {
		if( !$id ) {
			throw new BadRequestException();
		}

		if( $this->request->is(['post','put']) ) {
			unset($this->request->data['User']['username']);
			unset($this->request->data['User']['email']);
			unset($this->User->validate['username']);
			unset($this->User->validate['email']);
			$this->User->set($this->request->data);
			if( $this->User->validates() ) {
				$this->User->id = $id;
				if( $this->User->save($this->request->data) ) {
					$this->Flash->success('The user has been edited');
					return $this->redirect('/admin/users/edit/'.$id);
				} else {
					$this->Flash->error('The user could not be edited. Please, try again.');
				}
			}
		}

		if( !$this->User->findById($id) ) {
			$this->Flash->error('Invalid User');
			return $this->redirect('/admin/users/list');
		}
		$this->request->data = $this->User->findById($id);
	}

	public function admin_change_password( $id = null ) {
		if( !$id ) {
			throw new BadRequestException();
		}

		if( $this->request->is(['post','put']) ) {
			$this->User->set($this->request->data);
			if ( $this->User->validates( ['fieldList' => ['password']]) ) {
				$this->User->id = $id;
				if( $this->User->save($this->request->data) ) {
					$this->Flash->success('The password has been edited');
					return $this->redirect('/admin/users/change_password/'.$id);
				} else {
					$this->Flash->error('The password could not be edited. Please, try again.');
				}
			} 
		}
	}
}