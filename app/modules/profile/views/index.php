<div class="page-header">
  <h1 class="page-title">
    <?=lang('Your_account')?>
  </h1>
</div>
<?php
$lang_current = get_lang_code_defaut();
?>
<style>
#profile_image{
	margin-top: 5px;
}
#myProgress {
  width: 100%;
  background-color: #ddd;
}

#myBar {
  width: 10%;
  height: 30px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
}

#uploadProgressBar{
	 width: 0%;
    background-color: #033ca5;
    border: 1px solid #d4d4d4;
    height: 20px;
}

#status,#loaded_n_total{
	width:100%;
    height: 18px;
}
#mid_area{
	text-align:center;
	margin:2px 0px;
}
#mid_area div{
	 margin:3px 0px 3px 0px;
	 word-break: break-all;
}
#mid_area .d-block{
	display: inline-block !important;
	height: 97px;
    width: 100%;
	
}
#mid_area .video-fluid{
	height: 100%;
    width: 100%;
	 overflow:hidden;
}
#main_d{
	width: 100%;
    height:85px;
    overflow: hidden;
	background-color: #d8d8d8;
}
#mid_area div:nth-child(1){
    border-radius: 7px;
    border: 1px solid #eaeaea;
	margin: 0px;
}
#mid_area span i:after{
	content:"x";
}
#mid_area span i{
	padding-left: 5px;
}
input[name="profile_image"]{
	padding: 4px 5px;
	border: 1px solid #e0e0e0;
}
.file_up
{   
    left: 0px;
    position: absolute;
    background: #fff;
    border: 1px solid #dedede;
    font-family: inherit;
	margin-top:5px;
}
#frm_media{
    margin-left: 10%;
}
@media only screen and (max-width: 500px) {
	
	.file_up
	{   
     width:111px;
	}
	 #mid_area{
		 
		width: 50%;
        float: left;

	 }
	#main_d{
		width: 100%;
		height: auto;
		overflow: hidden;
		background-color: #d8d8d8;
	}
	
	 #mid_area .d-block{
		display: inline-block !important;
		height: 100%;
		width: 100%;
	
	}
	
}
<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>

<?php; }else{ ?>

.card-title{
	width:100%;
}
.file_up
{ 
	right: 0px !important;
    float: right !important;
    width: 95px;
    left: auto;
    margin-top: 4px;
}

 #profile_image {
    direction: rtl;
}
@media only screen and (max-width: 500px) {
	
	.file_up
	{   
     width:111px;
	}
	
}
<?php; } ?>
</style>
<div class="row">
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
        <form class="form actionForm" action="<?=cn($module."/ajax_update")?>" data-redirect="<?=cn($module)?>" method="POST">
          <div class="form-body">
            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="projectinput5"><?=lang("first_name")?></label>
                  <input class="form-control square" name="first_name" type="text" value="<?=(!empty($user->first_name))? $user->first_name: ''?>">
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="userinput5"><?=lang("last_name")?></label>
                    <input class="form-control square" name="last_name" type="text" value="<?=(!empty($user->last_name))? $user->last_name: ''?>">
                  </div>
              </div> 

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="projectinput5"><?=lang('Email')?></label>
                  <input class="form-control square" name="email" type="email" value="<?=(!empty($user->email))? $user->email: ''?>">
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
                  <label for="projectinput5"><?=lang('Password')?></label>
                  <input class="form-control square" name="password" type="password">
                  <small class="text-primary"><?=lang("note_if_you_dont_want_to_change_password_then_leave_these_password_fields_empty")?></small>
                </div>
              </div> 

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="projectinput5"><?=lang('Confirm_password')?></label>
                  <input class="form-control square" name="re_password" type="password">
                </div>
              </div>
              
              <div class="col-md-12 col-sm-12 col-xs-12 form-actions">
                <div class="p-l-10">
                  <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?=lang('Save')?></button>
                </div>
              </div>
            </div>
          </div>
          <div class="">
          </div>
        </form>
      </div>
    </div>
  </div> 
