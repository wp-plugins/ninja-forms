<?php
if(isset($_REQUEST['download_subs'])){
	add_action('admin_init', 'ninja_forms_download_subs');
}
function ninja_forms_download_subs(){
	global $wpdb;

	require_once (NINJA_FORMS_DIR."/includes/xls.class.php");
	if(current_user_can('administrator')){

		if(isset($_REQUEST['show_incomplete'])){
			if($_REQUEST['show_incomplete'] == 1){
				$sub_status = '';
			}else{
				$sub_status = " AND sub_status = 'complete' ";
			}
		}else{
			$sub_status = " AND sub_status = 'complete' ";			
		}

		if(isset($_REQUEST['begin_date'])){
			$begin_date = esc_html($_REQUEST['begin_date']);
		}else{
			$begin_date = '';
		}
		if(isset($_REQUEST['end_date'])){
			$end_date = esc_html($_REQUEST['end_date']);
		}else{
			$end_date = '';
		}
		$form_id = esc_html($_REQUEST['form_id']);
		if($begin_date != ''){
			$begin_date = date("Y-m-d G:i:s", strtotime($begin_date));
		}
		if($end_date != ''){
			$end_date .= " 23:59:59";
			$end_date = date("Y-m-d G:i:s", strtotime($end_date));
		}

		$ninja_forms_subs_table_name = $wpdb->prefix . "ninja_forms_subs";
		$ninja_forms_table_name = $wpdb->prefix . "ninja_forms";
		$ninja_forms_fields_table_name = $wpdb->prefix . "ninja_forms_fields";

		if($begin_date != '' && $end_date != ''){
			$ninja_forms_subs_rows = $wpdb->get_results( 
			$wpdb->prepare( "SELECT * FROM $ninja_forms_subs_table_name WHERE form_id = %d $sub_status AND (date_updated BETWEEN %s AND %s) ORDER BY id DESC", $form_id, $begin_date, $end_date)
			, ARRAY_A);
		}elseif($begin_date != '' && $end_date == ''){
			$ninja_forms_subs_rows = $wpdb->get_results( 
			$wpdb->prepare( "SELECT * FROM $ninja_forms_subs_table_name WHERE form_id = %d $sub_status AND date_updated >= %s ORDER BY id DESC", $form_id, $begin_date)
			, ARRAY_A);
		}elseif($begin_date == '' && $end_date != ''){
			$ninja_forms_subs_rows = $wpdb->get_results( 
			$wpdb->prepare( "SELECT * FROM $ninja_forms_subs_table_name WHERE form_id =%d $sub_status AND date_updated <= %s ORDER BY id DESC", $form_id, $end_date)
			, ARRAY_A);
		}elseif($begin_date == '' && $end_date == ''){
			$ninja_forms_subs_rows = $wpdb->get_results( 
			$wpdb->prepare( "SELECT * FROM $ninja_forms_subs_table_name WHERE form_id = %d $sub_status ORDER BY id DESC", $form_id)
			, ARRAY_A);
			//echo $wpdb->prepare( "SELECT * FROM $ninja_forms_subs_table_name WHERE form_id = %d AND sub_status = 'complete' ORDER BY id DESC", $form_id);
		}

		$ninja_forms_fields_rows = $wpdb->get_results( 
			$wpdb->prepare("SELECT * FROM $ninja_forms_fields_table_name WHERE form_id = %d ORDER BY field_order ASC", $form_id)
			, ARRAY_A);
		$ninja_forms_row = $wpdb->get_row( 
			$wpdb->prepare("SELECT * FROM $ninja_forms_table_name WHERE id = %d", $form_id)
			, ARRAY_A);

		$form_title = $ninja_forms_row['title'];
		$current_time = current_time('timestamp');
		$date = date('m_d_Y.g.i.a', $current_time);

		$label_array = array();

		$label_array[0][] = "Date/Time";
		$label_array[0][] = "Submission Status";
		if($ninja_forms_fields_rows){
			foreach($ninja_forms_fields_rows as $field){
				$type = $field['type'];
				$label = stripslashes($field['label']);
				$id = $field['id'];
				if($type != 'hr' && $type != 'heading' && $type != 'desc' && $type != 'submit' && $type != 'spam' && $type != 'progressbar' && $type != 'steps' && $type != 'divider' && $type != 'postcontent'){
					$id_array[] = $id;
					$label_array[0][] = $label;
				}
			}
		}
		$x = 0;
		if($ninja_forms_subs_rows){
			if(isset($_REQUEST['download']) AND $_REQUEST['download'] == 'no'){
				echo 'found';
				die();
			}
			foreach($ninja_forms_subs_rows as $sub){
				$form_values = unserialize($sub['form_values']);
				$value_array[$x][] = date('m/d/Y g:ia', strtotime($sub['date_updated']));
				$value_array[$x][] = $sub['sub_status'];
				foreach($id_array as $id){
					$found = 'no';
					$this_value = '----';
					if(is_array($form_values)){
						foreach($form_values as $value){
							if($value['id'] == $id){
								$found = 'yes';
								$this_value = $value['value'];
								if(is_array($this_value)){
									foreach($this_value as $value){
										$this_value = $this_value.", $value";
									}
									$this_value = str_replace("Array, ", "", $this_value);
								}
								break;
							}
						}
					}
					$value_array[$x][] = $this_value;
				}
				$x++;
			}
			

			//Instantiate the class.
			//$xls = new xls($form_title."-".$date); 

			//Just build an example array out of test data
			$array = array(
				$label_array,
				$value_array
			);

			//Triggers the download using the passed array
			//$xls->download_from_array($array);
			$form_title = strtolower($form_title);
			$filename = $form_title.date('dmY').'.csv';
			
			header("Content-type: application/csv");
			header("Content-Disposition: attachment; filename=".$filename);
			header("Pragma: no-cache");
			header("Expires: 0");
			echo str_putcsv($array);
			die();
		}else{
			echo "none";
		}	
	}
}

function str_putcsv($array, $delimiter = ',', $enclosure = '"', $terminator = "\n") { 
	# First convert associative array to numeric indexed array 
	foreach ($array as $key => $value) $workArray[] = $value; 

	$returnString = '';                 # Initialize return string 
	$arraySize = count($workArray);     # Get size of array 
	
	for ($i=0; $i<$arraySize; $i++) { 
		# Nested array, process nest item 
		if (is_array($workArray[$i])) { 
			$returnString .= str_putcsv($workArray[$i], $delimiter, $enclosure, $terminator); 
		} else { 
			switch (gettype($workArray[$i])) { 
				# Manually set some strings 
				case "NULL":     $_spFormat = ''; break; 
				case "boolean":  $_spFormat = ($workArray[$i] == true) ? 'true': 'false'; break; 
				# Make sure sprintf has a good datatype to work with 
				case "integer":  $_spFormat = '%i'; break; 
				case "double":   $_spFormat = '%0.2f'; break; 
				case "string":   $_spFormat = '%s'; $workArray[$i] = str_replace("$enclosure", "$enclosure$enclosure", $workArray[$i]); break; 
				# Unknown or invalid items for a csv - note: the datatype of array is already handled above, assuming the data is nested 
				case "object": 
				case "resource": 
				default:         $_spFormat = ''; break; 
			} 
							$returnString .= sprintf('%2$s'.$_spFormat.'%2$s', $workArray[$i], $enclosure); 
				$returnString .= ($i < ($arraySize-1)) ? $delimiter : $terminator; 
		} 
	} 
	# Done the workload, return the output information 
	return $returnString; 
} 
