<?php
$lang_current = get_lang_code_defaut();
?>

<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
  <div class="card content">
      <div class="card-header">
        <h3 class="card-title"><i class="fe fe-edit"></i> <?=lang("email_template")?></h3>
      </div>
      <div class="card-body">
        <form class="actionForm" action="<?=cn("$module/ajax_general_settings")?>" method="POST" data-redirect="<?=cn($module."?t=".$tab)?>">
          <div class="row">
            <div class="col-md-12 col-lg-12">

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("email_verification_for_new_customer_accounts")?></h5>
              <div class="form-group">
                <label class="form-label"><?=lang("Subject")?></label>
                <input class="form-control" name="verification_email_subject" value="<?=get_option('verification_email_subjecte')?>">
				<input type="hidden" class="form-control" name="verification_email_subjecte" value=" ">
              </div>   

              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="verification_email_content" id="verify" class="form-control"><?=get_option('verification_email_contente')?>
                </textarea>
				<textarea style="display:none" rows="3" name="verification_email_contente"  id="verifye" class="form-control">
                </textarea>
              </div>

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("new_user_welcome_email")?></h5>
              <div class="form-group">
                <label class="form-label"><?=lang("Subject")?></label>
                <input class="form-control" name="email_welcome_email_subject" value="<?=get_option('email_welcome_email_subjecte')?>">
				<input type="hidden" class="form-control" name="email_welcome_email_subjecte" value="">
              </div>   

              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="email_welcome_email_content" id="welcome" class="form-control"><?=get_option('email_welcome_email_contente')?>
                </textarea>
				 <textarea style="display:none" rows="3" name="email_welcome_email_contente"  id="welcomee" class="form-control">
                </textarea>
              </div> 

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("new_user_notification_email")?></h5 class="text-info">
              <div class="form-group">
                <label class="form-label"><?=lang("Subject")?></label>
                <input class="form-control" name="email_new_registration_subject" value="<?=get_option('email_new_registration_subjecte')?>">
				<input type="hidden" class="form-control" name="email_new_registration_subjecte" value="">
              </div>   
               
              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="email_new_registration_content" id="register" class="form-control"><?=get_option('email_new_registration_contente')?>

                </textarea>
				  <textarea style="display:none" rows="3" id="registere" name="email_new_registration_contente"  class="form-control">

                </textarea>
              </div>   

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("password_recovery")?></h5 class="text-info">
              <div class="form-group">
                <label class="form-label"><?=lang("Subject")?></label>
                <input class="form-control" name="email_password_recovery_subject" value="<?=get_option('email_password_recovery_subjecte')?>">
				<input type="hidden" class="form-control" name="email_password_recovery_subjecte" value="">
			  </div>    
              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="email_password_recovery_content" id="recovery" class="form-control"><?=get_option('email_password_recovery_contente')?>
                </textarea>
				<textarea style="display:none" rows="3" id="recoverye" name="email_password_recovery_contente"  class="form-control">
                </textarea>
              </div>

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("payment_notification_email")?></h5 class="text-info">
              <div class="form-group">
                <label class="form-label"><?=lang("Subject")?></label>
                <input class="form-control" name="email_payment_notice_subject" value="<?=get_option('email_payment_notice_subjecte')?>">
				<input type="hidden" class="form-control" name="email_payment_notice_subjecte" value="">
              </div>    
              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="email_payment_notice_content" id="payment" class="form-control"><?=get_option('email_payment_notice_contente')?>
                </textarea>
				 <textarea style="display:none" rows="3" id="paymente" name="email_payment_notice_contente"  class="form-control">
                 </textarea>
              </div>

              <div class="form-group">
                <div class="small">
                  <strong><?=lang("note")?></strong> <?=lang("you_can_use_following_template_tags_within_the_message_template")?><br> 
                  <ul>
                    <li>{{user_firstname}} - <?=lang("displays_the_users_first_name")?></li>
                    <li>{{user_lastname}} - <?=lang("displays_the_users_last_name")?></li>
                    <li>{{user_email}} - <?=lang("displays_the_users_email")?></li>
                    <li>{{user_timezone}} - <?=lang("displays_the_users_timezone")?></li>
                    <li>{{recovery_password_link}} - <?=lang("displays_recovery_password_link")?></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-footer">
                <button class="btn btn-primary btn-min-width btn-lg text-uppercase"><?=lang("Save")?></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
	<script>

	$(document).on('click', '.btn-primary', function() {
		 $('input[name="verification_email_subjecte"]').val($('input[name="verification_email_subject"]').val());
		 $('#verifye').val(CKEDITOR.instances['verify'].getData());
		 $('input[name="email_welcome_email_subjecte"]').val($('input[name="email_welcome_email_subject"]').val());
		 $('#welcomee').val(CKEDITOR.instances['welcome'].getData());
		 $('input[name="email_new_registration_subjecte"]').val($('input[name="email_new_registration_subject"]').val());
		 $('#registere').val(CKEDITOR.instances['register'].getData());
		 $('input[name="email_password_recovery_subjecte"]').val($('input[name="email_password_recovery_subject"]').val());
		 $('#recoverye').val(CKEDITOR.instances['recovery'].getData());
		 $('input[name="email_payment_notice_subjecte"]').val($('input[name="email_payment_notice_subject"]').val());
		 $('#paymente').val(CKEDITOR.instances['payment'].getData());
	 });
	</script>
