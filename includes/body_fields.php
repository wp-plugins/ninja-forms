<?php
global $wp_editor, $wp_version;
wp_nonce_field('ninja_save_form_fields','ninja_form_fields'); 
?>	
<input type="hidden" id="ninja_form_action" name="action" value="<?php echo $_REQUEST['action'];?>">
<input type="hidden" name="submitted" value="yes">
<input type="hidden" name="tab" value="fields">
<input type="hidden" id="ninja_form_new" value="<?php echo $form_new;?>">
<input type="hidden" id="ninja_form_id" name="ninja_form_id" value="<?php echo $form_id;?>">
<input type="hidden" name="ninja_form_fields_order" id="ninja_form_fields_order" value="same">
	<div id="nav-menu-header">
		<div id="submitpost" class="submitbox">
			<div class="major-publishing-actions">
				<!--
				<label class="menu-name-label howto open-label" for="menu-name">
					<span><?php _e('Form Name'); ?></span>
					<input name="menu-name" id="menu-name" type="text" class="menu-name regular-text menu-item-textbox input-with-default-title" title="<?php esc_attr_e('Enter Form Name Here'); ?>" value="TeSt" />
				</label>
				<br class="clear" />
				-->
					
				<div class="publishing-action">
					<input class="button-primary menu-save ninja_save_data" name="save_menu" id="ninja_save_data_top" type="submit" value="<?php esc_attr_e('Save Fields'); ?>" />
				</div><!-- END .publishing-action -->
				<!--
				<div class="delete-action">
					<a class="submitdelete deletion menu-delete" href="<?php echo esc_url( wp_nonce_url( admin_url('nav-menus.php?action=delete&amp;menu=' . $nav_menu_selected_id), 'delete-nav_menu-' . $nav_menu_selected_id ) ); ?>"><?php _e('Delete Menu'); ?></a>
				</div><!-- END .delete-action -->
				
			</div><!-- END .major-publishing-actions -->
		</div><!-- END #submitpost .submitbox -->
		
	</div><!-- END #nav-menu-header -->
	<div id="post-body">
		<div id="post-body-content">
		<ul class="menu" id="ninja_edit_form_fields">

			<?php
			foreach($ninja_forms_fields as $field){
				$id = $field['id'];
				ninja_form_field_editor($id, false);
			}
			?>
			
			</ul>
		</div><!-- /#post-body-content -->
	</div><!-- /#post-body -->
	<div id="nav-menu-footer">
	<div class="major-publishing-actions">
				<!----<label class="menu-name-label howto open-label">
					<span><?php _e('Submit Button Text'); ?></span>
					<input name="menu-name" id="menu-name" type="text" class="menu-name regular-text menu-item-textbox input-with-default-title" title="<?php esc_attr_e('Enter Form Name Here'); ?>" value="Submit" />
				</label>
				---->
				<div class="publishing-action">
					<input class="button-primary menu-save ninja_save_data" name="save_menu" id="ninja_save_data_bot" type="submit" value="<?php esc_attr_e('Save Fields'); ?>" />
				</div><!-- END .publishing-action -->
	</div><!-- END #nav-menu-header -->
	</div>
</form><!-- /#update-nav-menu -->
<div id="editor_cont" style="display:none;">
	<?php
	if(version_compare( $wp_version, '3.3-beta3-19254' , '<')){
		echo $wp_editor->editor($value, "hidden_editor", array('media_buttons_context' => '<span>Insert a media file: </span>', 'upload_link_title' => 'Media Uploader - NinjaForms'), true);
	}else{
		$args = array("media_buttons" => true);
		wp_editor("", "hidden_editor" , $args);
	}
	?>
</div>
<div id="mask_help" class="ninja_help_text" title="Custom Mask Help" style="display:none;">
		<p>Any character you place in the "custom mask" box that is not in the list below will be automatically entered for the user as they type and will not be removeable..</p>
		</p>These are the predefined masking characters:
			<ul>
				<li>a - Represents an alpha character (A-Z,a-z) - Only allows letters to be entered.</lid>
				<li>9 - Represents a numeric character (0-9) - Only allows numbers to be entered.</li>
				<li>* - Represents an alphanumeric character (A-Z,a-z,0-9) - This allows both numbers and letters to be entered.</li>
			</ul>
		</p>
		<p>
			So, if you wanted to a mask for an an American Social Security Number, you'd put 999-99-9999 into the box. The 9's would represent any number, and the -'s would be automatically added. This would prevent the user from putting in anything other than numbers.
		</p>
		<p>
			You can also combine these for specific applications. For instance, if you had a product key that was in the form of A4B51.989.B.43C, you could mask it with: a9a99.999.a.99a, which would force all the a's to be letters and the 9's to be numbers.
		</p>
</div>
<div id="rename_help" class="ninja_help_text" title="File Renaming Help" style="display:none;">
		<p>If you leave the advanced rename box empty, the uploaded file will retain the original user's filename. (With any special characters removed.)</p>
		</p>If you want to rename the file, however, you can. These are the conventions that NinjaForms understands, and their effect.
			<ul>
				<li><span class="code">%filename%</span> - The file's original filename, with any special characters removed.</lid>
				<li><span class="code">%formtitle%</span> - The title of the current form, with any special characters removed.</lid>
				<li><span class="code">%username%</span> - The WordPress username for the user, if they are logged in.</lid>
				<li><span class="code">%date%</span> - Today's date in yyyy-mm-dd format.</lid>
				<li><span class="code">%month%</span> - Today's month in mm format.</lid>
				<li><span class="code">%day%</span> - Today's day in dd format.</lid>
				<li><span class="code">%year%</span> - Today's year in yyyy format.</lid>
			</ul>
		</p>
		<p>
			Any characters other than letters, numbers, dashes (-) and those on the list above will be removed. This includes spaces.
		</p>
		<p>
			An Example: <span class="code">%date%-%filename%</span>
		</p>
		<p>
			Would Yield: <span class="code">2011-07-09-myflowers.jpg</span>
		<p>	
</div>