<?php if(get_role("admin") ||  get_role("supporter")){ ?>
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
        <form class="form actionForm" action="<?=cn($module."/ajax_update_more_infors")?>" data-redirect="<?=cn($module)?>" method="POST">
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
              <div class="col-md-12 col-sm-12 col-xs-12 form-actions left">
                <div class="p-l-10">
                  <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?=lang("Save")?></button>
                </div>
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
        <h3 class="card-title"><?=lang('your_api_key')?></h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>
      <div class="card-body">
        <form class="form actionForm" action="<?=cn($module."/ajax_update_api")?>" data-redirect="<?=cn($module)?>" method="POST">
          <div class="form-group">
            <label> <?=lang('Key')?></label>
            <div class="input-group">
              <input type="text" name="api_key" class="form-control square" value="<?=(!empty($user->api_key))? $user->api_key: ''?>">
            </div>
          </div>
          <div class="">
            <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?=lang("Generate_new")?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php } ?> 
   <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?=lang('Upload Verification Files')?></h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>
      <div class="card-body">
	   <form id="Form1" action="<?=cn($module."/ajax_files")?>" method="post" enctype="multipart/form-data"></form>
        <form class="form actionForm" action="" data-redirect="<?=cn($module)?>" method="POST">
          <div class="form-group">
            <label> <?=lang('Upload Files')?></label>
            <div class="input-group">
                <label for="profile_image" class="btn file_up"><?=lang("Choose File")?></label> 
				<input type="file" id="profile_image" name="profile_image" form="Form1"/>
				<input type="hidden" id="dir" name="dir" value="" form="Form1"/>
				<input type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1" id="frm_media" value="<?=lang('Upload Files')?>" form="Form1"/>
				
				
				
            </div>
			<div class="input-group" id="br_pro">
					<div id="uploadProgressBar"></div>
					<div id="status"></div>
					<div id="loaded_n_total"></div> 
			</div>
			<div class="input-group" id="hold_image">
			<?php 
				if(!empty($files)){
					
					foreach ($files as $key => $mediarow) {
					
					$urls='https://'.$mediarow->file_path;
					$doc=base_url()."assets/images/doc.png";
					$pdf=base_url()."assets/images/pdf.png";	
            ?>
			<div class="col-md-4" id="mid_area">
			<?php if($mediarow->type=='pdf'){ ?>
				<div id="main_d">
					<div class="video-fluid">
					 <img class="d-block" style="width:75%" src="<?=$pdf?>">
					</div>
								
				</div>
				<div>
					 <span><?=$mediarow->name?><i class="rm_img"></i>
					 </span>
				</div>
			<?php }else if($mediarow->type=='doc'){ ?>
				<div id="main_d">
					<div class="video-fluid">
					 <img class="d-block" style="width:75%" src="<?=$doc?>">
					</div>
								
				</div>
				<div>
					 <span><?=$mediarow->name?><i class="rm_img"></i>
					 </span>
				</div>
			<?php }else{ ?>
				<div id="main_d">
					<div class="video-fluid">
					 <img class="d-block" src="<?=$urls?>">
					</div>
								
				</div>
				<div>
					 <span><?=$mediarow->name?><i class="rm_img"></i>
					 </span>
				</div>
			<?php }?>	
			</div>
			
			<?php }}?>
			</div>
          </div>
          <div class="">
            <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1" style="visibility:hidden"><?=lang("Save")?></button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        Delete
      </div>
	  <div class="modal-body">Are you sure you want to delete ?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="modal-btn-si">Cancel</button>
        <button type="button" class="btn btn-primary" id="modal-btn-no">Delete</button>
      </div>
    </div>
  </div>