<?php }else{ ?>
      <div class="card content">
      <div class="card-header">
        <h3 class="card-title"><i class="fe fe-edit"></i> <?=lang("email_template")?></h3>
      </div>
      <div class="card-body">
        <form class="actionForm" action="<?=cn("$module/ajax_general_settings")?>" method="POST" data-redirect="<?=cn($module."?t=".$tab)?>">
          <div class="row">
            <div class="col-md-12 col-lg-12">

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("email_verification_for_new_customer_accounts")?></h5>
              <div class="form-group">
                <label class="form-label"><?=lang("Subject")?></label>
                <input class="form-control" name="verification_email_subject" value="<?=get_option('verification_email_subjectr')?>">
				<input type="hidden" class="form-control" name="verification_email_subjectr" value=" ">
              </div>   

              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="verification_email_content" id="verify" class="form-control"><?=get_option('verification_email_contentr')?>
                </textarea>
				<textarea style="display:none" rows="3" name="verification_email_contentr"  id="verifyr" class="form-control">
                </textarea>
              </div>

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("new_user_welcome_email")?></h5>
              <div class="form-group">
                <label class="form-label"><?=lang("Subject")?></label>
                <input class="form-control" name="email_welcome_email_subject" value="<?=get_option('email_welcome_email_subjectr')?>">
				<input type="hidden" class="form-control" name="email_welcome_email_subjectr" value="">
              </div>   

              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="email_welcome_email_content" id="welcome" class="form-control"><?=get_option('email_welcome_email_contentr')?>
                </textarea>
				 <textarea style="display:none" rows="3" name="email_welcome_email_contentr"  id="welcomer" class="form-control">
                </textarea>
              </div> 

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("new_user_notification_email")?></h5 class="text-info">
              <div class="form-group">
                <label class="form-label"><?=lang("Subject")?></label>
                <input class="form-control" name="email_new_registration_subject" value="<?=get_option('email_new_registration_subjectr')?>">
				<input type="hidden" class="form-control" name="email_new_registration_subjectr" value="">
              </div>   
               
              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="email_new_registration_content" id="register" class="form-control"><?=get_option('email_new_registration_contentr')?>

                </textarea>
				  <textarea style="display:none" rows="3" id="registerr" name="email_new_registration_contentr"  class="form-control">

                </textarea>
              </div>   

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("password_recovery")?></h5 class="text-info">
              <div class="form-group">
                <label class="form-label"><?=lang("Subject")?></label>
                <input class="form-control" name="email_password_recovery_subject" value="<?=get_option('email_password_recovery_subjectr')?>">
				<input type="hidden" class="form-control" name="email_password_recovery_subjectr" value="">
			  </div>    
              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="email_password_recovery_content" id="recovery" class="form-control"><?=get_option('email_password_recovery_contentr')?>
                </textarea>
				<textarea style="display:none" rows="3" id="recoveryr" name="email_password_recovery_contentr"  class="form-control">
                </textarea>
              </div>

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("payment_notification_email")?></h5 class="text-info">
              <div class="form-group">
                <label class="form-label"><?=lang("Subject")?></label>
                <input class="form-control" name="email_payment_notice_subject" value="<?=get_option('email_payment_notice_subjectr')?>">
				<input type="hidden" class="form-control" name="email_payment_notice_subjectr" value="">
              </div>    
              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="email_payment_notice_content" id="payment" class="form-control"><?=get_option('email_payment_notice_contentr')?>
                </textarea>
				 <textarea style="display:none" rows="3" id="paymentr" name="email_payment_notice_contentr"  class="form-control">
                 </textarea>
              </div>

              <div class="form-group">
                <div class="small">
                  <strong><?=lang("note")?></strong> <?=lang("you_can_use_following_template_tags_within_the_message_template")?><br> 
                  <ul>
                    <li>{{user_firstname}} - <?=lang("displays_the_users_first_name")?></li>
                    <li>{{user_lastname}} - <?=lang("displays_the_users_last_name")?></li>
                    <li>{{user_email}} - <?=lang("displays_the_users_email")?></li>
                    <li>{{user_timezone}} - <?=lang("displays_the_users_timezone")?></li>
                    <li>{{recovery_password_link}} - <?=lang("displays_recovery_password_link")?></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-footer">
                <button class="btn btn-primary btn-min-width btn-lg text-uppercase"><?=lang("Save")?></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
	<script>

	$(document).on('click', '.btn-primary', function() {
		 $('input[name="verification_email_subjectr"]').val($('input[name="verification_email_subject"]').val());
		 $('#verifyr').val(CKEDITOR.instances['verify'].getData());
		 $('input[name="email_welcome_email_subjectr"]').val($('input[name="email_welcome_email_subject"]').val());
		 $('#welcomer').val(CKEDITOR.instances['welcome'].getData());
		 $('input[name="email_new_registration_subjectr"]').val($('input[name="email_new_registration_subject"]').val());
		 $('#registerr').val(CKEDITOR.instances['register'].getData());
		 $('input[name="email_password_recovery_subjectr"]').val($('input[name="email_password_recovery_subject"]').val());
		 $('#recoveryr').val(CKEDITOR.instances['recovery'].getData());
		 $('input[name="email_payment_notice_subjectr"]').val($('input[name="email_payment_notice_subject"]').val());
		  $('#paymentr').val(CKEDITOR.instances['payment'].getData());
	 });
	</script>
<?php } ?>
<script src="<?=BASE?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>

<script>

  CKEDITOR.replace( 'register', {
    height: 150
  });

  CKEDITOR.replace( 'welcome', {
    height: 150
  });

  CKEDITOR.replace( 'verify', {
    height: 150
  });

  CKEDITOR.replace( 'recovery', {
    height: 150
  });
  
  CKEDITOR.replace( 'payment', {
    height: 150
  });


</script>
<?php }else{ ?>
<script>

  CKEDITOR.replace( 'register', {
    height: 150,
	contentsLangDirection:'rtl'
  });

  CKEDITOR.replace( 'welcome', {
    height: 150,
	contentsLangDirection:'rtl'
  });

  CKEDITOR.replace( 'verify', {
    height: 150,
	contentsLangDirection:'rtl'
  });

  CKEDITOR.replace( 'recovery', {
    height: 150,
	contentsLangDirection:'rtl'
  });
  
  CKEDITOR.replace( 'payment', {
    height: 150,
	contentsLangDirection:'rtl'
  });

</script>
<?php } ?>

