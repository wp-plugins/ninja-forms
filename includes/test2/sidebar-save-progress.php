<p class="button-controls">
	<label for="form_<?php echo $form_id;?>[save_status]">
		<input type="hidden" name="form_<?php echo $form_id;?>[save_status]" value="unchecked"><input type="checkbox" name="form_<?php echo $form_id;?>[save_status]" id="form_<?php echo $form_id;?>[save_status]" value="checked" class="ninja-save-status" <?php echo $save_status;?>> <?php _e('Allow Users to Save Progress', 'ninja-forms');?>
	</label>
</p>			
<span id="ninja_save_status_options" <?php if($save_status != 'checked'){ echo 'style="display:none;"';}?>>
	<p class="button-controls">
		<label for="form_<?php echo $form_id;?>[save_status_options][delete]">
			<?php _e('Remove incomplete entries every', 'ninja-forms');?> <input type='text' class="code" style="width:35px" name='form_<?php echo $form_id;?>[save_status_options][delete]' id='form_<?php echo $form_id;?>[save_status_options][delete]' value='<?php echo $save_status_delete;?>'> <?php _e('days', 'ninja-forms');?>. (<?php _e('If left blank, they will not be removed', 'ninja-forms');?>)
		</label>
	</p>
	<p class="button-controls">
		<label for="">
			<?php _e('Successful save message', 'ninja-forms');?>: <br><textarea name="form_<?php echo $form_id;?>[save_status_options][msg]" id="form_<?php echo $form_id;?>[save_status_options][msg]" cols="40" rows="5"><?php echo $save_status_msg;?></textarea>
		</label>
	</p>
</span>