jQuery(document).ready(function() {

	jQuery(".ninja_close_dialog").live("click", function(event){
		event.preventDefault();
		jQuery(this).parent().dialog('close');	
	});
	function goToByScroll(id){
		jQuery('html,body').animate({scrollTop: jQuery("#"+id).offset().top - 150},'slow');
	}

	jQuery( "#ninja_form_overlay" ).dialog({
		height: 200,
		autoOpen: false,
		modal: true
	});
	
	if(jQuery("#ninja_multi_progress").val() == 'checked'){
		var multi_count = jQuery("#ninja_multi_count").val();
		var percent = (1 / multi_count) * 100;
		percent = Math.floor(percent);	
		jQuery( "#progressbar" ).progressbar({
				value: 0
		});
	}
	
	jQuery(".ninja_multi_form_next").click(function(event){
		event.preventDefault();
		var current_page = this.id.replace("ninja_page_", "");
		current_page = parseInt(current_page);
		var next_page = current_page + 1;
		var form_id = jQuery("#ninja_form_id").val();
		var ninja_submit = 1;
		jQuery("#ninja_multi_page_" + current_page).find('.ninja_req').each(function(){
			if(this.type != 'checkbox'){
				if(this.value == '' || this.value == this.title){
					jQuery(this).addClass('ninja_error');
					ninja_submit = 0;
				}else{
					if(jQuery(this).hasClass('email')){
						var string = jQuery(this).val();
						if(string.search(/^[a-zA-Z]+([_\.-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,4})+$/) == -1){
							jQuery(this).addClass('ninja_error');
							ninja_submit = 0;
						}else{
							jQuery(this).removeClass('ninja_error');
						}
					}else{
						jQuery(this).removeClass('ninja_error');
					}
				}
			}else{
				if(this.checked == ''){
					jQuery(this).addClass('ninja_error');
					ninja_submit = 0;
				}else{
					jQuery(this).removeClass('ninja_error');
				}
			}
		});
		if(ninja_submit == 1 || jQuery("#ninja_next_req").val() == 'unchecked'){
			jQuery("#ninja_multi_page_" + current_page).hide();
			jQuery("#ninja_multi_page_" + next_page).show();
			var new_name = jQuery("#ninja_multi_name_" + next_page).val();
			jQuery("#ninja_multi_name").prop("innerHTML", new_name);
			if(jQuery("#ninja_multi_progress").val() == 'checked'){
				var multi_count = jQuery("#ninja_multi_count").val();
				multi_count = parseInt(multi_count);

				var percent = current_page / multi_count;
				percent = percent * 100;
				percent = Math.floor(percent);

				jQuery("#progressbar").progressbar( "option", "value", percent );
			}
			jQuery("#ninja_multi_step").prop("innerHTML", next_page);
			goToByScroll('ninja_form_top');
		}else{
			jQuery("#ninja_form_overlay").prop("innerHTML", ajax.ninja_forms_required + "<br /> <a href='#' class='ninja_close_dialog'>Close</a>");
			jQuery("#ninja_form_overlay").dialog('open');
		}
	});		
	jQuery(".ninja_multi_form_previous").click(function(event){
		event.preventDefault();
		var current_page = this.id.replace("ninja_page_", "");
		current_page = parseInt(current_page);
		var previous_page = current_page - 1;
		var form_id = jQuery("#ninja_form_id").val();
		jQuery("#ninja_multi_page_" + current_page).hide();
		jQuery("#ninja_multi_page_" + previous_page).show();
		var new_name = jQuery("#ninja_multi_name_" + previous_page).val();
		jQuery("#ninja_multi_name").prop("innerHTML", new_name);
		if(jQuery("#ninja_multi_progress").val() == 'checked'){
			var multi_count = jQuery("#ninja_multi_count").val();
			multi_count = parseInt(multi_count);

			var percent = (previous_page -1 ) / multi_count;

			percent = percent * 100;
			percent = Math.floor(percent);
			if(previous_page == 1){
				percent = 0;
			}

			jQuery("#progressbar").progressbar( "option", "value", percent );
		}
		jQuery("#ninja_multi_step").prop("innerHTML", previous_page);
		goToByScroll('ninja_form_top');	
	});	

	var options = { 

		beforeSubmit:  ninjaSubmit, 
		success:       ninjaResponse,
		type:				'POST',
		url: ajax.ajaxurl
		};
	var ninja_form_id = jQuery("#ninja_form_id").val();
	jQuery("#ninja_form_" + ninja_form_id).ajaxForm(options);
	
	function ninjaSubmit(formData, jqForm, options){
		jQuery("input").removeClass("ninja_error");
		if(jQuery("#ninja_save_status").val() != 'yes'){
			jQuery("#progressbar").progressbar( "option", "value", 100 );
		}
		jQuery("#ninja_form_overlay").dialog('open');
		var ninja_submit = 1;
		if(jQuery("#ninja_save_status").val() != 'yes'){
			jQuery(".ninja_req").each(function(){
				if(this.type != 'checkbox'){
					if(this.value == '' || this.value == this.title){
						jQuery(this).addClass('ninja_error');
						ninja_submit = 0;
					}else{
						if(jQuery(this).hasClass('email')){
							var string = jQuery(this).val();
							if(string.search(/^[a-zA-Z]+([_\.-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,4})+$/) == -1){
								jQuery(this).addClass('ninja_error');
								ninja_submit = 0;
							}else{
								jQuery(this).removeClass('ninja_error');
							}
						}else{
							jQuery(this).removeClass('ninja_error');
						}
					}
				}else{
					if(this.checked == ''){
						jQuery(this).addClass('ninja_error');
						ninja_submit = 0;
					}else{
						jQuery(this).removeClass('ninja_error');
					}
				}
			});
		}			
		if(ninja_submit == 0){
			jQuery("#ninja_form_overlay").prop("innerHTML", ajax.ninja_forms_required + "<br /> <a href='#' class='ninja_close_dialog'>Close</a>");
				
			jQuery("#ninja_form").show();
			return false;
		}else{
			jQuery("#ninja_form_overlay").prop("innerHTML", ajax.ninja_forms_wait + "<br />");
			return true;
		}
	}
	function ninjaResponse(responseText, statusText, xhr, $form){
		//alert(responseText);	
		var response = responseText.split("|ninja_forms|");
		var tmp = 'pass';
		if(response.length > 1){
			for(var i in response){
				if(typeof(response[i]) == 'string'){
					var error = response[i].split("_");
					var id = error[0];
					var status = error[1];
					var el_id = "ninja_field_" + id;
					if(status == 'spam-error'){
						if(tmp != "pass"){
							tmp = ajax.ninja_forms_general_error;
						}else{
							tmp = ajax.ninja_forms_spam_error;
						}
						el_id = "ninja_field_spam";
					}else if(status == 'file-type-error'){
						if(tmp != "pass"){
							tmp = ajax.ninja_forms_general_error;
						}else{
							tmp = ajax.ninja_forms_file_type_error;
						}
					}else if(status == 'file-size-error'){
						if(tmp != "pass"){
							tmp = ajax.ninja_forms_general_error;
						}else{
							tmp = ajax.ninja_forms_file_size_error;
						}
					}else if(status == 'email-exists'){
						if(tmp != "pass"){
							tmp = ajax.ninja_forms_general_error;
						}else{
							tmp = ajax.ninja_forms_exists_error;
						}
					}
					jQuery("#" + el_id).addClass('ninja_error');
					jQuery("#" + el_id).focus();
				}
			}
		}
		if(tmp == 'pass'){
			jQuery("#ninja_field_spam").removeClass('ninja_error');
			var ninja_ajax_submit = jQuery("#ninja_ajax_submit").val();
			if(ninja_ajax_submit != 'checked'){
				window.location = responseText;
			}else{
				jQuery("#ninja_form").addClass("ninja-success");
				jQuery("#ninja_form").prop("innerHTML", responseText);
				jQuery("#ninja_form_overlay").dialog('close');
			}
		}else{
			jQuery("#ninja_form_overlay").prop("innerHTML", tmp + "<br /> <a href='#' class='ninja_close_dialog'>Close</a>");
			jQuery("#ninja_form_overlay").dialog('open');
		}
	}
	
	jQuery('[title = "Media Uploader - NinjaForms"]').live("mousedown", function(){
		var id = this.id.replace("-add_media", "");
		if (typeof(tinyMCE) != "undefined") {
			tinyMCE.execInstanceCommand( id, "mceFocus"); 
		}
	});
	
	jQuery("#ninja_save_progress").click(function(){
		jQuery("#ninja_save_status").val("yes");
		if (typeof(tinyMCE) != "undefined") {
			tinyMCE.triggerSave(true,true);
		}
		if(jQuery("#ninja_form_continue").val() == ''){
			if(jQuery("#ninja_user_id").val()){
				var form_id = jQuery("#ninja_form_id").val();
				jQuery("#ninja_form_" + form_id).submit();
			}else{
				jQuery("#ninja_form_save_progress").dialog('open');
			}
		}else{
			var form_id = jQuery("#ninja_form_id").val();
			jQuery("#ninja_form_" + form_id).submit();
		}
	});
	
	jQuery("#ninja_submit").click(function(){
		if (typeof(tinyMCE) != "undefined") {
			tinyMCE.triggerSave(true,true);
		}
		jQuery("#ninja_save_status").val('no');
	});
	
	jQuery( "#ninja_form_save_progress" ).dialog({
		height: 350,
		width: 350,
		autoOpen: false,
		modal: true
	});	
	jQuery( "#ninja_form_continue_login" ).dialog({
		height: 350,
		width: 350,
		autoOpen: false,
		modal: true
	});
	jQuery( "#ninja_forgot_pass" ).dialog({
		height: 200,
		width: 350,
		autoOpen: false,
		modal: true
	});
	
	jQuery("#ninja_cancel_save").click(function(){
		jQuery("#ninja_form_save_progress").dialog('close');
	});

	jQuery("#ninja_popup_save").click(function(){
		if (typeof(tinyMCE) != "undefined") {
			tinyMCE.triggerSave(true,true);
		}
		var error = '';
		if(jQuery("#ninja_save_email").val() == ''){
			alert("Email field cannot be left blank.");
			jQuery("#ninja_save_email").addClass("ninja_error");
			error = 'email';
		}else{
			jQuery("#ninja_save_email").removeClass("ninja_error");
		}
		if(jQuery("#ninja_save_password1").val() != '' && jQuery("#ninja_save_password2").val() != ''){
			if(jQuery("#ninja_save_password1").val() == jQuery("#ninja_save_password2").val()){
				if(error != 'email'){
					jQuery("#ninja_form_save_progress").dialog('close');
					var form_id = jQuery("#ninja_form_id").val();
					var tmp_email = jQuery("#ninja_save_email").val();
					jQuery("#ninja_form_save_email").val(tmp_email);
					var tmp_password = jQuery("#ninja_save_password1").val();
					jQuery("#ninja_form_save_password").val(tmp_password);
					jQuery("#ninja_form_" + form_id).submit();
				}
			}else{
				if(error != 'email'){
					alert(ajax.ninja_forms_password_match_error);
				}
			}
		}else{
			if(error != 'email'){	
				alert(ajax.ninja_forms_password_blank_error);
			}
		}
	});
	
	jQuery("#ninja_show_continue_login").click(function(event){
		event.preventDefault();
		jQuery("#ninja_form_continue_login").dialog('open');
	});
	
	jQuery("#ninja_cancel_login").click(function(){
		jQuery("#ninja_form_continue_login").dialog('close');
	});
	
	jQuery("#ninja_login_button").click(function(){
		var email = jQuery("#ninja_login_email").val();
		var password = jQuery("#ninja_login_password").val();
		var form_id = jQuery("#ninja_form_id").val();
		var user_id = jQuery("#ninja_user_id").val();
		$.post(ajax.ajaxurl, { form_id: form_id, email: email, password: password, user_id: user_id, action:"ninja_form_login"}, function(data){
			//alert(data);
			if(data == 'fail'){
				if(user_id){
					alert(ajax.ninja_forms_saved_error);
				}else{
					alert(ajax.ninja_forms_login_error);
				}
			}else{
				data = data.split('-ninja-');
				var sub_id = data[0];
				var obj = eval('(' + data[1] + ')');
				$.each(obj.fields, function(i,data){
					var value = data.value.replace("&quot;", '"');
					if(data.type == 'textbox' || data.list_type == 'select' || data.type == 'posttitle' || data.type == 'posttags'){
						jQuery("#ninja_field_" + data.id).val(value);
					}else if(data.type == 'checkbox'){
						if(data.value == 'checked'){
							jQuery("#ninja_field_" + data.id).prop('checked', true);
						}
					}else if(data.type == 'postcontent' || data.type == 'textarea'){
						if((jQuery("#ninja_field_" + data.id).hasClass('wp-editor-area'))){
							tinyMCE.get("ninja_field_" + data.id).setContent(value);
						}
						jQuery("#ninja_field_" + data.id).val(value);
					}else if(data.list_type == 'radio'){
						jQuery("#ninja_field_" + data.id + "[value=" + value + "]").prop("checked", true);
					}else if(data.list_type == 'multi' || data.type == 'postcat'){
						var selected = value.split("|ninja|");
						for(var i in selected){
							jQuery("#ninja_field_" + data.id + " option[value=" + selected[i] + "]").prop('selected', true);
						}
					}else if(data.type == 'file' && data.value != 'file'){
						jQuery("[name='ninja_field_" + data.id + "']").parent().append("<div>" + data.value + "</div>");
						jQuery("[name='ninja_field_" + data.id + "']").val(data.value);
						jQuery("#ninja_field_" + data.id).remove();
					}
				});
				
				jQuery("#ninja_form_continue").val(sub_id);
				jQuery("#ninja_form_continue_login").dialog('close');
				jQuery("#ninja_form_save_email").val(email);
				jQuery("#ninja_form_save_password").val(password);
			}
		});
	});
	jQuery("#ninja_email_pass").click(function(event){
		event.preventDefault();
		jQuery("#ninja_form_continue_login").dialog('close');
		jQuery("#ninja_forgot_pass").dialog('open');
	});
	jQuery("#ninja_forgot_button").click(function(){
		var form_id = jQuery("#ninja_form_id").val();
		var email = jQuery("#ninja_forgot_email").val();
		$.post(ajax.ajaxurl, { form_id: form_id, email: email, action:"ninja_email_pass"}, function(data){
			if(data == 'fail'){
				alert(ajax.ninja_forms_email_not_found);
			}else{
				alert(ajax.ninja_forms_password_reset);
				jQuery("#ninja_forgot_email").val('');
				jQuery("#ninja_forgot_pass").dialog('close');
			}
		});
	});
	
	jQuery('[title = "Media Uploader - NinjaForms"]').live("mousedown", function(){
		var id = this.id.replace("-add_media", "");
		tinyMCE.execInstanceCommand( id, "mceFocus"); 
	});
});
