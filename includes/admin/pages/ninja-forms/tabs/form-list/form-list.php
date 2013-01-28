<?php

add_action( 'init', 'ninja_forms_register_form_export' );
function ninja_forms_register_form_export(){
	if( isset( $_REQUEST['export_form'] ) AND $_REQUEST['export_form'] == 1 ){
		$form_id = $_REQUEST['form_id'];
		ninja_forms_export_form( $form_id );
	}
}


add_action('init', 'ninja_forms_register_tab_form_list');

function ninja_forms_register_tab_form_list(){
	$new_link = esc_url(add_query_arg(array('form_id' => 'new', 'tab' => 'form_settings')));
	$args = array(
		'name' => 'All Forms', 
		'page' => 'ninja-forms',
		'display_function' => 'ninja_forms_tab_form_list',
		'save_function' => 'ninja_forms_save_form_list', 
		'show_save' => false, 
		'active_class' => 'form-list-active', 
		'inactive_class' => 'form-list-inactive',
		'show_tab_links' => false,
		'show_this_tab_link' => false,
		'title' => '<h2>Forms <a href="'.$new_link.'" class="add-new-h2">'.__('Add New Form', 'ninja-forms').'</a></h2>',
	);
	ninja_forms_register_tab('form_list', $args);
}

function ninja_forms_tab_form_list($form_id, $data){
	global $wpdb;
	$all_forms = ninja_forms_get_all_forms();
	$form_count = count($all_forms);
	
	if( isset( $_REQUEST['limit'] ) ){
		$saved_limit = $_REQUEST['limit'];
		$limit = $_REQUEST['limit'];
	}else{
		$saved_limit = 20;
		$limit = 20;
	}

	if( $form_count < $limit ){
		$limit = $form_count;
	}

	if( isset( $_REQUEST['paged']) AND !empty( $_REQUEST['paged'] ) ){
		$current_page = $_REQUEST['paged'];
	}else{
		$current_page = 1;
	}

	if( $form_count > $limit ){
		$page_count = ceil( $form_count / $limit );
	}else{
		$page_count = 1;
	}

	if( $current_page > 1 ){
		$start = ( ( $current_page - 1 ) * $limit );
		if( $form_count < $limit ){
			$end = $form_count;
		}else{
			$end = $current_page * $limit;
			$end = $end - 1;
		}

		if( $end > $form_count ){
			$end = $form_count;
		}
	}else{
		$start = 0;
		$end = $limit;
	}
	
	?>
	<ul class="subsubsub">
		<li class="all"><a href="" class="current">All <span class="count">(<?php echo $form_count;?>)</span></a>
	</ul>
	<div id="" class="tablenav top">
		<div class="alignleft actions">
			<select id="" class="" name="bulk_action">
				<option value=""><?php _e('Bulk Actions', 'ninja-forms');?></option>
				<option value="delete"><?php _e('Delete', 'ninja-forms');?></option>
				<!-- <option value="export"><?php _e('Export Forms', 'ninja-forms');?></option> -->
			</select>
			<input type="submit" name="submit" value="Apply" class="button-secondary">
		</div>
		<div class="alignleft actions">
			<select id="" name="limit">
				<option value="20" <?php selected($saved_limit, 20);?>>20</option>
				<option value="50" <?php selected($saved_limit, 50);?>>50</option>
				<option value="100" <?php selected($saved_limit, 100);?>>100</option>
			</select>
			<?php _e('Forms Per Page', 'ninja-forms');?>
			<input type="submit" name="submit" value="Go" class="button-secondary">
		</div>
		<div id="" class="alignright navtable-pages">
			<?php
			if($form_count != 0 AND $current_page <= $page_count){
			?>
			<span class="displaying-num"><?php if($start == 0){ echo 1; }else{ echo $start; }?> - <?php echo $end;?> of <?php echo $form_count;?> <?php if($form_count == 1){ _e('Form', 'ninja-forms'); }else{ _e('Forms', 'ninja-forms');}?></span>
			<?php
			}
				if($page_count > 1){

					$first_page = remove_query_arg('paged');
					$last_page = add_query_arg(array('paged' => $page_count));

					if($current_page > 1){
						$prev_page = $current_page - 1;
						$prev_page = add_query_arg(array('paged' => $prev_page));
					}else{
						$prev_page = $first_page;
					}
					if($current_page != $page_count){
						$next_page = $current_page + 1;
						$next_page = add_query_arg(array('paged' => $next_page));
					}else{
						$next_page = $last_page;
					}
					
			?>
			<span class="pagination-links">
				<a class="first-page disabled" title="Go to the first page" href="<?php echo $first_page;?>">«</a>
				<a class="prev-page disabled" title="Go to the previous page" href="<?php echo $prev_page;?>">‹</a>
				<span class="paging-input"><input class="current-page" title="Current page" type="text" name="paged" value="<?php echo $current_page;?>" size="2"> of <span class="total-pages"><?php echo $page_count;?></span></span>
				<a class="next-page" title="Go to the next page" href="<?php echo $next_page;?>">›</a>
				<a class="last-page" title="Go to the last page" href="<?php echo $last_page;?>">»</a>
			</span>
			<?php
				}
			?>
		</div>
	</div>
	<table class="wp-list-table widefat fixed posts">
		<thead>
			<tr>
				<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
				<th><?php __( 'Form Title', 'ninja-forms' );?></th>
				<th><?php __( 'Date Updated', 'ninja-forms' );?></th>
			</tr>
		</thead>
		<tbody>
	<?php
	if(is_array($all_forms) AND !empty($all_forms) AND $current_page <= $page_count){
		for ($i = $start; $i < $end; $i++) {
			$form_id = $all_forms[$i]['id'];
			$data = $all_forms[$i]['data'];
			$date_updated = $all_forms[$i]['date_updated'];
			$date_updated = strtotime( $date_updated );
			$date_updated = date( 'F d, Y', $date_updated );
			$edit_link = esc_url( add_query_arg( array( 'tab' => 'form_settings', 'form_id' => $form_id ) ) );
			$subs_link = admin_url( 'admin.php?page=ninja-forms-subs&form_id='.$form_id );
			$export_link = esc_url( add_query_arg( array( 'export_form' => 1, 'form_id' => $form_id ) ) );
			?>
			<tr id="ninja_forms_form_<?php echo $form_id;?>_tr">
				<th scope="row" class="check-column">
					<input type="checkbox" id="" name="form_ids[]" value="<?php echo $form_id;?>" class="ninja-forms-bulk-action">
				</th>
				<td class="post-title page-title column-title">
					<strong>
						<a href="<?php echo $edit_link;?>"><?php echo $data['form_title'];?></a>
					</strong>
					<div class="row-actions">
						<span class="edit"><a href="<?php echo $edit_link;?>">Edit</a> | </span>
						<span class="trash"><a class="ninja-forms-delete-form" title="Delete this form" href="#" id="ninja_forms_delete_form_<?php echo $form_id;?>">Delete</a> | </span>
						<span class="export"><a href="<?php echo $export_link;?>" title="Export Form">Export</a> | </span>
						<span class="bleep"><?php echo ninja_forms_preview_link( $form_id ); ?> | </span>
						<span class="subs"><a href="<?php echo $subs_link;?>" class="" title="View Submissions">View Submissions</a></span>
					</div>
				</td>
				<td>
					<?php echo $date_updated;?>
				</td>
			</tr>
			
			<?php
		}
	}else{


	}	//End $all_forms if statement
	?>
		</tbody>
		<tfoot>
			<tr>
				<th class="check-column"><input type="checkbox" id="" class="ninja-forms-select-all" title="ninja-forms-bulk-action"></th>
				<th>Form Title</th>
				<th>Date Updated</th>
			</tr>
		</tfoot>
	</table>
	<?php
}

function ninja_forms_save_form_list( $data ){
	global $ninja_forms_admin_update_message;
	if( isset( $data['bulk_action'] ) AND $data['bulk_action'] != '' ){
		if( isset( $data['form_ids'] ) AND is_array( $data['form_ids'] ) AND !empty( $data['form_ids'] ) ){
			foreach( $data['form_ids'] as $form_id ){
				switch( $data['bulk_action'] ){
					case 'delete':
						ninja_forms_delete_form( $form_id );
						$ninja_forms_admin_update_message = count( $data['form_ids'] ).' ';
						if( count( $data['form_ids'] ) > 1 ){
							$ninja_forms_admin_update_message .= __( 'Forms Deleted', 'ninja-forms' );
						}else{
							$ninja_forms_admin_update_message .= __( 'Form Deleted', 'ninja-forms' );
						}
						break;
					case 'export':
						ninja_forms_export_form( $form_id );
						break;
				}
			}
		}
	}
}