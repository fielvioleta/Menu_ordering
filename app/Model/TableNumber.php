<?php
App::uses('AppModel', 'Model');
/**
* Tables Model
*
**/
class TableNumber extends AppModel {
	public $validate = [
		'table_number' => [
			'required' => [
				'rule' => 'notBlank',
				'message' => 'Table number is required.'
			],
			'numeric' => [
				'rule' => 'numeric',
				'message' => 'It only accepts numbers.'
			]
		]
	];
}
