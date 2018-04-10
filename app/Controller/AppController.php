<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $helpers = [ 'Html', 'Form' ];
	public $components = [
		'Session',
		'DebugKit.Toolbar',
        'Flash',
        'Auth' => [
            'loginRedirect' => [
                'controller' => 'dashboard',
                'action' => 'admin_index'
            ],
            'logoutRedirect' => [
                'controller' => 'users',
                'action' => 'admin_login'
            ],
            'authenticate' => [
                'Form' => [
                    'passwordHasher' => 'Blowfish'
                ]
            ]
        ]
    ];

	public function beforeFilter() {
        if( isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin' && $this->request->params['action'] == 'admin_login' ) {
            $this->layout = 'admin_login';
        } else {
            $this->layout = 'admin';
        }
		$title = "Menu Ordering System";
        $controller = $this->request->params['controller'];
		$this->set(compact(
            'title',
            'controller'
        ));
	}
}
