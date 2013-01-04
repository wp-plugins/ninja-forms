<?php
add_action('init', 'ninja_forms_register_email_admin');
function ninja_forms_register_email_admin(){
	add_action('ninja_forms_process', 'ninja_forms_email_admin', 999);	
}

function ninja_forms_email_admin(){
	global $ninja_forms_processing;

	do_action( 'ninja_forms_email_admin' );

	$form_ID = $ninja_forms_processing->get_form_ID();
	$form_title = $ninja_forms_processing->get_form_setting('form_title');
	$admin_mailto = $ninja_forms_processing->get_form_setting('admin_mailto');
	$email_from = $ninja_forms_processing->get_form_setting('email_from');
	$email_type = $ninja_forms_processing->get_form_setting('email_type');
	$subject = $ninja_forms_processing->get_form_setting('admin_subject');
	$message = $ninja_forms_processing->get_form_setting('admin_email_msg');

	if(!$subject){
		$subject = $form_title;
	}
	if(!$message){
		$message = __('Thank you for filling out this form.', 'ninja-forms');
	}
	if(!$email_from){
		$email_from = '';
	}
	if(!$email_type){
		$email_type = '';
	}
	

	//$message = apply_filters('ninja_forms_admin_email', $message);

	$email_from = htmlspecialchars_decode($email_from);
	$email_from = htmlspecialchars_decode($email_from);

	$headers = "\nMIME-Version: 1.0\n";
	$headers .= "From: $email_from \r\n";
	$headers .= "Content-Type: text/".$email_type."; charset=utf-8\r\n";

	if($ninja_forms_processing->get_form_setting('admin_attachments')){		
		$attachments = $ninja_forms_processing->get_form_setting('admin_attachments');
	}else{
		$attachments = '';
	}

	if(is_array($admin_mailto) AND !empty($admin_mailto)){
		wp_mail($admin_mailto, $subject, $message, $headers, $attachments);
	}
}