<?php


class NF_Update_Email_Settings extends NF_Step_Processing {

	function __construct() {
		$this->action = 'update_email_settings';

		parent::__construct();
	}

	public function loading() {
		global $wpdb;

		// Get our total number of forms.
		$form_count = nf_get_form_count();

		// Get all our forms
		$forms = ninja_forms_get_all_forms( true );

		$x = 1;
		if ( is_array( $forms ) ) {
			foreach ( $forms as $form ) {
				$this->args['forms'][$x] = $form['id'];
				$x++;
			}
		}

		if( empty( $this->total_steps ) || $this->total_steps <= 1 ) {
			$this->total_steps = $form_count;
		}

		$args = array(
			'total_steps' 	=> $this->total_steps,
			'step' 			=> 1,
		);

		$this->redirect = admin_url( 'admin.php?page=ninja-forms' );

		return $args;
	}

	public function step() {
		global $ninja_forms_fields;

		// Get our form ID
		$form_id = $this->args['forms'][ $this->step ];

		$fields = Ninja_Forms()->form( $form_id )->fields;

		// Create a notification for our user email
		if ( ! empty ( $fields ) ) {
			foreach ( $fields as $field_id => $field ) {
				if ( isset ( $field['data']['send_email'] ) && $field['data']['send_email'] == 1 ) {
					// Add this field to our $addresses variable.
					unset( $field['data']['send_email'] );
					unset( $field['data']['replyto_email'] );
					unset( $field['data']['from_name'] );

					$args = array(
						'update_array'	=> array(
							'data'		=> serialize( $field['data'] ),
						),
						'where'			=> array(
							'id' 		=> $field_id,
						),
					);

					ninja_forms_update_field( $args );
				}
			}
		}

	}

	public function complete() {
		update_option( 'nf_update_email_settings_complete', true );
	}
}