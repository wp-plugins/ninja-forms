<?php
add_action( 'init', 'ninja_forms_register_req_fields_process' );
function ninja_forms_register_req_fields_process(){
	add_action( 'ninja_forms_pre_process', 'ninja_forms_req_fields_process', 13);
}

function ninja_forms_req_fields_process(){
	global $ninja_forms_processing, $ninja_forms_fields;
	$all_fields = $ninja_forms_processing->get_all_fields();

	if( is_array( $all_fields ) AND !empty( $all_fields ) ){
		foreach($all_fields as $field_id => $user_value){
			$field_row = $ninja_forms_processing->get_field_settings( $field_id );
			
			$field_data = $field_row['data'];
			$field_type = $field_row['type'];
			$req = $field_data['req'];
			$label_pos = $field_data['label_pos'];
			$label = $field_data['label'];
			
			$reg_type = $ninja_forms_fields[$field_type];
			
			$req_validation = $reg_type['req_validation'];

			$plugin_settings = get_option("ninja_forms_settings");
			$req_field_error = $plugin_settings['req_field_error'];

			if($req == 1){
				if($req_validation != ''){
					$arguments['field_id'] = $field_id;
					$arguments['user_value'] = $user_value;
					$req = call_user_func_array($req_validation, $arguments);
					if(!$req){
						$ninja_forms_processing->add_error('required-'.$field_id, $req_field_error, $field_id);
					}
				}else{
					if($label_pos == 'inside'){
						if($user_value == $label){
							$ninja_forms_processing->add_error('required-'.$field_id, $req_field_error, $field_id);
						}
					}else{
						if($user_value == ''){
							$ninja_forms_processing->add_error('required-'.$field_id, $req_field_error, $field_id);
						}
					}
				}
			}
		}
	}
}