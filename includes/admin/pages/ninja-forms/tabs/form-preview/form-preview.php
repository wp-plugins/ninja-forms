<?php

add_action('init', 'ninja_forms_register_tab_form_preview', 1001);

function ninja_forms_register_tab_form_preview(){
	if(isset($_REQUEST['form_id'])){
		$form_id = $_REQUEST['form_id'];
	}else{
		$form_id = '';
	}

	$args = array(
		'name' => 'Form Preview',
		'page' => 'ninja-forms',
		'display_function' => '',
		'save_function' => '',
		'disable_no_form_id' => true,
		'show_save' => false,
		'url' => ninja_forms_preview_link( $form_id, false ),
		'target' => '_blank',
	);
	ninja_forms_register_tab( 'form_preview', $args );
}