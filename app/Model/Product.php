<?php
App::uses('AppModel', 'Model');
/**
* Products Model
*
**/
class Product extends AppModel {
	public $belongsTo  = 'Category';
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
        'description' => [
			'maxLength' => [
				'rule' => ['maxLength', 255],
				'message' => 'Description cannot be more than 255 characters.'
			]
        ],
        'category_id' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Category is required'
			]
        ],
        'price' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Price is required'
			]
        ],
        'is_not_available' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Availability is required'
			]
        ],
    ];
}
