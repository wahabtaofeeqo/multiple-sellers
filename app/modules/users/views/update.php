<?php

$lang_current = get_lang_code_defaut();
//print_r($lang_current);

?>
<style>
.modal-content {
    border: initial;
    border-radius: 0.1rem;
    background: white;
    z-index: 1000;
    background: transparent;
    border: none;
}
.modal-header{
	background: transparent;
    border: none;
    padding: 1rem 1rem 0rem 1rem;
	color: #fff;
}
div.close,div.close:hover{
	color: #fff;
	opacity:1;
}

.modal-footer{
	border: none;
    padding: 0.3rem 1rem 0rem 1rem;
    background:transparent;
}
.modal-body{
	padding: 0.3rem 1rem 0rem 1rem;
	text-align: center;
}
#modal-btn-si a{
	color:#000;
}
.d-block {
	display:inline-block !important;
	
}
.video-fluid{
	text-align:center;
}
.imgp{
	color: #fff;
    font-size: 16px;
    padding: 1% 0% 0% 15%;
}
    <? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>

    <?php }else{ ?>

    .dropdown-menu.show{
        direction: rtl;
        text-align: right;
    }
	.card-title{
		width:100%;
	}
    <?php } ?>
</style>
<?php
    $current_user=get_current_user_data();
    $permission_array=array();
    $menu_arr=explode(',', $current_user->menu_permissions);
    foreach($menu_list as $menu){
        if(in_array($menu['id'],$menu_arr)){
            array_push($permission_array, $menu['menu_tag']);
        }
    }
    $ids = (!empty($user->ids))? $user->ids: '';
    if ($ids != "") {
      $url = cn($module."/ajax_update/$ids");
    }else{
      $url = cn($module."/ajax_update");
    }
	
	$filepdf=base_url()."assets/uploads/users/".md5(session('uid')).'/';
?>
 <?php if(in_array("user_manager",$permission_array) || is_super_admin()){?>
<div class="page-header">
  <h1 class="page-title">
    <i class="fe fe-edit-3"></i> <?=lang('Edit_user')?>
  </h1>
</div>
 <?php }?>
