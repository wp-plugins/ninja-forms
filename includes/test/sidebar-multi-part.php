<div id="multi-part" class="postbox" name="field-settings-list" >
<div class="handlediv" id="handle-multi-settings" title="Click to toggle"><br></div>
	<h3 >
		<span><?php _e('Multi-part Forms');?></span>
	</h3>
	<div class="inside" id="multi-settings" <?php if($multi_settings_state == 'closed' OR $echoed){ echo 'style="display:none;"'; }else{$echoed = true;}?>>
		<p class="howto"><?php _e('If you want your form to be a multi-part form, check the box below and define your options');?>.</p>
		<p class="button-controls">	
			<input type="hidden" name="multi" value="unchecked"><input type="checkbox" name="multi" id="ninja_multi_part" value="checked" <?php echo $multi;?>> <label for="ninja_multi_part"><?php _e('Multi-part Form');?></label> <?php if($plugin_settings['admin_help'] == 'checked'){ ?> <img id="multi_form_help" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif"><?php } ?>
		</p>				
		<div class="button-controls" id="ninja_multi_options" style="<?php if($multi != "checked"){ echo "display:none;";}?>">	
			<h4>Options:</h4>
			<table>
				<tr>
					<td width="55%"><?php _e('Previous Button Label');?>:</td><td width="45%"><input style="width:100%;" type="text" name="multi_options[previous]" value="<?php echo $previous;?>"></td>
				</tr><tr>
					<td><?php _e('Next Button Label');?>:</td><td><input style="width:100%;" type="text" name="multi_options[next]" value="<?php echo $next;?>"></td>
				</tr>
			</table>
			<p class="button-controls">
				<p class="howto"><?php _e('These are multi-form specific fields. Hover over the ? near each for an explaination');?>.</p>
				<p class="button-controls">
					<span <?php if($new_steps == 'no'){ ?>style="display:none;"<?php } ?> id="ninja_new_steps_<?php echo $ninja_forms_row['id'];?>_cont"><a class="button add-new-h2 ninja_new_field" id="ninja_new_steps_<?php echo $ninja_forms_row['id'];?>" href="#"><?php _e('Progress "Steps" Section');?></a>
					 <?php if($plugin_settings['admin_help'] == 'checked'){ ?> <img id="multi_form_steps" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif"><?php } ?></span>
				</p>
				 <p class="button-controls" >
					<span <?php if($new_progressbar == 'no'){ ?>style="display:none;"<?php } ?> id="ninja_new_progressbar_<?php echo $ninja_forms_row['id'];?>_cont"><a class="button add-new-h2 ninja_new_field" id="ninja_new_progressbar_<?php echo $ninja_forms_row['id'];?>" href="#"><?php _e('Progress Bar');?></a>
					 <?php if($plugin_settings['admin_help'] == 'checked'){ ?> <img id="multi_form_progressbar" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif"><?php } ?></span>
				</p>
				<p class="button-controls">
					<a class="button add-new-h2 ninja_new_field" id="ninja_new_divider_<?php echo $ninja_forms_row['id'];?>" href="#" >Section Divider</a>
					 <?php if($plugin_settings['admin_help'] == 'checked'){ ?> <img id="multi_form_divider" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif"><?php } ?>
				</p>
			</p>
		</div>
	</div>
</div>	