<?php
add_action('init', 'ninja_forms_register_filter_msgs');
function ninja_forms_register_filter_msgs(){
	add_action( 'ninja_forms_pre_process', 'ninja_forms_filter_msgs', 20 );	
}

function ninja_forms_filter_msgs(){
	global $ninja_forms_processing;

	//Get the form settings for the form currently being processed.
	$admin_subject = $ninja_forms_processing->get_form_setting('admin_subject');
	$user_subject = $ninja_forms_processing->get_form_setting('user_subject');
	$success_msg = $ninja_forms_processing->get_form_setting('success_msg');
	$admin_email = $ninja_forms_processing->get_form_setting('admin_email_msg');
	$email_msg = $ninja_forms_processing->get_form_setting('user_email_msg');
	$save_msg = $ninja_forms_processing->get_form_setting('save_msg');

	//Loop through each submitted form field and replace any instances of [label] within Success Message, Admin email message, and user email message with the value.
	if($ninja_forms_processing->get_all_fields()){
		foreach($ninja_forms_processing->get_all_fields() as $key => $val){
			$field_row = ninja_forms_get_field_by_id($key);
			$data = $field_row['data'];
			$label = $data['label'];

			$user_value = '';
			if(is_array($val) AND !empty($val)){
				$x = 0;
				foreach($val as $v){
					if(!is_array($v)){
						$user_value .= $v;
						if($x != count($val)){
							$user_value .= ',';
						}
					}
					$x++;
				}
			}else{
				$user_value = $val;
			}
			$success_msg = str_replace('['.$label.']', $user_value, $success_msg);
			$admin_email = str_replace('['.$label.']', $user_value, $admin_email);
			$email_msg = str_replace('['.$label.']', $user_value, $email_msg);
			$save_msg = str_replace('['.$label.']', $user_value, $save_msg);
			$admin_subject = str_replace('['.$label.']', $user_value, $admin_subject);
			$user_subject = str_replace('['.$label.']', $user_value, $user_subject);


		}
	}

	//Call any functions which may be attached to the filter for our message fields
	$ninja_forms_processing->update_form_setting('admin_subject', apply_filters('ninja_forms_admin_subject', $admin_subject));
	$ninja_forms_processing->update_form_setting('user_subject', apply_filters('ninja_forms_user_subject', $user_subject));
	$ninja_forms_processing->update_form_setting('success_msg', apply_filters('ninja_forms_success_msg', $success_msg));
	$ninja_forms_processing->update_form_setting('admin_email_msg', apply_filters('ninja_forms_admin_email', $admin_email));
	$ninja_forms_processing->update_form_setting('user_email_msg', apply_filters('ninja_forms_user_email', $email_msg));
	$ninja_forms_processing->update_form_setting('save_msg', apply_filters('ninja_forms_save_msg', $save_msg));
}