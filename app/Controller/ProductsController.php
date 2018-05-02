<?php
App::import('Vendor', 'ImageTool');
App::uses('Folder', 'Utility');

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
			if ($this->request->data['Product']['image']['error'] === 0) {
				$tmpFoldername 	= str_shuffle(time() . mt_rand());
				$tmpFolder 		= WWW_ROOT . 'files/products/tmp/'.$tmpFoldername;
				$image_name 	= $this->request->data['Product']['image']['name'];
				$filepath		= $tmpFolder . '/product.' . pathinfo($image_name, PATHINFO_EXTENSION);
				$filepathCopy	= $tmpFolder . '/show-product.' . pathinfo($image_name, PATHINFO_EXTENSION);
				$generatedFile	= 'product.' . pathinfo($image_name, PATHINFO_EXTENSION);

				if (!is_dir( $tmpFolder )) {
					mkdir($tmpFolder, 0777, true);
				}

				if(!move_uploaded_file(
					$this->request->data['Product']['image']['tmp_name'], 
					$filepath)
				) {
					$this->Flash->error('Error in saving image please try again');
					return $this->redirect('/admin/products/register');
				} else {
					ImageTool::resize([
						'input' 	=> $filepath,
						'output' 	=> $filepathCopy,
						'width' 	=> 358
					]);
					$this->Session->write('Product.tmpFolder' , $tmpFoldername);
					$this->Session->write('Product.tmpfileName' , $generatedFile);
				}	
			}
			
			$this->Product->set($this->request->data);
			if( $this->Product->validates() ) {
				if( $this->Product->save($this->request->data) ) {
					if ($this->request->data['Product']['image']['error'] === 0) {
						$id = $this->Product->getLastInsertID();
						$folder = new Folder();
						$folder->copy([
						    'to' 		=> WWW_ROOT. 'files/products/' . $id,
						    'from' 		=> $tmpFolder,
						    'mode' 		=> 0755,
						    'recursive' => true
						]);
						$this->Product->saveField('image_path', '/files/products/' . $id . '/show-product.' . pathinfo($image_name, PATHINFO_EXTENSION));
						$folder = new Folder($tmpFolder);
						$folder->delete();
					}

					$this->Flash->success('The product has been saved');
					$this->Session->delete('Product');
					return $this->redirect('/admin/products/list');
				} else {
					$this->Flash->error('The product could not be saved. Please, try again.');
				}
			} 
		}
		$categories = $this->Category->find('list' , [
			'fields' => ['id' , 'name']
		]);
		$available = [ 0 => 'Available', 1 => 'Not available'];

		if ( $this->Session->read('Product.tmpFolder') ) {
			$localhost = Configure::read('localhost');
			$path = $localhost . 'files/products/tmp/' . $this->Session->read('Product.tmpFolder') . '/' . $this->Session->read('Product.tmpfileName');
			$arrFiles['name'] = basename($path);
			$arrFiles['type'] = "image/".pathinfo( $path , PATHINFO_EXTENSION );
			$arrFiles['file'] = $path;
			$this->set( 'files' , [$arrFiles] );
			$this->Session->delete('Product');
		}

		$this->set(compact('categories', 'available'));
	}

	public function admin_edit( $id = null ) {
		if( !$id ) {
			throw new BadRequestException();
		}

		if( $this->request->is(['post','put']) ) {
			$this->Product->set($this->request->data);
			if( $this->Product->validates() ) {
				$this->Product->id = $id;
				if( $this->Product->save($this->request->data) ) {
					if ($this->request->data['Product']['image']['error'] === 0) {
						$folder 		= WWW_ROOT . 'files/products/' . $id;
						$image_name 	= $this->request->data['Product']['image']['name'];
						$filepath		= $folder . '/product.' . pathinfo($image_name, PATHINFO_EXTENSION);
						$filepathCopy	= $folder . '/show-product.' . pathinfo($image_name, PATHINFO_EXTENSION);
						$generatedFile	= 'product.' . pathinfo($image_name, PATHINFO_EXTENSION);
						$this->Product->saveField('image_path', '/files/products/' . $id . '/show-product.' . pathinfo($image_name, PATHINFO_EXTENSION));

						if (!is_dir( $folder )) {
							mkdir($folder, 0777, true);
						}

						$dir 			= new Folder($folder);
						$existingFiles 	= $dir->find('.*');
						foreach ($existingFiles as $file) {
							$file = new File($dir->pwd() . DS . $file);
							$file->delete();
						}

						if(!move_uploaded_file(
							$this->request->data['Product']['image']['tmp_name'], 
							$filepath)
						) {
							$this->Flash->error('Error in saving image please try again');
							return $this->redirect('/admin/products/edit/' . $id);
						} else {
							ImageTool::resize([
								'input' 	=> $filepath,
								'output' 	=> $filepathCopy,
								'width' 	=> 358
							]);
						}
					} else {
						if( $this->request->data['Product']['image_selected'] == 'false' ) {
							$folder 		= WWW_ROOT . 'files/products/' . $id;
							$dir 			= new Folder($folder);
							$existingFiles 	= $dir->find('.*');
							foreach ($existingFiles as $file) {
								$file = new File($dir->pwd() . DS . $file);
								$file->delete();
							}
						}
					}

					$this->Flash->success('The product has been edited');
					return $this->redirect('/admin/products/edit/'.$id);
				} else {
					$this->Flash->error('The product could not be edited. Please, try again.');
				}
			}
		}

		if( !$this->Product->findById($id) ) {
			$this->Flash->error('Invalid Product');
			return $this->redirect('/admin/products/list');
		}
		$this->request->data = $this->Product->findById($id);

		$categories = $this->Category->find('list' , [
			'fields' => ['id' , 'name']
		]);
		$available = [ 0 => 'Available', 1 => 'Not available'];

		$path 	= WWW_ROOT. 'files/products/'. $id ;
		$dir 	= new Folder( $path );
		$files 	= $dir->find('.*', true);
		$arrFiles = [];
		foreach ( $files  as $key => $value) {
			if ( pathinfo($value)['filename'] === 'product' ) {
				$localhost = Configure::read('localhost');
				$arrFiles[$key]['name'] = basename($value);
				$arrFiles[$key]['type'] = "image/".pathinfo( $value , PATHINFO_EXTENSION );
				$arrFiles[$key]['file'] = $localhost . 'files/products/' . $id . '/' . $value;
			}
			
		}

		$this->set( 'files' , $arrFiles );
		$this->set(compact('categories', 'available'));
	}

	public function admin_delete() {
		if( $this->request->is('post') ) {
			if ( $this->Product->delete($this->request->data['user_id']) ) {
				$folder = new Folder(WWW_ROOT . 'files/products/' . $this->request->data['user_id']);
				$folder->delete();
				return true;
			}
			return false;
		}
	}
}