<?php

add_shortcode( 'ninja_forms_display_form', 'ninja_forms_shortcode' );
function ninja_forms_shortcode( $atts ){
	$form = ninja_forms_return_echo( 'ninja_forms_display_form', $atts['id'] );
	return $form;
}

add_shortcode( 'ninja_forms_field', 'ninja_forms_field_shortcode' );
function ninja_forms_field_shortcode( $atts ){
	global $ninja_forms_processing;
	$field_id = $atts['id'];
	$value = $ninja_forms_processing->get_field_value( $field_id );
	$value = apply_filters( 'ninja_forms_field_shortcode', $value, $atts );
	return $value;
}