<div class="row">
    <?php if(in_array("user_manager",$permission_array) || is_super_admin()){?>
  <div class="col-md-6">

    <div class="card">

      <div class="card-header">

        <h3 class="card-title"><?=lang("basic_information")?></h3>

        <div class="card-options">

          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>

          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>

        </div>

      </div>

      <div class="card-body">

        <form class="form actionForm" action="<?=$url?>" data-redirect="<?=cn("$module/update/$ids")?>" method="POST">

          <div class="form-body">

            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label for="projectinput5"><?=lang("first_name")?> <span class="form-required">*</span></label>

                  <input class="form-control square" name="first_name" type="text" value="<?=(!empty($user->first_name))? $user->first_name: ''?>">

                </div>

              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">

                  <div class="form-group">

                    <label for="userinput5"><?=lang("last_name")?> <span class="form-required">*</span></label>

                    <input class="form-control square" name="last_name" type="text" value="<?=(!empty($user->last_name))? $user->last_name: ''?>">

                  </div>

              </div> 

              <div class="col-md-12">

                <div class="form-group">

                  <label for="projectinput5"><?=lang('Email')?>  <span class="form-required">*</span></label>

                  <input class="form-control square" name="email" type="email" <?=(!empty($user->email))? 'disabled': ''?> value="<?=(!empty($user->email))? $user->email: ''?>">

                </div>

              </div>



              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label for="projectinput5"><?=lang("account_type")?></label>

                  <select  name="role" class="form-control square">
                    <option value="admin" <?=(!empty($user->role) && $user->role == "admin")? 'selected': ''?>><?=lang('admin')?></option>
					<option value="m-seller" <?=(!empty($user->role) && $user->role == "m-seller")? 'selected': ''?>><?=lang('Multi-Seller')?></option>
                  </select>



                </div>

              </div>



              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label for="projectinput5"><?=lang('custom_rate')?></label>

                  <select name="custom_rate" class="form-control square">

                    <?php

                      for ($i = 0; $i <= 100; $i++) {

                    ?>

                    <option value="<?=$i?>" <?=(!empty($user->custom_rate) && $user->custom_rate == $i)? 'selected': ''?>><?=$i?>%</option>

                    <?php } ?>

                  </select>

                </div>

              </div> 



              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label><?=lang('Status')?></label>

                  <select name="status" class="form-control square">

                    <option value="1" <?=(!empty($user->status) && $user->status == 1)? 'selected': ''?>><?=lang('Active')?></option>

                    <option value="0" <?=(isset($user->status) && $user->status != 1)? 'selected': ''?>><?=lang('Deactive')?></option>

                  </select>

                </div>

              </div>




              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label for="projectinput5"><?=lang('Timezone')?></label>

                  <select  name="timezone" class="form-control square">

                    <?php $time_zones = tz_list();

                      if (!empty($time_zones)) {

                        foreach ($time_zones as $key => $time_zone) {

                    ?>

                    <option value="<?=$time_zone['zone']?>" <?=(!empty($user->timezone) && $user->timezone == $time_zone["zone"])? 'selected': ''?>><?=$time_zone['time']?></option>

                    <?php }}?>

                  </select>

                </div>

              </div>

              

              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label for="projectinput5"><?=lang('Password')?> <span class="required">*</span></label>

                  <input class="form-control square" name="password" type="password">

                  <small class="text-primary"><?=lang("note_if_you_dont_want_to_change_password_then_leave_these_password_fields_empty")?></small>

                </div>

              </div> 



              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label for="projectinput5"><?=lang('Confirm_password')?> <span class="required">*</span></label>

                  <input class="form-control square" name="re_password" type="password">

                </div>

              </div>
                <?php if(is_super_admin()){?>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                         <div class="form-group">
                           <label for="projectinput5"><?=lang('menu_permission')?></label>
                           <select  id="user_permission" name="user_permission[]" class="form-control square" multiple="multiple">
                               <?php
                               $menu_arr=explode(',', $user->menu_permissions);
                               foreach($menu_list as $menu){?>
                                 <option value="<?= $menu['id']?>" <?=in_array($menu['id'],$menu_arr)?"selected=\"selected\"":""?>> <?= lang($menu['menu_name'])?></option>
                               <?php }?>
                           </select>

                         </div>
                     </div>
                <?php }?>
              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="form-group">

                  <label for="userinput8"><?=lang('Description')?></label>

                  <textarea id="editor"  rows="2" class="form-control square" name="desc" placeholder=<?=lang('Description')?>><?=(!empty($user->desc))? $user->desc: ''?></textarea>

                </div>

              </div>



              <div class="col-md-12 col-sm-12 col-xs-12">

                <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?=lang('Save')?></button>

              </div>

            </div>

          </div>

          <div class="">

          </div>

        </form>

      </div>

    </div>

  </div> 
   <div class="col-md-6">

    <div class="card">

      <div class="card-header">

        <h3 class="card-title"><?=lang("Verification Files")?></h3>

        <div class="card-options">

          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>

          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>

        </div>

      </div>

      <div class="card-body">

        <form class="form actionForm" action="<?=$url?>" data-redirect="" method="POST">
			
          <div class="form-body">

            <div class="row">
			<?php 
			
						if(!empty($verfiles)){
							
							foreach ($verfiles as $key => $mediarow) {
							$urls='https://'.$mediarow->file_path;
							$doc=base_url()."assets/images/doc.png";
							$pdf=base_url()."assets/images/pdf.png";
                        ?>
              <div class="col-md-6 col-sm-6 col-xs-6" style="padding: 15px 10px;">
				<?php if($mediarow->type=='pdf'){ ?>
                <div class="form-group">
					<div style="padding: 5px;
								border: 1px solid #ececec;">
						<label for="projectinput5" class="fl_name"><?=lang($mediarow->name)?></label>
					</div>
                    <div class="video-fluid" style="border: 1px solid #f1f1f1;">
						<img class="d-block" style="width:55%;" id="<?=$mediarow->type?>" src="<?=$pdf?>">
					</div>
                </div>
				<?php }else if($mediarow->type=='doc'){ ?>
				<div class="form-group">
					<div style="padding: 5px;
								border: 1px solid #ececec;">
						<label for="projectinput5" class="fl_name"><?=lang($mediarow->name)?></label>
					</div>
                    <div class="video-fluid" style="border: 1px solid #f1f1f1;">
						<img class="d-block" style="width:55%;" id="<?=$mediarow->type?>" src="<?=$doc?>">
					</div>
                </div>
				<?php }else{ ?>
				<div class="form-group">
					<div style="padding: 5px;
								border: 1px solid #ececec;">
						<label for="projectinput5" class="fl_name"><?=lang($mediarow->name)?></label>
					</div>
                    <div class="video-fluid" style="border: 1px solid #f1f1f1;">
						<img class="d-block" id="<?=$mediarow->type?>" src="<?=$urls?>">
					</div>
                </div>
				
				<?php }?>	
              </div>
			<?php }}?>
                     
            </div>

          </div>

         

        </form>

      </div>

    </div>

  </div> 
  <div class="col-md-6">

    <div class="card">

      <div class="card-header">

        <h3 class="card-title"><?=lang("more_informations")?></h3>

        <div class="card-options">

          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>

          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>

        </div>

      </div>

      <div class="card-body">

        <form class="form actionForm" action="<?=cn($module."/ajax_update_more_infors/$ids")?>" data-redirect="<?=cn("$module/update/$ids")?>" method="POST">

          <div class="form-body">

            <div class="row">

              <?php

                if (!empty($user->more_information)) {

                  $infors     = $user->more_information;

                  $website    = get_value($infors, "website");

                  $phone      = get_value($infors, "phone");

                  $skype_id   = get_value($infors, "skype_id");

                  $what_asap  = get_value($infors, "what_asap");

                  $address    = get_value($infors, "address");

                }

              ?>  

              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label for="userinput5"><?=lang('Website')?></label>

                  <input class="form-control square" name="website" type="text" value="<?=(!empty($website))? $website: ''?>">

                </div>

              </div> 



              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label for="projectinput5"><?=lang('Phone')?></label>

                  <input class="form-control square" name="phone" type="text" value="<?=(!empty($phone))? $phone: ''?>">

                </div>

              </div>



              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label for="projectinput5"><?=lang('Skype_id')?></label>

                  <input class="form-control square"  name="skype_id"  type="text" value="<?=(!empty($skype_id))? $skype_id: ''?>">

                </div>

              </div>



              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label for="projectinput5"><?=lang("whatsapp_number")?></label>

                  <input class="form-control square"  name="what_asap"  type="text" value="<?=(!empty($what_asap))? $what_asap: ''?>">

                </div>

              </div>



              <div class="col-md-6 col-sm-6 col-xs-6">

                <div class="form-group">

                  <label for="projectinput5"><?=lang('Address')?></label>

                  <input class="form-control square" name="address" type="text" value="<?=(!empty($address))? $address: ''?>">

                  <small class="text-primary"><?=lang("note_if_you_dont_want_add_more_information_then_leave_these_informations_fields_empty")?></small>

                </div>

              </div>

              

              <div class="col-md-12 col-sm-12 col-xs-12">

                <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?=lang('Save')?></button>

              </div>

            </div>

          </div>

          <div class="">

          </div>

        </form>

      </div>

    </div>

  </div>  
  <?php } ?>
  <?php

    if (!empty($ids)) {

  ?>
    <?php if(in_array("payments",$permission_array) || is_super_admin()){?>
  <div class="col-md-6">

    <div class="card">

      <div class="card-header">

        <h3 class="card-title"><?=lang("Add_Funds")?></h3>

        <div class="card-options">

          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>

          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>

        </div>

      </div>

      <div class="card-body">

        <form class="form actionForm" action="<?=cn($module."/ajax_update_fund/$ids")?>" data-redirect="<?=cn($module)?>" method="POST">

          <div class="form-group">

            <label for="projectinput5"><?=lang("Funds")?></label>

            <input class="form-control square" name="funds" type="text" value="<?=(!empty($user->balance))? $user->balance: 0 ?>">

          </div>

          <div class="">

            <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?=lang("Submit")?></button>

          </div>

        </form>

      </div>

    </div>

  </div>
    <?php }?>
  <?php }?>

