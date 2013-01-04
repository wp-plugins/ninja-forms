<?php
add_action('init', 'ninja_forms_register_field_hr');

function ninja_forms_register_field_hr(){
	$args = array(
		'name' => 'hr',
		'sidebar' => 'layout_fields',		
		'edit_function' => '',
		'display_function' => 'ninja_forms_field_hr_display',
		'group' => '',	
		'display_label' => false,
		'display_wrap' => true,
		'edit_label' => false,
		'edit_label_pos' => false,
		'edit_req' => false,
		'edit_custom_class' => true,
		'edit_help' => false,
		'edit_meta' => false,
		'edit_conditional' => true,
		'process_field' => false,
	);
	
	ninja_forms_register_field('_hr', $args);
}

function ninja_forms_field_hr_edit($field_id, $data){

}

function ninja_forms_field_hr_display($field_id, $data){
	if(isset($data['show_field'])){
		$show_field = $data['show_field'];		
	}else{
		$show_field = true;
	}

	$field_class = ninja_forms_get_field_class($field_id);
	?>
	<hr class="<?php echo $field_class;?>" />
	<?php

}