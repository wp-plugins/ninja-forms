<?php
add_action( 'ninja_forms_display_js', 'ninja_forms_display_js', 10, 2 );
function ninja_forms_display_js($form_id, $local_vars = ''){
	global $post, $ninja_forms_display_localize_js;

	//if(!is_admin()){
	/*
		if( $form_id != '' AND (isset($_REQUEST['preview']) AND $_REQUEST['preview'] == 'true' ) OR ( is_admin() ) ){
			$form_ids = array($form_id);
		}else{
			$page_id = $post->ID;
			$form_ids = ninja_forms_get_form_ids_by_post_id($page_id);
		}

		if(is_array($form_ids) AND !empty($form_ids)){
	*/
			$form_row = ninja_forms_get_form_by_id($form_id);
			if( isset( $form_row['data']['ajax'] ) ){
				$ajax = $form_row['data']['ajax'];
			}else{
				$ajax = 0;
			}

			if( isset( $form_row['data']['hide_complete'] ) ){
				$hide_complete = $form_row['data']['hide_complete'];
			}else{
				$hide_complete = 0;
			}
			
			if( isset( $form_row['data']['clear_complete'] ) ){
				$clear_complete = $form_row['data']['clear_complete'];
			}else{
				$clear_complete = 0;
			}

			$ninja_forms_js_form_settings['ajax'] = $ajax;
			$ninja_forms_js_form_settings['hide_complete'] = $hide_complete;
			$ninja_forms_js_form_settings['clear_complete'] = $clear_complete;

			//if(count($ninja_forms_js_form_settings) == count($form_ids)){

				$plugin_settings = get_option("ninja_forms_settings");
				if(isset($plugin_settings['date_format'])){
					$date_format = $plugin_settings['date_format'];
				}else{
					$date_format = 'm/d/Y';
				}

				$date_format = ninja_forms_date_to_datepicker($date_format);
				$currency_symbol = $plugin_settings['currency_symbol'];

				$password_mismatch = esc_html(stripslashes($plugin_settings['password_mismatch']));
				$msg_format = $plugin_settings['msg_format'];
				wp_enqueue_script( 'jquery-maskedinput',
					NINJA_FORMS_URL .'/js/min/jquery.maskedinput.min.js',
					array( 'jquery' ) );

				wp_enqueue_script('jquery-autonumeric',
					NINJA_FORMS_URL .'/js/min/autoNumeric.min.js',
					array( 'jquery' ) );

				wp_enqueue_script( 'jquery-qtip',
					NINJA_FORMS_URL .'/js/min/jquery.qtip.min.js',
					array( 'jquery', 'jquery-ui-position' ) );

				wp_enqueue_script( 'ninja-forms-display',
				NINJA_FORMS_URL .'/js/min/ninja-forms-display.min.js',
				array( 'jquery', 'jquery-ui-dialog', 'jquery-ui-datepicker', 'jquery-form' ) );

				if( !isset( $ninja_forms_display_localize_js ) OR !$ninja_forms_display_localize_js ){
					wp_localize_script( 'ninja-forms-display', 'ninja_forms_settings', array('ajax_msg_format' => $msg_format, 'password_mismatch' => $password_mismatch, 'plugin_url' => NINJA_FORMS_URL, 'date_format' => $date_format, 'currency_symbol' => $currency_symbol ) );
					$ninja_forms_display_localize_js = true;
				}

				wp_localize_script( 'ninja-forms-display', 'ninja_forms_form_'.$form_id.'_settings', $ninja_forms_js_form_settings );
				
				wp_localize_script( 'ninja-forms-display', 'ninja_forms_password_strength', array(
					'empty' => __('Strength indicator'),
					'short' => __('Very weak'),
					'bad' => __('Weak'),
					/* translators: password strength */
					'good' => _x('Medium', 'password strength'),
					'strong' => __('Strong'),
					'mismatch' => __('Mismatch')
					) );
			//}
		//}
	//}
}

add_action( 'ninja_forms_display_css', 'ninja_forms_display_css', 10, 2 );
function ninja_forms_display_css(){
	wp_enqueue_style( 'ninja-forms-display', NINJA_FORMS_URL .'/css/ninja-forms-display.css' );
	wp_enqueue_style( 'jquery-qtip', NINJA_FORMS_URL .'/css/qtip.css' );
}