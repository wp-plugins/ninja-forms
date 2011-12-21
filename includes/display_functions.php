<?php

add_filter( "the_content", "ninja_form_append", 1);
function ninja_form_append($content){
	global $wpdb;

	if(is_single() OR is_page()){
		$ninja_forms_table_name = $wpdb->prefix . "ninja_forms";
		$post_id = get_the_ID();	
		$ninja_all_forms = $wpdb->get_results( 
		$wpdb->prepare("SELECT * FROM $ninja_forms_table_name"), ARRAY_A);

		foreach($ninja_all_forms as $form){
			$form_id = $form['id'];
			$form_append = unserialize($form['append_page']);
			if($form_append){
				foreach($form_append as $append_id){
					if($post_id == $append_id){
						$form = ninja_return_echo('ninja_display_form_id', $form_id);
						$form = stripslashes($form);
						$content .= $form;
						add_filter("the_content", "pesky_br", 999);						
					}
				}
			}
		}
	}
	return $content;
}


function pesky_br($content){
	$br1 = htmlentities('<br>', ENT_QUOTES);
	$br2 = htmlentities('<br/>', ENT_QUOTES);
	$br3 = htmlentities('<br />', ENT_QUOTES);
	//Replacement for WordPress 3.3 wp_editor();
	
	$content = str_replace('class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a><br>', 'class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a>', $content);
	$content = str_replace('class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a><br/>', 'class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a>', $content);
	$content = str_replace('class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a><br />', 'class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a>', $content);
	$content = str_replace('class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a>'.$br1, 'class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a>', $content);
	$content = str_replace('class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a>'.$br2, 'class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a>', $content);
	$content = str_replace('class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a>'.$br3, 'class="hide-if-no-js wp-switch-editor switch-html" onclick="switchEditors.switchto(this);">HTML</a>', $content);
	
	//Replacement for pre-WordPress 3.3 $wp_editor class solution.
	$content = str_replace('class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a><br>', 'class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a>', $content);
	$content = str_replace('class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a><br/>', 'class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a>', $content);
	$content = str_replace('class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a><br />', 'class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a>', $content);
	$content = str_replace('class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a>'.$br1, 'class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a>', $content);
	$content = str_replace('class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a>'.$br2, 'class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a>', $content);
	$content = str_replace('class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a>'.$br3, 'class="hide-if-no-js wp-switch-editor" onclick="wpEditor.s(this);return false;">HTML</a>', $content);
	
	
	
	return $content;
}

function ninja_return_echo($function_name){
	$arguments = func_get_args();
    array_shift($arguments); // We need to remove the first arg ($function_name)
    ob_start();
    call_user_func_array($function_name, $arguments);
	$return = ob_get_clean();
	return $return;
}



function ninja_forms_shortcode($atts){
	$form = ninja_return_echo('ninja_display_form_id', $atts['id']);
	return $form;
}

function remove_bad_br_tags($content) {
	$content = str_ireplace("</label><br />", "</label>", $content);
	return $content;
}

add_shortcode('ninja_display_form', 'ninja_forms_shortcode');

