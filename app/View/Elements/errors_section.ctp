<?php 
	//check if there is validation errors
	$list =[];
	if( !empty( $this->validationErrors ) ) {
		// loops the value of validationErrors
		foreach ( $this->validationErrors as $key => $value ) {
			// check if each model has validation error
			if( !empty( $value ) ) {
				foreach ( $value as $field_index => $field_error ) {
					array_push( $list, $field_error[0] );
				}
			}
		}
		echo $this->Html->nestedList( $list,
			[],
			['style'=>'margin-bottom:10px;color:red']
		);
	}
