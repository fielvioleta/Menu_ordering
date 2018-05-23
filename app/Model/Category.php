<?php
App::uses('AppModel', 'Model');
/**
* Categories Model
*
**/
class Category extends AppModel {
	public $hasMany = 'Product';
	public $actsAs 	= ['Containable'];
	public $validate = [
		'name' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'A name is required'
			],
			'maxLength' => [
				'rule' => ['maxLength', 30],
				'message' => 'Name cannot be more than 30 characters.'
			]
        ],
    ];
}
