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