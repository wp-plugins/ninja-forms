<?php
function ninja_forms_setup_processing_class(){
	global $ninja_forms_processing;
	//Set the form id
	$form_id = $_REQUEST['_form_id'];

	//Initiate our processing class with our designated global variable.
	$ninja_forms_processing = new Ninja_Forms_Processing($form_id);
	$ninja_forms_processing->setup_submitted_vars();
}



function ninja_forms_pre_process(){
	global $ninja_forms_processing;
	
	$ajax = $ninja_forms_processing->get_form_setting('ajax');
	$form_id = $ninja_forms_processing->get_form_ID();
	
	do_action('ninja_forms_before_pre_process');	
	
	if(!$ninja_forms_processing->get_all_errors()){
		do_action('ninja_forms_pre_process');
	}

	if(!$ninja_forms_processing->get_all_errors()){
		ninja_forms_process();
	}else{
		if($ajax == 1){
			$errors = ninja_forms_esc_html_deep( $ninja_forms_processing->get_all_errors() );
			$success = ninja_forms_esc_html_deep( $ninja_forms_processing->get_all_success_msgs() );
			$fields = ninja_forms_esc_html_deep( $ninja_forms_processing->get_all_fields() );
			$form_settings = ninja_forms_esc_html_deep( $ninja_forms_processing->get_all_form_settings() );
			$extras = ninja_forms_esc_html_deep( $ninja_forms_processing->get_all_extras() );

			//header('Content-Type', 'text/html');
			echo json_encode( array( 'form_id' => $form_id, 'errors' => $errors, 'success' => $success, 'fields' => $fields, 'form_settings' => $form_settings, 'extras' => $extras ) );
			die();
		}else{
			//echo 'pre-processing';
			//print_r($ninja_forms_processing->get_all_errors());
		}
	}
}