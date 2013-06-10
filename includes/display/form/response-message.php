<?php
/**
 * Outputs the HTML for displaying success messages or error messages set to display at location 'general'
 *
**/
add_action( 'init', 'ninja_forms_register_before_form_wrap' );
function ninja_forms_register_before_form_wrap(){
	add_action( 'ninja_forms_display_before_form', 'ninja_forms_display_response_message', 10 );
}

function ninja_forms_display_response_message( $form_id ){
	global $ninja_forms_processing;

	$plugin_settings = get_option( 'ninja_forms_settings' );
	$form_row = ninja_forms_get_form_by_id($form_id);
	if( isset( $form_row['data']['ajax'] ) ){
		$ajax = $form_row['data']['ajax'];
	}else{
		$ajax = 0;
	}
	if( $ajax == 0 AND ( is_object( $ninja_forms_processing ) AND !$ninja_forms_processing->get_all_errors() AND !$ninja_forms_processing->get_all_success_msgs() ) ){
		$display = 'display:none;';
	}else{
		$display = '';
	}

	if( is_object( $ninja_forms_processing ) ){
		if( $ninja_forms_processing->get_errors_by_location('general') ){
			$class = 'ninja-forms-error-msg';
		}else if( $ninja_forms_processing->get_all_success_msgs() ){
			$class = 'ninja-forms-success-msg';
		}else{
			$class = '';
		}
	}else{
		$class = '';
	}
	echo '<div id="ninja_forms_form_' . $form_id . '_response_msg" style="' . $display . '" class="ninja-forms-response-msg '.$class.'">';
	if( is_object( $ninja_forms_processing ) ){
		if( $ninja_forms_processing->get_form_ID() == $form_id ){
			if( $ninja_forms_processing->get_errors_by_location('general') ){
				foreach($ninja_forms_processing->get_errors_by_location('general') as $error){
					echo $error['msg'];
				}
			}


			if( $ninja_forms_processing->get_all_success_msgs()){
				foreach($ninja_forms_processing->get_all_success_msgs() as $success){
					echo $success;
				}
			}
		}
	}
	echo '</div>';
}