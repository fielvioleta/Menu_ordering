<?php
App::import('Vendor', 'ImageTool');
App::uses('Folder', 'Utility');

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
			if ($this->request->data['Category']['image']['error'] === 0) {
				$tmpFoldername 	= str_shuffle(time() . mt_rand());
				$tmpFolder 		= WWW_ROOT . 'files/categories/tmp/'.$tmpFoldername;
				$image_name 	= $this->request->data['Category']['image']['name'];
				$filepath		= $tmpFolder . '/category.' . pathinfo($image_name, PATHINFO_EXTENSION);
				$filepathCopy	= $tmpFolder . '/show-category.' . pathinfo($image_name, PATHINFO_EXTENSION);
				$generatedFile	= 'category.' . pathinfo($image_name, PATHINFO_EXTENSION);

				if (!is_dir( $tmpFolder )) {
					mkdir($tmpFolder, 0777, true);
				}

				if(!move_uploaded_file(
					$this->request->data['Category']['image']['tmp_name'], 
					$filepath)
				) {
					$this->Flash->error('Error in saving image please try again');
					return $this->redirect('/admin/categories/register');
				} else {
					ImageTool::resize([
						'input' 	=> $filepath,
						'output' 	=> $filepathCopy,
						'width' 	=> 358
					]);
					$this->Session->write('Category.tmpFolder' , $tmpFoldername);
					$this->Session->write('Category.tmpfileName' , $generatedFile);
				}	
			}
			$this->Category->set($this->request->data);
			if( $this->Category->validates() ) {
				if( $this->Category->save($this->request->data) ) {
					if ($this->request->data['Category']['image']['error'] === 0) {
						$id = $this->Category->getLastInsertID();
						$folder = new Folder();
						$folder->copy([
						    'to' 		=> WWW_ROOT. 'files/categories/' . $id,
						    'from' 		=> $tmpFolder,
						    'mode' 		=> 0755,
						    'recursive' => true
						]);
						$this->Category->saveField('image_path', '/files/categories/' . $id . '/show-category.' . pathinfo($image_name, PATHINFO_EXTENSION));
						$folder = new Folder($tmpFolder);
						$folder->delete();
					}

					$this->Session->delete('Category');
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

		if( $this->request->is(['post','put']) ) {
			$this->Category->set($this->request->data);
			if( $this->Category->validates() ) {
				$this->Category->id = $id;
				if( $this->Category->save($this->request->data) ) {
					if ($this->request->data['Category']['image']['error'] === 0) {
						$folder 		= WWW_ROOT . 'files/categories/' . $id;
						$image_name 	= $this->request->data['Category']['image']['name'];
						$filepath		= $folder . '/category.' . pathinfo($image_name, PATHINFO_EXTENSION);
						$filepathCopy	= $folder . '/show-category.' . pathinfo($image_name, PATHINFO_EXTENSION);
						$generatedFile	= 'category.' . pathinfo($image_name, PATHINFO_EXTENSION);
						$this->Category->saveField('image_path', '/files/categories/' . $id . '/show-category.' . pathinfo($image_name, PATHINFO_EXTENSION));

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
							$this->request->data['Category']['image']['tmp_name'], 
							$filepath)
						) {
							$this->Flash->error('Error in saving image please try again');
							return $this->redirect('/admin/categories/edit/' . $id);
						} else {
							ImageTool::resize([
								'input' 	=> $filepath,
								'output' 	=> $filepathCopy,
								'width' 	=> 358
							]);
						}
					} else {
						if( $this->request->data['Category']['image_selected'] == 'false' ) {
							$folder 		= WWW_ROOT . 'files/categories/' . $id;
							$dir 			= new Folder($folder);
							$existingFiles 	= $dir->find('.*');
							foreach ($existingFiles as $file) {
								$file = new File($dir->pwd() . DS . $file);
								$file->delete();
							}
						}
					}

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

		$path 	= WWW_ROOT. 'files/categories/'. $id ;
		$dir 	= new Folder( $path );
		$files 	= $dir->find('.*', true);
		$arrFiles = [];
		foreach ( $files  as $key => $value) {
			if ( pathinfo($value)['filename'] === 'category' ) {
				$localhost = Configure::read('localhost');
				$arrFiles[$key]['name'] = basename($value);
				$arrFiles[$key]['type'] = "image/".pathinfo( $value , PATHINFO_EXTENSION );
				$arrFiles[$key]['file'] = $localhost . 'files/categories/' . $id . '/' . $value;
			}
			
		}
		
		$this->set( 'files' , $arrFiles );
	}

	public function admin_delete() {
		if( $this->request->is('post') ) {
			$categoryId = $this->request->data['cateogry_id'];
			if ( $this->Category->delete( $categoryId ) ) {
				$folder = new Folder(WWW_ROOT . 'files/categories/' . $categoryId);
				$folder->delete();
				return true;
			}
			return false;
		}
	}
}