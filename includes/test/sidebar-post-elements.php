<div id="post-elements" class="postbox" name="field-settings-list" >
	<div class="handlediv" id="handle-post-settings" title="Click to toggle"><br></div>
		<h3 >
			<span><?php _e('Post Elements');?></span>
		</h3>
		<div class="inside" id="post-settings" <?php if($post_settings_state == 'closed' OR $echoed){ echo 'style="display:none;"'; }else{$echoed = true;}?>>
			<p class="howto"><?php _e('If you want NinjaForms to create a post from user input, check the box below and then insert Post-specific fields');?>.</p>
			<p class="button-controls">
				<label for="ninja_form_post">
					<input type="hidden" name="ninja_post" value="unchecked"><input type="checkbox" id="ninja_form_post" name="ninja_post" value="checked" <?php echo $ninja_post;?>> <?php _e('Create Post From Input');?>
				</label>
				<?php if($plugin_settings['admin_help'] == 'checked'){ ?><img id="create_post" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif"><?php } ?>
			</p>
			<div class="button-controls ninja_post_options" id="ninja_post_options" style="<?php if($ninja_post != "checked"){ echo "display:none;";}?>">
				<p class="button-controls">
					<label for="post_options[login]">
						<input type="hidden" name="post_options[login]" value="unchecked"><input type="checkbox" name="post_options[login]" id="post_options[login]" value="checked" <?php echo $post_options['login'];?>> <?php _e('Users Must Be Logged In To Post');?>
					</label>	
					<?php if($plugin_settings['admin_help'] == 'checked'){ ?><img id="require_login" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif"><?php } ?>
				</p>
				<p class="button-controls">
					<?php _e('Users post as');?>
					<?php
					wp_dropdown_users( array('name' => 'post_options[user]', 'id' => 'post_options[user]', 'show_option_all' => '--Themselves', 'selected' => $post_options['user']) );
					?>
					<?php if($plugin_settings['admin_help'] == 'checked'){ ?><img id="post_as" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif"><?php } ?>
				</p>
				<p class="button-controls">
					<?php _e('Select a post type');?>: 
					<select id="" name="post_options[post_type]">				
					<?php
					foreach($post_types as $type){
						if($type != 'nav_menu_item' && $type != 'mediapage' && $type != 'attachment' && $type != 'revision'){
							$type_obj = get_post_type_object($type);
							?>
						<option value="<?php echo $type_obj->name;?>" <?php if($type_obj->name == $post_options['post_type']){ echo 'selected'; }?>><?php echo $type_obj->labels->name;?></option>						
							<?php
						}
					}
					?>
					</select>
					<?php if($plugin_settings['admin_help'] == 'checked'){ ?><img id="post_type" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif"><?php } ?>
				</p>
				<p class="button-controls">
					<?php _e('Select a post status');?>:
					<select id="" name="post_options[post_status]">
						<option value="draft" <?php if($post_options['post_status'] == 'draft'){ echo 'selected';}?>><?php _e('Draft');?></option>
						<option value="pending" <?php if($post_options['post_status'] == 'pending'){ echo 'selected';}?>><?php _e('Pending');?></option>
						<option value="publish" <?php if($post_options['post_status'] == 'publish'){ echo 'selected';}?>><?php _e('Publish');?></option>
					</select>
					<?php if($plugin_settings['admin_help'] == 'checked'){ ?><img id="post_status" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif"><?php } ?>
				</p>
				<p class="button-controls">
					<span <?php if($new_posttitle == 'no'){ ?>style="display:none;"<?php } ?> id="ninja_new_posttitle_<?php echo $ninja_forms_row['id'];?>_cont">
						<a class="button add-new-h2 ninja_new_field" id="ninja_new_posttitle_<?php echo $ninja_forms_row['id'];?>" href="#"><?php _e('Post Title');?></a>
					</span>
				</p>			
				<p class="button-controls">
					<span <?php if($new_postcontent == 'no'){ ?>style="display:none;"<?php } ?> id="ninja_new_postcontent_<?php echo $ninja_forms_row['id'];?>_cont">
						<a class="button add-new-h2 ninja_new_field" id="ninja_new_postcontent_<?php echo $ninja_forms_row['id'];?>" href="#"><?php _e('Post Content');?></a>
						<?php if($plugin_settings['admin_help'] == 'checked'){ ?><img id="post_content" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif"><?php } ?>
					</span>
				</p>				
				<p class="button-controls">
					<span <?php if($new_postexcerpt == 'no'){ ?>style="display:none;"<?php } ?> id="ninja_new_postexcerpt_<?php echo $ninja_forms_row['id'];?>_cont">
						<a class="button add-new-h2 ninja_new_field" id="ninja_new_postexcerpt_<?php echo $ninja_forms_row['id'];?>" href="#"><?php _e('Post Excerpt');?></a>
					</span>
				</p>			
				<p class="button-controls">
					<span <?php if($new_postcat == 'no'){ ?>style="display:none;"<?php } ?> id="ninja_new_postcat_<?php echo $ninja_forms_row['id'];?>_cont">
						<a class="button add-new-h2 ninja_new_field" id="ninja_new_postcat_<?php echo $ninja_forms_row['id'];?>" href="#"><?php _e('Post Category');?></a>
						<?php if($plugin_settings['admin_help'] == 'checked'){ ?><img id="post_cat" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif"><?php } ?>
					</span>
				</p>			
				<p class="button-controls">
					<span <?php if($new_posttags == 'no'){ ?>style="display:none;"<?php } ?> id="ninja_new_posttags_<?php echo $ninja_forms_row['id'];?>_cont">
						<a class="button add-new-h2 ninja_new_field" id="ninja_new_posttags_<?php echo $ninja_forms_row['id'];?>" href="#"><?php _e('Post Tags');?></a>
					</span>
				</p>
		</div>
	</div>
</div>