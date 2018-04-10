<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
* Users Model
*
**/
class User extends AppModel {
	public $validate = [
		'username' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'A username is required'
			],
			'unique' => [
				'rule' => 'isUnique',
				'message' => 'Provided username already exists.'
			],
			'maxLength' => [
				'rule' => ['maxLength', 30],
				'message' => 'Username cannot be more than 30 characters.'
			]
        ],
        'password' => [
            'required' => [
                'rule' => 'notBlank',
                'message' => 'A password is required',
			],
			'maxLength' => [
				'rule' => ['maxLength', 30],
				'message' => 'Password cannot be more than 30 characters.'
			],
			'password_confirm'=> [
                'rule'=> [ 'password_confirm' ],
                'message'=>'Passwords did not match',
            ],  
        ],
        'user_type' => [
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'User type is required',
				'allowEmpty' => false
			),
        ],
        'first_name' => [
            'required' => [
                'rule' => 'notBlank',
                'message' => 'First name is required',
            ],
			'maxLength' => [
				'rule' => ['maxLength', 30],
				'message' => 'First name cannot be more than 30 characters.'
			]
        ],
        'last_name' => [
            'required' => [
                'rule' => 'notBlank',
                'message' => 'Last name is required',
            ],
			'maxLength' => [
				'rule' => ['maxLength', 30],
				'message' => 'Last name cannot be more than 30 characters.'
			],
        ],
        'email' => [
            'required' => [
                'rule' => [ 'email' ],
                'message' => 'Correct email is required',
            ],
			'unique' => [
				'rule' => 'isUnique',
				'message' => 'Provided Email already exists.'
			]
        ],
    ];

    public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash( $this->data[$this->alias]['password'] );
		}
		return true;
	}

	public function password_confirm(){ 
        if ($this->data['User']['password'] !== $this->data['User']['password_confirm']){
            return false;
        }
        return true;
    }
}
