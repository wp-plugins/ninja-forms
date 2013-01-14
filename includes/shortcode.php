<?php

add_shortcode('ninja_forms_display_form', 'ninja_forms_shortcode');
function ninja_forms_shortcode($atts){
	$form = ninja_forms_return_echo('ninja_forms_display_form', $atts['id']);
	return $form;
}