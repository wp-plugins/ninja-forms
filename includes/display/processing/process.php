<?php
function ninja_forms_process(){
	global $wpdb, $ninja_forms_fields, $ninja_forms_processing;

	$ajax = $ninja_forms_processing->get_form_setting('ajax');
	$form_id = $ninja_forms_processing->get_form_ID();
		
	if(!$ninja_forms_processing->get_all_errors()){
		do_action('ninja_forms_process');
		ninja_forms_post_process();
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
			//echo 'processing';
			//print_r($ninja_forms_processing->get_all_errors());		
		}
	}
}