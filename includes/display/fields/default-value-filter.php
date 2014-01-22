<?php

/*
 *
 * Function that filters default values, replacing defined strings with the approparite values.
 *
 * @since 2.4
 * @return $data
 */

function ninja_forms_default_value_filter( $data, $field_id ) {
	global $ninja_forms_loading, $ninja_forms_processing;

	if ( isset ( $ninja_forms_loading ) ) {
		$default_value = $ninja_forms_loading->get_field_value( $field_id );
	} else {
		$default_value = $ninja_forms_processing->get_field_value( $field_id );
	}

	$data['default_value'] = $default_value;

	return $data;
}

add_filter( 'ninja_forms_field', 'ninja_forms_default_value_filter', 7, 2 );