</div>
<script>

	
	var image_='';
	var folder_ ='';
	var state=null;
    $('#Form1').on('submit',(function(e) {
  
        e.preventDefault();
        _that       = $(this);
        _action     = _that.attr("action");
        _data       = _that.serializeArray();
		
		
        var data=new FormData();
        $.each(_data, function (key, input) {
            data.append(input.name, input.value);
        });
        
        var file_data = $('input[name="profile_image"]')[0].files;
		
        if (typeof file_data[0] !== 'undefined') {
			
			var flodersi=file_data[0]["size"];
            if(flodersi >20971520){
                
                setTimeout(function(){
                    notify('<?=lang("Unsupported_File_Size")?>','error');
                },1500);
                return false;
            }
			
			
			image_=file_data[0]["name"];
        }
		for (var i = 0; i < file_data.length; i++) {
            data.append("profile_image[]", file_data[i]);
        }
       
        data.append('token', token);
						
		$.ajax({
			url: _action,
			method: "post",
			processData: false,
			contentType: false,
			data: data,
			dataType: 'JSON',
			xhr: function () {
				 var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress",
					uploadProgressHandler,
					false
				);
				xhr.addEventListener("load", loadHandler, false);
				xhr.addEventListener("error", errorHandler, false);
				xhr.addEventListener("abort", abortHandler, false);

				return xhr; 
			}					
		});
							
					 
    })); 
    
	function uploadProgressHandler(event) {
        $("#loaded_n_total").html("<?=lang('Uploaded')?>" + event.loaded + "<?=lang('bytes_of')?>" + event.total);
        var percent = (event.loaded / event.total) * 100;
        var progress = Math.round(percent);        
        $("#uploadProgressBar").css("width", progress + "%");
        $("#status").html(progress + "<?=lang('uploaded')?>... <?=lang('please_wait')?>");
    }

    function loadHandler(event) {
       
        var obj = JSON.parse(event.target.responseText);		
			for(var i=0; i< obj.length; i++){
				
				if(obj[i].msg=='success'){					
					$("#uploadProgressBar").css("width", "0%");
					$("#status,#loaded_n_total").html("");
					$link='https://'+obj[i].link;
					var html='';
					if(obj[i].type=='doc'){
						html='<div class="col-md-4" id="mid_area">'+
						'<div id="main_d">'+
						'<div class="video-fluid">'+
							'<img class="d-block" style="width:75%" src="<?=base_url()?>assets/images/doc.png">'+
						'</div>'+
						'</div>'+
						'<div><span>'+image_+'<i class="rm_img"></i></span></div></div>';
					
					}else if(obj[i].type=='pdf'){
						html='<div class="col-md-4" id="mid_area">'+
						'<div id="main_d">'+
						'<div class="video-fluid">'+
							'<img class="d-block" style="width:75%" src="<?=base_url()?>assets/images/pdf.png">'+
						'</div>'+
						'</div>'+
						'<div><span>'+image_+'<i class="rm_img"></i></span></div></div>';
					}else{
						html='<div class="col-md-4" id="mid_area">'+
						'<div id="main_d">'+
						'<div class="video-fluid">'+
							'<img class="d-block" src="'+$link+'">'+
						'</div>'+
						'</div>'+
						'<div><span>'+image_+'<i class="rm_img"></i></span></div></div>';
					}	
						
					$('#hold_image').append(html);	
					notify("<?=lang('Image_Upload_success')?>", "success");	
				}else{
				    $("#uploadProgressBar").css("width", "0%");
					$("#status,#loaded_n_total").html("");
					notify("<?=lang('Image_Upload_Failed')?>", "error");
					
				}			
			}
			
    }

    function errorHandler(event) {
		
       notify("<?=lang('Image_Upload_Failed')?>", "error");
		$('#frm_media').hide();	
    }

    function abortHandler(event) {
		
        notify("<?=lang('Image_Upload_Aborted')?>", "error");
		$('#frm_media').hide();	
    }

    $(document).on("click", ".rm_img" , function(){
            event.preventDefault();
			_that=$(this).parent('span');
			_thatPar=$(this).parents('#mid_area');
		    var data=new FormData();
			data.append('image', $(this).parent('span').text());
			data.append('token', token);
			 
			
			$("#mi-modal").modal().show();
			
            $(document).on("click",'#modal-btn-si,#modal-btn-no', function(){
				if($(this).attr('id')=='modal-btn-no'){
					$("#mi-modal").modal().hide();
					
					$.ajax({
						url:'<?=cn($module."/remove_files")?>',
						method: "post",
						processData: false,
						contentType: false,
						data: data,
						dataType: 'JSON',
						success: function (_result) {
							
							var len = _result.length;
							for(var i=0; i<len; i++){
								
								if(_result[i].msg=='success'){
									_that.remove();
									_thatPar.remove();
									
									$("#mi-modal").modal('hide');
								}
							}
						
						}
					});
				}else{
					$("#mi-modal").modal('hide');
				}		
			})
			
					
    });

</script>