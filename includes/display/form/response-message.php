<?php
/**
 * Outputs the HTML for displaying success messages or error messages set to display at location 'general'
 *
**/
add_action( 'init', 'ninja_forms_register_before_form_wrap' );
function ninja_forms_register_before_form_wrap(){
	add_action( 'ninja_forms_display_before_form_wrap', 'ninja_forms_display_response_message' );
}

function ninja_forms_display_response_message($form_id){
	global $ninja_forms_processing;
	$plugin_settings = get_option( 'ninja_forms_settings' );
	$form_row = ninja_forms_get_form_by_id($form_id);
if( isset( $form_row['data']['ajax'] ) ){
		$ajax = $form_row['data']['ajax'];
	}else{
		$ajax = 0;
	}
	if($ajax == 0 AND (isset($ninja_forms_processing) AND !$ninja_forms_processing->get_all_errors() AND !$ninja_forms_processing->get_all_success_msgs())){
		$display = 'display:none;';
	}else{
		$display = '';
	}
	?>
	<div id="ninja_forms_form_<?php echo $form_id;?>_response_msg" style="<?php echo $display;?>" class="">
	<?php
		if(isset($ninja_forms_processing) AND $ninja_forms_processing->get_errors_by_location('general')){
			foreach($ninja_forms_processing->get_errors_by_location('general') as $error){
				echo '<p>'.$error['msg'].'</p>';
			}
		}
		if(isset($ninja_forms_processing) AND $ninja_forms_processing->get_all_success_msgs()){
			foreach($ninja_forms_processing->get_all_success_msgs() as $success){
				echo $success;
			}
		}
		?>
	</div>
	<?php
}