</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div type="button" class="close" data-dismiss="modal" aria-label="Close"></div>
      </div>
	  <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="modal-btn-si"><a href="https://09.192.run/assets/uploads/users/d645920e395fedad7bbbed0eca3fe2e0/Capture5.PNG" download="">Download</a></button>
        
      </div>
    </div>
  </div>
</div>


<script src="<?=BASE?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css"/>
<style>
    .multiselect-container>li>a>label {
        padding: 4px 20px 3px 20px;
      }
</style>
<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
<script>
  $(function() {

    $('#user_permission').multiselect({
		nonSelectedText: "None selected",
        includeSelectAllOption: true

    });

});
</script>
    <?php }else{ ?>
<script>
  $(function() {

    $('#user_permission').multiselect({
		nonSelectedText: "لم يتم تحديد أي شيء", 
		includeSelectAllOption: true
    });
	
	/* $('.multiselect').on('click', function() {
    $('a.multiselect-all > label:contains("Select all")').text(' ').append('dddd');
	console.log(src);
    //$('#articleFullText').val($('#articleFullText').val() + src);
    }); */

});
</script>
    
    <?php } ?>

<script>
  $(function() {

    $('#user_permission').multiselect({
        includeSelectAllOption: true,
		

    });
    $('img.d-block').click(function(){
		  $img=$(this).get(0).outerHTML;
		  $imglink=$(this).attr('src');		  
		  $type=$(this).attr('id');
		  $namety=$(this).parents('.form-group').find('.fl_name').text();
		  if($type=='doc'){
			
			$imglink='<?=$filepdf?>'+$namety;
			$("#mi-modal").find('.modal-body').empty().append($img+'</br><p class="imgp">Please Download Document to View</p>');
		     
		  }else if($type=='pdf'){
			  
			  $imglink='<?=$filepdf?>'+$namety;			
			  $("#mi-modal").find('.modal-body').css('height','400px').empty().append('<embed type="application/pdf" src="'+$imglink+'" width="100%" height="100%">');
		      			  
		  }else{
			  $("#mi-modal").find('.modal-body').empty().append($img);
		    
		  }
		$("#mi-modal").find('.modal-footer #modal-btn-si a').attr('href',$imglink);
		$("#mi-modal").modal().show();
	})
});
</script>