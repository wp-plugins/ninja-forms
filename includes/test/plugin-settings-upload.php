<p>
	<?php _e('File Upload Directory (including trailing slash)');?>: <a href="#" id="upload_dir_advanced" class="ninja-advanced"><?php _e('Advanced');?></a>
	<div id="upload_dir_advanced_cont" style="display:none;">
		<span class="howto"><?php _e('You can use the following shortcodes in your directory name');?>:</span>
		<ul>
			<li><span class="code">%formtitle%</span> - <?php _e('Puts in the title of the current form without any spaces');?></li>
			<li><span class="code">%username%</span> - <?php _e("Puts in the user's username if they are logged in");?>.</li>
			<li><span class="code">%date%</span> - <?php _e('Puts in the date in yyyy-mm-dd (1998-05-23) format');?>.</li>
			<li><span class="code">%month%</span> - <?php _e('Puts in the month in mm (04) format');?>.</li>
			<li><span class="code">%day%</span> - <?php _e('Puts in the day in dd (20) format');?>.</li>
			<li><span class="code">%year%</span> - <?php _e('Puts in the year in yyyy (2011) format');?>.</li>
		</ul>
		<?php _e('For example');?>:
		<span class="code"><?php echo $upload_dir;?>%date%/%formtitle%/</span><br>
		<br>
	</div>
	<input type="text" class="code widefat" id="plugin_settings_upload_dir" name="upload_dir" value="<?php echo $plugin_settings['upload_dir'];?>"> 
	
	<input type="button" id="<?php echo $upload_dir;?>" class="ninja-reset-upload-dir" value="Reset Directory">
	<img id="reset_upload_dir" src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif">
</p>
<p><?php _e('Maximum File Size');?>: <input type="text" class="code" id="plugin_settings_upload_size" name="upload_size" value="<?php echo $plugin_settings['upload_size'];?>"><span class="code">MB (<?php _e('Maximum allowed by your server');?>: <?php echo $upload_mb;?>mb.)</span></p>
<br><br>