function ninja_display_form_id($form_id){
	global $wpdb, $current_user, $wp_editor, $wp_version;
	get_currentuserinfo();
	$user_id = $current_user->ID;
	$user_firstname = $current_user->user_firstname;
	$user_lastname = $current_user->user_lastname;
	$user_email = $current_user->user_email;

	$ninja_forms_table_name = $wpdb->prefix . "ninja_forms";
	$ninja_forms_fields_table_name = $wpdb->prefix . "ninja_forms_fields";
	$plugin_settings = get_option("ninja_forms_settings");
	$help_color = $plugin_settings['help_color'];
	$help_size = $plugin_settings['help_size'];
	$upload_size = $plugin_settings['upload_size'] * 1000000;
	$ninja_forms_row = $wpdb->get_row( 
	$wpdb->prepare("SELECT * FROM $ninja_forms_table_name WHERE id = %d", $form_id)
	, ARRAY_A);
	$ajax_submit = $ninja_forms_row['ajax'];
	$landing_page = $ninja_forms_row['landing_page'];
	$ninja_forms_title = stripslashes($ninja_forms_row['title']);
	$ninja_forms_msg = stripslashes($ninja_forms_row['success_msg']);
	$ninja_forms_desc = stripslashes($ninja_forms_row['desc']);
	$ninja_forms_show_title = $ninja_forms_row['show_title'];
	$ninja_forms_show_desc = $ninja_forms_row['show_desc'];
	$multi = $ninja_forms_row['multi'];
	$ninja_post = $ninja_forms_row['post'];
	$post_options = unserialize($ninja_forms_row['post_options']);
	$multi_options = unserialize($ninja_forms_row['multi_options']);
	$save_status = $ninja_forms_row['save_status'];
	
	if(isset($multi_options['progress_bar'])){
		$progress_bar = $multi_options['progress_bar'];
	}else{
		$progress_bar = '';
	}
	if(isset($multi_options['show_steps'])){
		$show_steps = $multi_options['show_steps'];
	}else{
		$show_steps = '';
	}
	if(isset($multi_options['steps_label'])){
		$steps_label = $multi_options['steps_label'];
	}else{
		$steps_label = '';
	}
	$previous = $multi_options['previous'];
	$next = $multi_options['next'];
	if((($ninja_post == 'checked' && $post_options['login'] == 'checked') && $user_id) OR ($ninja_post == 'unchecked' OR $post_options['login'] == 'unchecked')){	
		if($ninja_forms_row){
			$ninja_forms_fields_sections = $wpdb->get_row( 
			$wpdb->prepare("SELECT * FROM $ninja_forms_fields_table_name WHERE type = 'divider' AND form_id = %d ORDER BY field_order ASC", $form_id)
			, ARRAY_A);
			if($ninja_forms_fields_sections){
				$first_section = $ninja_forms_fields_sections['label'];
			}
			$ninja_forms_fields = $wpdb->get_results( 
			$wpdb->prepare( "SELECT * FROM $ninja_forms_fields_table_name WHERE form_id = %d ORDER BY field_order ASC", $form_id)
			, ARRAY_A);

			echo "<span id='ninja_form_top'></span>";
			echo "<script language='javascript'>
				jQuery(document).ready(function($) {";
			foreach($ninja_forms_fields as $field){
				$extra = unserialize($field['extra']);
				$label = stripslashes($field['label']);
				$label = htmlspecialchars($label, ENT_QUOTES);
				$req = $field['req'];
				$divider = '';
				if(isset($extra['extra']['label_pos'])){
					$label_pos = $extra['extra']['label_pos'];
				}else{
					$label_pos = '';
				}
				if(isset($extra['extra']['mask'])){
					$mask = $extra['extra']['mask'];
				}else{
					$mask = '';
				}
				$id = $field['id'];
				if(isset($extra['extra']['datepicker'])){
					$datepicker = $extra['extra']['datepicker'];
				}else{
					$datepicker = '';
				}
				$type = $field['type'];
				if(isset($extra['extra']['show_help'])){
					$show_help = $extra['extra']['show_help'];
				}else{
					$show_help = '';
				}
				$help = $field['help'];
				if(isset($extra['extra']['create_cat'])){
					$create_cat = $extra['extra']['create_cat'];
				}else{
					$create_cat = '';
				}
				if($mask != 'none' && $mask != ''){
					if($mask == 'dollars'){
						echo '$("#ninja_field_'.$id.'").autoNumeric({aSign: "$"});';
					}else{
						echo '$("#ninja_field_'.$id.'").mask("'.$mask.'");';
					}
				}
				if($label_pos == 'inside' && $type != 'list' && $type != 'spam'){
					echo '$("#ninja_field_'.$id.'").val("'.$label.'");';
					echo '$("#ninja_field_'.$id.'").focus(function(){
						if($(this).val() == "'.$label.'"){
							$(this).removeClass("label-inside");
							$(this).val("");
						}
					});';
					echo '$("#ninja_field_'.$id.'").blur(function(){
						if($(this).val() == ""){
							$(this).addClass("label-inside");
							$(this).val("'.$label.'");
						}
					});';
				}
				if($label_pos == 'inside' && $type == 'spam'){
					echo '$("#ninja_field_spam").val("'.$label.'");';
					echo '$("#ninja_field_spam").focus(function(){
						if($(this).val() == "'.$label.'"){
							$(this).removeClass("label-inside");
							$(this).val("");
						}
					});';
					echo '$("#ninja_field_spam").blur(function(){
						if($(this).val() == ""){
							$(this).addClass("label-inside");
							$(this).val("'.$label.'");
						}
					});';
				
				}
				if($datepicker == 'checked'){
					echo '$("#ninja_field_'.$id.'").datepicker();';
				}
				if($show_help == 'checked'){
					echo '$("#ninja_field_'.$id.'_help").CreateBubblePopup();';
					echo '$("#ninja_field_'.$id.'_help").SetBubblePopupOptions({
											innerHtml: "'.$help.'",
											position: "right",
											align: "middle",
											tail: {
													align:"center",
													hidden: false
													},
													innerHtmlStyle: {
																"width": "'.$help_size.'px"
															},
											themeName: 	"'.$help_color.'",
											themePath: 	"'.NINJA_FORMS_URL.'/js/jquerybubblepopup-theme/",
											closingDelay: 200
									  });';
					$preload_help = 'yes';
				}else{
					$preload_help = 'no';
				}
			}
			echo "}); </script>";
			if($preload_help == 'yes'){
				echo '<div id="" class="" style="display:none;">
					<img src="'.NINJA_FORMS_URL.'/js/jquerybubblepopup-theme/'.$help_color.'/bottom-left.png">
					<img src="'.NINJA_FORMS_URL.'/js/jquerybubblepopup-theme/'.$help_color.'/bottom-middle.png">
					<img src="'.NINJA_FORMS_URL.'/js/jquerybubblepopup-theme/'.$help_color.'/bottom-right.png">
					<img src="'.NINJA_FORMS_URL.'/js/jquerybubblepopup-theme/'.$help_color.'/middle-left.png">
					<img src="'.NINJA_FORMS_URL.'/js/jquerybubblepopup-theme/'.$help_color.'/middle-right.png">
					<img src="'.NINJA_FORMS_URL.'/js/jquerybubblepopup-theme/'.$help_color.'/tail-bottom.png">
					<img src="'.NINJA_FORMS_URL.'/js/jquerybubblepopup-theme/'.$help_color.'/tail-left.png">
					<img src="'.NINJA_FORMS_URL.'/js/jquerybubblepopup-theme/'.$help_color.'/top-left.png">
					<img src="'.NINJA_FORMS_URL.'/js/jquerybubblepopup-theme/'.$help_color.'/top-middle.png">
					<img src="'.NINJA_FORMS_URL.'/js/jquerybubblepopup-theme/'.$help_color.'/top-right.png">
					<img src="'.NINJA_FORMS_URL.'/images/icons.png">
					</div>';
			}
		
			if($ninja_forms_msg == ''){
				$ninja_forms_msg = "Thank you for filling out this form!";
			}
			if($ninja_forms_row['subject'] == ''){
				$ninja_forms_subject = $ninja_forms_title;
			}else{
				$ninja_forms_subject = stripslashes($ninja_forms_row['subject']);
			}
			
			if($ninja_forms_show_title == 'checked'){
				echo "<h2 class='ninja-forms-title'>$ninja_forms_title</h2>";
			}
			if($ninja_forms_show_desc == 'checked'){
				echo "<p class='ninja-forms-desc'>$ninja_forms_desc</p>";
			}
			echo "<div id='ninja_form'><p class='req-item-desc'>Items marked with \"<span class='required-item'>*</span>\" are required.</p>";
			
			$multi_count = '';
			if($multi == 'checked'){
				$multi_count = 0;
				foreach($ninja_forms_fields as $field){
					$type = $field['type'];
					if($type == 'divider'){
						$multi_count++;
					}
				}
				$current_page = 1;
				$header_only = 'yes';
			}
		
			echo "<form name='ninja_form_$form_id' id='ninja_form_$form_id' action='' method='post'>
			<input type='hidden' name='ninja_form_id' id='ninja_form_id' value='$form_id'>
			<input type='hidden' name='action' value='ninja_form_process'>
			<input type='hidden' name='ninja_ajax_submit' id='ninja_ajax_submit' value='$ajax_submit'>
			<input type='hidden' id='ninja_multi_form' value='$multi'>
			<input type='hidden' id='ninja_multi_count' value='$multi_count'>
			<input type='hidden' id='ninja_save_status' name='ninja_save_status' value=''>
			<input type='hidden' id='ninja_form_save_email' name='ninja_form_save_email' value=''>
			<input type='hidden' id='ninja_form_save_password' name='ninja_form_save_password' value=''>
			<input type='hidden' id='ninja_form_continue' name='ninja_form_continue' value=''>
			";
			
			if($user_id){
				echo "<input type='hidden' id='ninja_user_id' name='ninja_user_id' value='$user_id'>";
			}
			if($save_status == 'checked'){
				if($user_id){
					echo "<p><div><a href='#' id='ninja_login_button'>Click here to resume filling out a saved form</a></div></p>";
				}else{
					echo "<p><div><a href='#' id='ninja_show_continue_login'>Click here to resume filling out a saved form</a></div></p>";
				}
			}
			foreach($ninja_forms_fields as $field){
				$id = $field['id'];
				$label = stripslashes($field['label']);
				$label = htmlspecialchars($label, ENT_QUOTES);
				$type = $field['type'];
				$value =stripslashes($field['value']);
				if($value == 'none'){
					$value = '';
				}
				$req = $field['req'];
				$extra = unserialize($field['extra']);
				if(isset($extra['extra']['email_confirm'])){
					$email_confirm = $extra['extra']['email_confirm'];
				}else{
					$email_confirm = '';
				}
				if(isset($extra['extra']['mask'])){
					$mask = $extra['extra']['mask'];
				}else{
					$mask = '';
				}
				if(isset($extra['extra']['show_help'])){
					$show_help = $extra['extra']['show_help'];
				}else{
					$show_help = '';
				}
				$classes = $field['class'];
				if(isset($extra['extra']['label_pos'])){
					$label_pos = $extra['extra']['label_pos'];
				}else{
					$label_pos = '';
				}

				if($label_pos == ''){
					$label_pos = 'left';
				}

				if(isset($extra['extra']['list_type'])){
					$list_type = $extra['extra']['list_type'];
				}else{
					$list_type = '';
				}
				$label_class = '';
				$field_class = '';
				$wrap_class = '';
				
				if($classes != 'Comma,Separated,List' && $classes != ''){
					$classes_array = explode(',' , $classes);
					foreach($classes_array as $class){
						$label_class .= "$class-label ";
						$field_class .= "$class-field ";
						$wrap_class .= "$class-wrap ";
					}
				}
				if(isset($extra['extra']['media_upload'])){
					$media_upload = $extra['extra']['media_upload'];
				}else{
					$media_upload = '';
				}
				$classes = "";
				if(isset($extra['extra']['rte'])){
					$rte = $extra['extra']['rte'];
				}else{
					$rte = '';
				}
				if($rte == 'checked'){
					$classes .= ' ninja-rte';
				}
				if(isset($extra['extra']['email'])){
					$email = $extra['extra']['email'];
				}else{
					$email = '';
				}
				if($email){
					$classes .= ' email ';
				}
				if($req == 1){
					$req = 'ninja_req';
					$classes .= ' ninja_req'; 
				}
				
				if($type == 'spam'){
					//$label = "Anti-Spam Question: ".$label;
					$label_class .= " text-label";
				}
				if($type == 'textbox'){
					$label_class .= " text-label";
				}
				if($type == 'checkbox'){
					$label_class .= " checkbox-label";
				}
				if($type == 'textarea'){
					$label_class .= " text-label";
				}
				$class_type = $type;
				if($list_type != ''){
					$class_type = $list_type;
				}else{
					$class_type = $type;
				}
				if($type != 'divider'){
					echo "<div class='span-$class_type-label-$label_pos field-group $wrap_class'>"; // Label and Element Surrounding DIV
				}
				if($type != 'heading' && $type != 'hr' && $type != 'desc' && $type != 'submit' && $type != 'hidden' && $type != 'divider' && $type != 'progressbar' && $type != 'steps' ){
					if(($type != 'posttitle' && $type != 'postcontent' && $type != 'postexcerpt' && $type != 'postcat' && $type != 'posttags') OR ($ninja_post == 'checked')){
						if($label_pos == 'left' OR $label_pos == 'above'){
							echo "<label class='$label_class label-$label_pos' for='ninja_field_$id'>$label";
							if($req == 'ninja_req' ){
								echo "<span class='required-item'>*</span>";
							}
							echo "</label>";
							if($show_help == 'checked' && $label_pos == 'above'){
								echo " <img id='ninja_field_".$id."_help' src='".NINJA_FORMS_URL."/images/question-ico.gif'>";
							}	
						}elseif($label_pos == 'inside'){
							$value = $label;
							$classes .= " label-inside";
						}
					}
				}
				switch($type){
					case 'textbox':
						if($value == 'ninja_user_firstname'){
							if($user_firstname){
								$value = $user_firstname;
							}else{
								$value = "";
							}
						}elseif($value == 'ninja_user_lastname'){
							if($user_lastname){
								$value = $user_lastname;
							}else{
								$value = "";
							}
						}elseif($value == 'ninja_user_email'){
							if($user_email){
								$value = $user_email;
							}else{
								$value = "";
							}					
						}

						echo "<input type='text' id='ninja_field_$id' name='ninja_field_$id' value='$value' class='ninja-text-box $type $classes $field_class' title='$label'>";
						break;
					case 'list':
						$list_type = $extra['extra']['list_type'];
						$options_array = $extra['extra']['list_item'];
						if($list_type != 'radio'){
							echo "<select ";
							if($list_type == 'multi'){
								echo "multiple='multiple' size=5";
								echo " name='ninja_field_".$id."[]'";
							}else{
								echo "name='ninja_field_$id";
							}
							echo  " id='ninja_field_$id' class='ninja-select-box $classes $field_class'>";
		
							if($label_pos == 'inside'){
								echo "<option value='' selected>$label</option>";
							}
							if($options_array){
								foreach($options_array as $option){
									$option = stripslashes($option);
									$option = htmlspecialchars($option, ENT_QUOTES); 
									echo "<option value='$option'";
									if($extra['extra']['list_default'] == $option && $label_pos != 'inside'){
										echo 'selected';
									}
									echo " >$option</option>";
								}
								echo "</select>";
							}
							}else{
								if($options_array){
									foreach($options_array as $option){
										$option = stripslashes($option);
										$option = htmlspecialchars($option, ENT_QUOTES); 
										echo "<input type='radio' name='ninja_field_$id' id='ninja_field_$id' value='$option'><label for='ninja_field_$id' class='radio-label'>$option</label>";
									}
								}
							}
						break;
					case 'checkbox':
						if($value == 'checked'){
							$checked = 'checked';
						}else{
							$checked = '';
						}
						echo "<input type='hidden' value='unchecked'  name='ninja_field_$id' $checked>";
						echo "<input type='checkbox' value='checked'  id='ninja_field_$id'  name='ninja_field_$id' $checked class='ninja-check-box $classes $field_class'>";
						break;
					case 'textarea':
						if($rte == 'checked'){
							if($media_upload == 'checked'){
								$media_upload = true;
							}else{
								$media_upload = false;
							}
							if(version_compare( $wp_version, '3.3-beta3-19254' , '<')){
								echo $wp_editor->editor($value, "ninja_field_$id", array('media_buttons_context' => '<span>Insert a media file: </span>', 'upload_link_title' => 'Media Uploader - NinjaForms'), $media_upload);
							}else{
								$args = array("media_buttons" => $media_upload);
								wp_editor($value, "ninja_field_$id", $args);
							}
						}else{
							echo "<textarea  id='ninja_field_$id' name='ninja_field_$id' class='ninja-textarea $classes $field_class'  title='$label'>$value</textarea>";
						}
						break;	
					case 'hr':
						echo "<hr class='ninja_form_hr $classes $field_class'>";
						break;
					case 'heading':
						echo "<$value class='ninja_form_heading $classes $field_class'>$label</$value>";
						break;
					case 'spam':
						echo "<input type='text' id='ninja_field_spam' name='ninja_field_spam' class='ninja-text-box $classes $field_class'  title='$label'";
						if($label_pos == 'inside'){
							echo "value='$value'";
						}
						echo ">";
						break;
					case 'desc':
						echo "<p class='ninja-form-desc $classes $field_class'>$value</p>";
						break;
					case 'submit':
						echo "<input id='ninja_submit' name='ninja_submit' type='submit' value ='$label' class='$classes $field_class'>";
						break;
					case 'hidden':
						if($value == 'ninja_user_ID'){
							if($user_id){
								$value = $user_id;
							}else{
								$value = "User Not Logged In";
							}
						}
						echo "<input type='hidden' name='ninja_field_$id' value='$value'>";
						break;
					case 'divider':
						if($multi == 'checked'){
							$divider = 'yes';

							if($header_only == 'yes'){
								echo "<div id='ninja_multi_page_$current_page'>";
								echo "<input type='hidden' id='ninja_multi_name_$current_page' style='display:none;' value='$label'>";
								$header_only = 'no';
							}else{
								echo "<div class='ninja-controls'>";						
								if($current_page != 1){
									echo "<input type='button' id='ninja_page_$current_page' class='ninja_multi_form_previous' value='$previous'> ";
								}
								if($current_page != $multi_count){
									echo "<input type='button' id='ninja_page_$current_page' class='ninja_multi_form_next' value='$next'>";						
								}
								echo"</div>";
								echo"</div>";
								$current_page++;	
								echo "<div id='ninja_multi_page_$current_page' style='display:none;'>";
								echo "<input type='hidden' id='ninja_multi_name_$current_page' style='display:none;' value='$label'>";
							}
						}
						break;
					case 'progressbar':
						if($multi == 'checked'){
							echo "<input type='hidden' id='ninja_multi_progress' value='checked'>";
							echo "<div id='progressbar'></div>";
						}
					break;
					
					case 'steps':
						if($multi == 'checked'){
							echo "<p class = 'ninja_progress'>$label <span id='ninja_multi_step'>1</span> of $multi_count - <span id='ninja_multi_name'>$first_section</span></p>";
						}
					break;
					
					case 'posttitle':
						if($ninja_post == 'checked'){
							echo "<input type='text' id='ninja_field_$id' name='ninja_field_$id' value='$value' class='ninja-text-box $type $classes $field_class' title='$label'>";
						}
					break;				
					
					case 'postcontent':
						if($ninja_post == 'checked'){
							if($rte == 'checked'){
								if($media_upload == 'checked'){
									$media_upload = true;
								}else{
									$media_upload = false;
								}
								if(version_compare( $wp_version, '3.3-beta3-19254' , '<')){
									echo $wp_editor->editor($value, "ninja_field_$id", array('media_buttons_context' => '<span>Insert a media file: </span>', 'upload_link_title' => 'Media Uploader - NinjaForms'), $media_upload);
								}else{
									$args = array("media_buttons" => $media_upload);
									echo wp_editor($value, "ninja_field_$id");
								}
							}else{
								echo "<textarea name='ninja_field_$id' id='ninja_field_$id' class='ninja-textarea $classes $field_class ninja_rich_text'>$value</textarea>";
							}
						}
					break;				
					
					case 'postexcerpt':
						if($ninja_post == 'checked'){
							echo "<textarea name='ninja_field_$id' id='ninja_field_$id' class='ninja-textarea $classes $field_class'></textarea>";
						}
					break;				
					
					case 'postcat':
						if($ninja_post == 'checked'){
							$create_cat = $extra['extra']['create_cat'];
							$dropdown = wp_dropdown_categories(array('hide_empty' => 0, 'name' => "ninja_field_". $id."[]", 'id' => "ninja_field_$id", 'hierarchical' => true, 'echo' => false, 'orderby' => 'name'));
							$dropdown = str_replace("id='ninja_field_".$id."'", "id='ninja_field_".$id."' multiple='multiple'", $dropdown);
							echo $dropdown;
							
							//echo "CREATE CAT $create_cat";
							if($create_cat == 'checked'){
								echo "<p><label class='text-label label-left $label_class' for='ninja_create_cat'>And/Or, Create New</label> <input type='text' name='ninja_create_cat' id='ninja_create_cat'>";
								if($label_pos != "right"){
									echo "<label class='ninja-inst' for='ninja_create_cat'>Comma, Separated, List</label>";
								}
								echo "</p>";
								
							}
						}
					break;				
					
					case 'posttags':
						if($ninja_post == 'checked'){
							echo "<input type='text' name='ninja_field_$id' id='ninja_field_$id' class='ninja-text-box $type $classes $field_class' title='$label'>";
							if($label_pos != "right"){
								echo "<label class='ninja-inst' for='ninja_field_$id'>Comma, Separated, List</label>";
							}
						}
					break;
					
					case 'file':
						echo "<input type='hidden' name='MAX_FILE_SIZE' value='$upload_size'/>";
						echo "<input type='file' name='ninja_field_$id' id='ninja_field_$id' class='ninja-text-box $type $classes $field_class'>";
						echo "<input type='hidden' name='ninja_field_$id' value='file'>";						
					break;
				} // End $type Switch Case
				
				if($label_pos == 'right'){
					echo "<label class='$label_class' for='ninja_field_$id'>$label";
					if($req == 'ninja_req' ){
						echo "<span class='required-item'>*</span>";
					}
					echo "</label>";
					if($type == 'postcat' OR $type == 'posttags'){
						echo "<label class='ninja-inst' for='ninja_create_cat'>Comma, Separated, List</label>";
					}
					if($show_help == 'checked'){
						echo " <img id='ninja_field_".$id."_help' src='".NINJA_FORMS_URL."/images/question-ico.gif'> ";
					}	
				}elseif($label_pos == 'inside'){
					if($req == 'ninja_req' ){
						echo "<span class='required-item'>*</span>";
					}
					if($show_help == 'checked'){
						echo " <img id='ninja_field_".$id."_help' src='".NINJA_FORMS_URL."/images/question-ico.gif'> ";
					}	
				}
				if($label_pos == 'left' && $show_help == 'checked'){
					echo " <img id='ninja_field_".$id."_help' src='".NINJA_FORMS_URL."/images/question-ico.gif'> ";
				}
				if($type != 'divider'){
					echo "</div>";	 // Label and Element surrounding DIV
				}
			} // End Fields FOR EACH

			if($multi == 'checked'){
				echo"<div id='ninja-controls'>";
				if($current_page != 1){
					echo "<input type='button' id='ninja_page_$current_page' class='ninja_multi_form_previous' value='$previous'> ";
				}
				if($current_page != $multi_count){
					echo "<input type='button' id='ninja_page_$current_page' class='ninja_multi_form_next' value='$next'> ";						
				}
				echo"</div>";
				if($divider == 'yes'){
					echo"</div>";
				}
			}
			if($save_status == 'checked'){
				echo "<input id='ninja_save_progress' name='ninja_save_progress' type='button' value='Save Progress'>";
			}			
			//echo "</div>";
			echo "<div id='ninja_form_overlay' title='Processing Form Submission'>Processing Submission<br /><a href='#' class='ninja_close_dialog'>Close</a></div></form></div>";
			if($save_status == 'checked'){
				echo "<div id='ninja_form_save_progress' title='Save Your Progress'>
				<p>Email Address: <input type='text' id='ninja_save_email' name='ninja_save_email' value=''></p>
				<p>Password: <input type='password' id='ninja_save_password1' name='ninja_save_password1' value=''></p>
				<p>Re-enter Password: <input type='password' id='ninja_save_password2' name='ninja_save_password2' value=''></p>
				<p><input type='button' name='' id='ninja_popup_save' value='Save Progress'> <input type='button' name='' id='ninja_cancel_save' value='Cancel'></p>
				
				<div id='ninja_form_continue_login' title='Continue Saved Form'>
				<p>Email Address: <input type='text' name='' id='ninja_login_email'></p>
				<p>Password: <input type='password' name='' id='ninja_login_password'></p>
				<p><a href='#' id='ninja_email_pass'>Forgot Password</a></p>
				<p><input type='button' name='' id='ninja_login_button' value='Retrieve Saved Form'> <input type='button' name='' id='ninja_cancel_login' value='Cancel'></p>
				</div>
				
				<div id='ninja_forgot_pass' title='Retrieve Forgotten Password'>
				<p>Please enter your email address. Your password will be sent to this address.</p>
				<p>Email Address: <input type='text' name='' id='ninja_forgot_email'></p>
				<p><input type='button' name='' id='ninja_forgot_button' value='Retrieve Password'></p>
				</div>
				
				";
				
				
			}
			}
			add_filter('the_content', 'remove_bad_br_tags', 99);
			return trim($output);
		}
}