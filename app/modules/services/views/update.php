<?php 
  $lang_current=get_lang_code_defaut();
  $mediacrop=cn($module."/cropImg");
?>
 <style>
#profile_image,#myfile{
  text-indent: -1000px;
}
.crp_area img {
    max-width: unset;
}
#hold_image{
  padding: 2% 0% 10% 0%
}
#hold_image span{
  float: none;
    padding: 0px 5px;
    margin: 2px;
    cursor: pointer;
  font-size: 12px;
}
#hold_image i{
  padding-left: 5px;
}

#profile_image{
  border: 1px solid #d2d2d2; 
}

#media_m{
  padding: 5px 0px;
}
#hold_image span i:after{
  content:"x";
}
 
 #mi-modal .modal-footer{
  padding: 5px 2px; 
 }
 
 #mi-modal .btn {
  padding: 2px;
    width: 50px; 
 }
 #mi-modal .modal-content{
  border: 1px solid #cecece; 
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
#br_pro{
  padding: 10px 0px;
}
.modal{
  overflow: scroll !important;  
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
#frm_media{
  display:none;
}
.cpci{
  float:right;
}
#slider{
  width:100%;
}
input[name="profile_image"],input[name="attach_file"] {
  padding: 4px 5px;
  border: 1px solid #e0e0e0;
}
.sld_area{
  padding: 13px 10px;
}
.crp_area{
  width:300px;
  height:300px;
  position:relative;
  overflow:hidden;
  background: #000;
  margin:auto;
}
#crp_img{
   height:auto;
   width:300px;
}
.mn_sld_area{
  width:100%;
}
.ui-widget.ui-widget-content{
  border: 1px solid #bbbbbb !important;
  top: 10px !important;
}
.ui-slider-horizontal .ui-slider-handle{
  top: -0.5em !important;
  border-radius: 7px !important;
}
.ui-slider .ui-slider-handle{
  width: 1em !important;
    height: 1em !important;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active{
  width: 1em !important;
    height: 1em !important;
  top: -0.5em !important;
  border-radius: 7px !important;
}
.ui-slider-horizontal {
    height: .1em !important;
}
.ui-state-active,
.ui-widget-content .ui-state-active,
.ui-widget-header .ui-state-active,
a.ui-button:active,
.ui-button:active,
.ui-button.ui-state-active:hover {
  border:none;
  background: #000 !important;
  font-weight: normal !important;
  color: #000 !important;
  border-radius: 7px !important;
}
.ui-icon-background,
.ui-state-active .ui-icon-background {
  border: #000 !important;
  background-color: #000 !important;
  border-radius: 7px !important;
}
.ui-state-active a,
.ui-state-active a:link,
.ui-state-active a:visited {
  color: #000 !important;
  text-decoration: none !important;
  border-radius: 7px !important;
}
.ui-slider .ui-slider-handle{
  border-radius: 7px !important;
}
.file_up,.file_ups
{   
    left: 0px;
    position: absolute;
    background: #fff;
    border: 1px solid #dedede;
    font-family: inherit;
}
.file_ups{
  left:13px;
}
@media only screen and (max-width: 500px) {
    .btn-min-width {
        min-width: 4.5rem;
    }
    a.btn-min-width {
        width:100%;
    }
    #mid_area{
    width:50%;
  }
  .d-block{
    height:auto;
  }
  #main_d{
    height:auto;
  }
  .file_up,.file_ups
  {   
     width:111px;
  }
  .file_ups{
    margin-left:0px;
    
  }
    
}
<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
.sld_area{
  padding: 13px 10px;
  text-align:center;
}
.sld_btn{
 padding: 7px 10px;
}
<?php; }else{ ?>

.emoji-picker-icon{ 
  right: 95% !important;  
}
.cpci{
    float:left;
}
.modal-title{
  width:100%;
}
.file_up,.file_ups
{   
    width:94px;
    right: 0px;
    position: absolute;
    background: #fff;
    border: 1px solid #dedede;
    font-family: inherit;
}
.file_ups{
  margin-right:13px;
    
}
.mn_sld_area{
  text-align: right;
} 
.sld_area{
  padding: 10px 0px;
}
#crp_img{
  float:left;
}
@media screen and (max-width: 600px) {  
#slider{
    width: 70%;
    text-align: right;
    float: right;
}
.sld_btn{
  text-align: left;
    margin-top: -15px;
}

#image-modal .modal-body{
  overflow: hidden;
}
#frm_media {
    float: left;
    margin-left: 0px;
}
#profile_image{
  width:200px;
}
}

<?php; } ?>
    
  
</style>

<link rel="stylesheet" href="<?=BASE?>assets/css/jquery-ui.css">
<script src="<?=BASE?>assets/js/jquery-ui.js"></script> 
<script src="<?=BASE?>assets/js/jquery.ui.touch-punch.min.js"></script>
<div id="main-modal-content">

  <div class="modal-right">

    <div class="modal-dialog modal-lg" role="document">

      <div class="modal-content">

        <?php

          $ids = (!empty($service->id))? $service->id: '';

          if ($ids != "") {

            $url = cn($module."/ajax_update/$ids");

          }else{

            $url = cn($module."/ajax_update");

          }
     
      $mediaurl=cn($module."/ajax_media/");
      $mediaurl_delete=cn($module."/remove_media/");
      $fileExs=cn($module."/fileExs/");
        if(empty($drsize)){
        $drsize=0;
        }
      $baseurl=base_url();
        ?>
    <form id="Form1" action="<?=$mediaurl?>" method="post" enctype="multipart/form-data"></form>
    
        <form class="form actionFormCustom" action="<?=$url?>" data-redirect="" method="POST">
          <div class="modal-header bg-pantone">

            <h4 class="modal-title"><i class="fa fa-edit"></i> <?=lang("edit_service")?></h4>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            </button>

          </div>

          <div class="modal-body">

            <div class="form-body" id="add_edit_service">

              <div class="row justify-content-md-center">

                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="form-group emoji-picker-container">

                    <label ><?=lang("package_name")?></label>

                    <input type="text"  data-emojiable="true" class="form-control square" name="name" value="<?=(!empty($service->name))? $service->name: ''?>">

                  </div>

                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="form-group">

                    <label><?=lang("choose_a_category")?></label>
                    <?php if(get_role("admin") ||  get_role("supporter")){ ?>
                    <select name="category" class="form-control square ajaxChangeCategory_custom"  data-url="<?=cn("/order/get_sub_categories_by_cat/")?>">
                        <option value=""> <?=lang("choose_a_category")?></option>
                      <?php if(!empty($categories)){
                        $lang_current = get_lang_code_defaut();
                        foreach ($categories as $key => $category) {
              
                            if($category->lang === $lang_current->code ){
              
                      ?>

                      <option value="<?=$category->id?>" <?=(!empty($service->ids) && $category->id == $service->cate_id)? 'selected': ''?> ><?=$category->name?></option>

            <?php }}}?>

                    </select>
          <?php }?>
          
          <?php if(get_role("m-seller")){ ?>
                    <select name="category" class="form-control square ajaxChangeCategory_custom"  data-url="<?=cn("/order/get_sub_categories_by_cat/")?>">
                        <option value=""> <?=lang("choose_a_category")?></option>
                      <?php if(!empty($categories)){
                        $lang_current = get_lang_code_defaut();
                        foreach ($categories as $key => $category) {              
              $muti_arr=explode(',', $category->seller_permission);
                            if($category->lang === $lang_current->code ){
              if(in_array(session('uid'),$muti_arr)){
                      ?>

                      <option value="<?=$category->id?>" <?=(!empty($service->ids) && $category->id == $service->cate_id)? 'selected': ''?> ><?=$category->name?></option>

            <?php }}}}?>

                    </select>
          <?php }?>
                  </div>

                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" id="result_onChangesubcat">
                    <label><?=lang("sub_cat")?></label>
                    <select name="sub_cate_id" class="form-control square ajaxChangesub_cate" data-url="<?=cn($module."/order/get_second_sub_categories_by_cat/")?>">
                      <option> <?=lang("choose_a_sub_category")?></option>
                      <?php           
                        if (!empty($sub_categories)) {
                          $service_item_default = $sub_categories[0];
              
                          foreach ($sub_categories as $key => $subcategory) {
                
                      ?>
            <option value="<?=$subcategory->id?>" <?=(!empty($service->ids) && $subcategory->id == $service->sub_cat_id)? 'selected': ''?> ><?=$subcategory->name?></option>

            <?php }}?>
                    </select>
                  </div>
                 </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" id="result_onChangesecondsubcat">
                    <label><?=lang("second_sub_cat")?></label>
                    <select name="second_sub_cate_id" class="form-control square ajaxChangesecondsub_cate" data-url="<?=cn($module."/order/get_services_by_second_sub_cat/")?>">
                      <option> <?=lang("choose_a_second_sub_category")?></option>
                      <?php
                        if (!empty($second_subcategories)) {
                          foreach ($second_subcategories as $key => $secondsubcategory) {
               
                      ?>
            <option value="<?=$secondsubcategory->id?>" <?=(!empty($service->ids) && $secondsubcategory->id == $service->second_sub_cat_id)? 'selected': ''?> ><?=$secondsubcategory->name?></option>
            <?php }}?>
                    </select>
                  </div>
                 </div>
                <div class="col-md-6 col-sm-6 col-xs-6">

                  <div class="form-group">

                    <label><?=lang("minimum_amount")?></label>
        <?php if(get_role("m-seller")): ?>
                    <input type="number" class="form-control square" name="min" value="<?=(!empty($service->min))? $service->min :  get_option('default_min_order_'.session('uid'),"")?>">
                <?php else:?>
           <input type="number" class="form-control square" name="min" value="<?=(!empty($service->min))? $service->min :  get_option('default_min_order',"")?>">
               
        <?php endif; ?>
                  </div>

                </div>



                <div class="col-md-6 col-sm-6 col-xs-6">

                  <div class="form-group">

                    <label><?=lang("maximum_amount")?></label>
        <?php if(get_role("m-seller")): ?>
                    <input type="number" class="form-control square" name="max" value="<?=(!empty($service->max))? $service->max : get_option('default_max_order_'.session('uid'),"")?>">
        <?php else:?>
        <input type="number" class="form-control square" name="max" value="<?=(!empty($service->max))? $service->max : get_option('default_max_order',"")?>">
        <?php endif; ?>
                  </div>

                </div>



                <div class="col-md-6 col-sm-6 col-xs-6">

                  <div class="form-group">

                    <label><?=lang("Price")?></label>

                    <input type="text" class="form-control square" name="price" value="<?=(!empty($service->price))? $service->price: currency_format(get_option('default_price',"0.80"),2)?>">

                  </div>

                </div>



                <div class="col-md-6 col-sm-6 col-xs-6">

                  <div class="form-group">

                    <label><?=lang("Status")?></label>

                    <select name="status" class="form-control square">

                      <option value="1" <?=(!empty($service->status) && $service->status == 1)? 'selected': ''?>><?=lang("Active")?></option>

                      <option value="0" <?=(isset($service->status) && $service->status != 1)? 'selected': ''?>><?=lang("Deactive")?></option>

                    </select>

                  </div>

                </div>

      

                <div class="col-md-12">

                  <div class="form-group">

                    <label>Service type</label>

                    <select name="service_type" class="form-control square ajaxChangeServiceType">

                      <?php

                        $service_type_array = array(

                          'default'                 => lang('Default'),

                          'subscriptions'           => lang('Subscriptions'),

                          'custom_comments'         => lang('custom_comments'),

                          'custom_comments_package' => lang('custom_comments_package'),

                          'mentions_with_hashtags'  => lang('mentions_with_hashtags'),

                          'mentions_custom_list'    => lang('mentions_custom_list'),

                          'mentions_hashtag'        => lang('mentions_hashtag'),

                          'mentions_user_followers' => lang('mentions_user_followers'),

                          'mentions_media_likers'   => lang('mentions_media_likers'),

                          'package'                 => lang('package'),

                          'comment_likes'           => lang('comment_likes'),

                        );



                        foreach ($service_type_array as $type => $service_type) {

                      ?>



                      <option value="<?=$type?>" <?=(isset($service->type) && $service->type == $type)? 'selected': ''?>><?=$service_type?></option>

                      <?php } ?>

                    </select>

                  </div>

                </div>



                <div class="col-md-12 dripfeed-form <?=(isset($service->type) && $service->type != 'default')? 'd-none': ''?>">

                  <div class="form-group">

                    <label><?=lang("dripfeed")?></label>

                    <select name="dripfeed" class="form-control square">

                      <option value="0" <?=(isset($service->dripfeed) && $service->dripfeed != 1)? 'selected': ''?>><?=lang("Deactive")?></option>

                      <option value="1" <?=(!empty($service->dripfeed) && $service->dripfeed == 1)? 'selected': ''?>><?=lang("Active")?></option>

                    </select>

                  </div>

                </div>
        
        <div class="col-md-12 media-form">   
                <div class="form-group">
                    <label><?=lang("Media")?></label>
                    <?php 

                      $mediaUrl = ($service) ? $service->media_url : '';
                      $type = true;
                      if (isset($service->add_type) && $service->add_type == 'api') {
                        $type = false;
                      }
                    ?>
          <input type="hidden" id="dir" name="dir" value="<?= $mediaUrl ?>" form="Form1"/>

          <?php if($type):?>

          <div class="col-md-8" id="media_m">
            <label for="profile_image" class="btn file_up"><?=lang("Choose_File")?></label>
            <input type="file" id="profile_image" name="profile_image" form="Form1"/>
            
          </div>
          <div class="col-md-4" id="media_m">
              <input type="submit" id="frm_media" value="<?=lang("Upload")?>" form="Form1"/>
          
          </div>
          <div class="form-group" id="br_pro">
            <label><?=lang("Media_Capacity")?></label>
             <label class="cpci"><?=lang("20MB")?></label>  
              <div id="myProgress">
                 <div id="myBar"></div>
              </div>
            
          </div>
          <div class="form-group" id="br_pro">
            <div id="uploadProgressBar"></div>
            <div id="status"></div>
            <div id="loaded_n_total"></div> 
          </div>
          <?php endif;?>
             <div class="col-md-12" id="hold_image">
             <div class="row" id="img_sortable">
            <?php 
             
            if(!empty($media)) {
              foreach ($media as $key => $mediarow) {
              $url= $mediarow->file_path.'/'.$mediarow->name; 
                        ?>
            
                <div class="col-md-3" id="mid_area" >
              <?php if($mediarow->type==1){ ?>
                  <div id="main_d">
                <video class="video-fluid" controls>                    
                  <source src="<?=$url?>" type="video/mp4" />
                </video>
                </div>
                <div>
                   <span id="<?=$service->add_type?>"><?=$mediarow->name?><i class="rm_img"></i></span>
                </div>
                
              <?php }else{ ?>
                  <div id="main_d">
                  <div class="video-fluid">
                 <img class="d-block" src="<?=$url?>">
                </div>
                
                </div>
                <div>
                   <span id="<?=$service->add_type?>"><?=$mediarow->name?><i class="rm_img"></i>
                   </span>
                </div>
              <?php }?>
              </div>
              <?php }}?>
                        </div>
          </div>        
                </div>
                </div>
        <input type="hidden" id="dirm" name="dirm" value="<?=$mediaUrl?>"/>
        <input type="hidden" id="dirsize" name="dirsize" value="<?=$drsize?>"/>
        <input type="hidden" id="imgorder" name="imgorder" value=""/>
                <div class="col-md-12"> 

                  <div class="form-group">

                    <div class="form-label"><?=lang("Type")?></div>

                    <div class="custom-controls-stacked">

                      <label class="custom-control custom-radio custom-control-inline">

                        <input type="radio" class="custom-control-input" name="add_type" value="manual" <?=(isset($service->add_type) && $service->add_type == 'api')? '': 'checked'?>>

                        <span class="custom-control-label"><?=lang('Manual')?></span>

                      </label>

                      <label class="custom-control custom-radio custom-control-inline">

                        <input type="radio" class="custom-control-input" name="add_type" value="api" <?=(isset($service->add_type) && $service->add_type == 'api')? 'checked': ''?>>

                        <span class="custom-control-label"><?=lang('API')?></span>

                      </label>

                    </div>

                  </div>

                </div>



                <div class="col-md-12 service-type <?=(isset($service->add_type) && $service->add_type == 'api')? '' : 'd-none'?>">

                  <div class="row">

                    <div class="col-md-6">

                      <div class="form-group">

                        <label><?=lang("api_provider_name")?></label>

                        <select name="api_provider_id" class="form-control square">

                          <option value="0" <?=(isset($service->api_provider_id) && $service->api_provider_id == "")? 'selected': ''?>><?=lang("Manual")?></option>

                          <?php

                            if (!empty($api_providers)) {

                            foreach ($api_providers as $type => $api_provider) {

                          ?>

                          <option value="<?=$api_provider->id?>" <?=(isset($service->api_provider_id) && $service->api_provider_id == $api_provider->id)? 'selected': ''?>><?=$api_provider->name?></option>

                          <?php }} ?>

                        </select>

                      </div>

                    </div>

                    <div class="col-md-6">

                      <div class="form-group">

                        <label><?=lang("api_service_id")?></label>

                        <input type="text" class="form-control square" name="api_service_id" value="<?=(isset($service->api_service_id) && $service->api_service_id != "") ? $service->api_service_id: ''?>">

                      </div>

                    </div>

                  </div>

                </div>



                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="form-group">

                    <label><?=lang("Description")?></label>

                    <textarea rows="3" id="editor" class="form-control square" name="desc"><?=(!empty($service->desc))? html_entity_decode($service->desc, ENT_QUOTES): ''?></textarea>
                     <label for="myfile" class="btn file_ups"><?=lang("Choose_File")?></label>
           <input type="file" id="myfile"  name="attach_file">
                  </div>

                </div>

              </div>

            </div>
      <div class="alert" role="alert" id="result"></div>
            
      
          </div>

          <div class="modal-footer">

            <a href="<?=cn("api_provider/services")?>" class="btn round btn-info btn-min-width mr-1 mb-1"><?=lang("add_new_service_via_api")?></a>

            <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?=lang("Submit")?></button>

            <button type="button" class="btn round btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><?=lang("Cancel")?></button>

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
        <?=lang('Delete')?>
      </div>
    <div class="modal-body"><?=lang("Are_you_sure_you_want_to_delete")?> ?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="modal-btn-si"><?=lang('Cancel')?></button>
        <button type="button" class="btn btn-primary" id="modal-btn-no"><?=lang('Delete')?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="image-modal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row mn_sld_area">
        <div class='col-lg-2 col-md-2 col-sm-2 sld_area'><?=lang('Zoom')?></div>
        <div class='col-lg-8 col-md-8 col-sm-8 sld_area'><div id="slider"></div></div>
      <div class='col-lg-2 col-md-2 col-sm-2 sld_btn'><button type="button" class="btn btn-primary" id="crp_save"><?=lang('Save')?></button></div>
    </div>
    </div>      
      <div class="modal-body" >   
      <div class='crp_area'>
          <img id="crp_img" src="" >
      </div>
      </div>
      <div class="modal-footer">
     
        <button type="button" class="btn btn-default img_cr_cls"><?=lang('Close')?></button>
        
      </div>
    </div>
  </div>
</div>

<script src="<?=BASE?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>



<script>

  // Check post type

  $(document).on("change","input[type=radio][name=add_type]", function(){

    _that = $(this);

    _type = _that.val();

    if(_type == 'api'){

      $('.service-type').removeClass('d-none');

    }else{

      $('.service-type').addClass('d-none');

    }

  });



 

</script>

<?php 

$lang_current = get_lang_code_defaut();

?>
<script>


<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
    CKEDITOR.replace( 'editor', {

    height: 150

  });

<?php; }else{ ?> 
  CKEDITOR.replace( 'editor', {
    height: 200
  });
<?php; } ?>
</script>

<script>

 

  $(function() {

  var _URL = window.URL || window.webkitURL;
    $("#profile_image").change(function (e) {
      $('#frm_media').show();
    }); 

     window.emojiPicker = new EmojiPicker({
     emojiable_selector: '[data-emojiable=true]',
     assetsPath: "<?=BASE?>assets/plugins/emoji-picker/lib/img/",
     popupButtonClasses: 'fa fa-smile-o'

    });

    window.emojiPicker.discover();
    
     // callback ajaxChangeCategory
        $(document).on("change", ".ajaxChangeCategory_custom" , function(){
            event.preventDefault();
            _that       = $(this);
            _id         = _that.val();
            if (_id == "") {
                return;
            }
            _action     = _that.data("url") + _id;
            _data       = $.param({token:token});
            $.post( _action, _data,function(_result){
        
                setTimeout(function () {
                    $("#result_onChangesubcat").html(_result);
                }, 100);
            });
        });
        $(document).on("change", ".ajaxChangesub_cate" , function(){
            event.preventDefault();
            _that       = $(this);
            _id         = _that.val();
            if (_id == "") {
                return;
            }
            _action     = _that.data("url") + _id;
            _data       = $.param({token:token});
            $.post( _action, _data,function(_result){
                setTimeout(function () {
                    $("#result_onChangesecondsubcat").html(_result);
                }, 100);
            });
        });
        
    folderSi(); 
    //fileExists(); 

    

    
  });
  
  function folderSi(){
  
    var vl=$('#dirsize').val().split(' ');      
    var capacity=0;
    var mCap=20480;
    
    if(vl[1]=='KB'){
      vgb=(vl[0]);
      capacity=((vgb/mCap)*100);
      
    }else if(vl[1]=='MB'){
      capacity=((vl[0]*1024/(mCap))*100);   
      
    }else if(vl[1]=='GB'){
      vgb=(vl[0]/1024*1024*1024)
      capacity=((vgb/mCap)*100);
    }else{
      
    }
    
    $('#myBar').width(capacity +'%');
    $('#myBar').text(capacity.toFixed(1) +'%');
  }
  
  var image_='';
  var folder_ ='';
  var imPath='';
  var state=null;
  
  $('#Form1').on('submit',(function(e) {
   
        e.preventDefault();
        _that       = $(this);
        _action     = _that.attr("action");
        _data       = _that.serializeArray();
    _flodersize = $('#dirsize').val();
    
        var data=new FormData();
        $.each(_data, function (key, input) {
            data.append(input.name, input.value);
        });
        //File data
    
    var vl=$('#dirsize').val().split(' ');
    var capacity=0;
    
    if(vl[1]!=undefined){
      if(vl[1]=='KB'){
         capacity=(vl[0]/1024*1024*1024);
      }else if(vl[1]=='MB'){
        capacity=(vl[0]/1024*1024*1024);
      }else{
        capacity=(vl[0]/1024*1024*1024*1024)
        
      }
    }
    
        var file_data = $('input[name="profile_image"]')[0].files;
    
        if (typeof file_data[0] !== 'undefined') {
      if(capacity!=0){
        var flodersize=(capacity+file_data[0]["size"])*1024;
      
        if(flodersize < 20971520){
          
          setTimeout(function(){
            notify('<?=lang("Unsupported_File_Size")?>','error');
             
          },1500);
          return false;
        }
        
      }
      image_=file_data[0]["name"];
        }
    
    for (var i = 0; i < file_data.length; i++) {
            data.append("profile_image[]", file_data[i]);
        }
    data.append('token', token);
    
    var datas=new FormData();     
    var parts = $('#dir').val().split("/");
    if(parts.length > 1){
      folder_ = parts[parts.length-2];
    }else{
      folder_ = $('#dir').val();
    }
    
    datas.append('dir',folder_);
    datas.append('image',image_);
    datas.append('token', token);
    
       $.ajax({
        url:'<?=$fileExs?>',
        method: "post",
        processData: false,
        contentType: false,
        cache: false,
        data: datas,
        dataType: 'JSON',
        success: function (_result) {
          if(folder_!=''){
           for(var i=0; i<_result.length; i++){
            
            if(_result[i].success==1){
              
              notify("<?=lang('Image_already_Exsists')?>", "error");
            }else{
              
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
            }
              
          }
          }else{ 
          
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
          }
          
        }
      });
    })); 
  
    function uploadProgressHandler(event) {
        $("#loaded_n_total").html("<?=lang('Uploaded')?> " + event.loaded + " <?=lang('bytes_of')?> " + event.total);
        var percent = (event.loaded / event.total) * 100;
        var progress = Math.round(percent);        
        $("#uploadProgressBar").css("width", progress + "%");
        $("#status").html(progress + "% <?=lang('uploaded')?>... <?=lang('please_wait')?>");
    }

    function loadHandler(event) {
       var obj = JSON.parse(event.target.responseText);   
      for(var i=0; i< obj.length; i++){
        $('#dir,#dirm').val(obj[i].dir);
        if(obj[i].medType==1){
          
        var html='<div class="col-md-3" id="mid_area">'+
              '<div id="main_d">'+
                  '<video class="video-fluid" controls>'+
                     '<source src="'+obj[i].link+'" type="video/mp4" />'+
                   '</video>'+
                   '</div>'+
                        '<div>'+
                       '<span id="'+obj[i].medType+'">'+image_+'<i class="rm_img"></i>'+
                       '</span>'+
                    '</div>';
                    
          $('#hold_image .row').append(html);
          $('#dirsize').val(obj[i].fSize);
          folderSi(); 
          $('#frm_media').hide(); 
           notify("<?=lang('Image_Upload_success')?>", "success");  
        
        }else{  
          $('#dirsize').val(obj[i].fSize);
          imgName=image_;
          imPath=obj[i].link;
          $('#crp_img').attr('src',obj[i].link);
          $( "#slider" ).slider({
              value:$('#crp_img').width(),
              step: 1,
              min: 0,
              max:1200,
              slide: function(event, ui) {
                $('#crp_img').width(ui.value);
                
              }
          });
  
          $('#crp_img').draggable({}); 
          $("#image-modal").modal().show(); 
          
        }
      }
    $("#uploadProgressBar").css("width", "0%");
    $("#status,#loaded_n_total").html("");
    }

    function errorHandler(event) {
       
    notify("<?=lang('Image_Upload_Failed')?>", "error");  
    $('#frm_media').hide(); 
    }

    function abortHandler(event) {
        
    notify("<?=lang('Image_Upload_Aborted')?>", "error");
    $('#frm_media').hide(); 
    }
  
  $(".img_cr_cls").on('click',function(e) {   
    $('#image-modal').modal('hide');
  });
  
  $("#crp_save").on('click',function(e) {
    e.preventDefault();
    if(folder_==''){
       parts = $('#dir').val().split("/"),
       last_part = parts[parts.length-2];
       folder_=last_part;
    }
    _data = $.param({
          token: token,
          data: {
            imgWidth:$('#crp_img').width(),
            imgHeight:$('#crp_img').height(),
            imgTop:$('#crp_img').position().top,
            imgLeft:parseInt($('#crp_img').css('left')),
            imgName:imgName,
            dWidth:$('.crp_area').width(),
            dheight:$('.crp_area').height(),
            dir:folder_
            
          }
        });
    
    $.post('<?=$mediacrop?>', _data, function(_results) {   
    
            var html='<div class="col-md-3" id="mid_area">'+
                '<div id="main_d">'+
                '<div class="video-fluid">'+
                  '<img class="d-block" src="'+imPath.replace("temp/"+imgName,imgName)+'">'+
                '</div>'+
                '</div>'+
                '<div><span id="1">'+imgName+'<i class="rm_img"></i></span></div></div>';
          
        
        
          $('#hold_image .row').append(html);
          folderSi(); 
          $('#frm_media').hide(); 
          notify("<?=lang('Image_Upload_success')?>", "success"); 
    
    });
  });
  
    //rm_img
  $(document).on("click", ".rm_img" , function(){
            event.preventDefault();
      _that=$(this).parent('span');
      _thatPar=$(this).parents('#mid_area');
        var data=new FormData();
      data.append('image', $(this).parent('span').text());
      data.append('dir', $('#dir').val());
      data.append('service', $(this).parent('span').attr('id'));
      data.append('token', token);
       
      
      $("#mi-modal").modal().show();
      
            $(document).on("click",'#modal-btn-si,#modal-btn-no', function(){
        if($(this).attr('id')=='modal-btn-no'){
          $("#mi-modal").modal().hide();
          
          $.ajax({
            url:'<?=$mediaurl_delete?>',
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
                  $('#dirsize').val(_result[i].fSize);
                    folderSi();
                     $('.modal-backdrop').addClass('hide');
                }
              }
              
            }
          });
         }else{
          $("#mi-modal").modal('hide');
        }   
      })
      
          
    });
  
  
  $(document).ready(function() { 
        var img_arr=[]; 
    $("#img_sortable").sortable({
      start: function(event, ui) {
        //ui.item.toggleClass("highlight");
      },
      stop: function(event, ui) {
        //ui.item.toggleClass("highlight");
        img_arr=[];
        $('#img_sortable').find('#main_d img, #main_d source').each(function(){
          
          var imgageA=$(this).attr('src');
          img_arr.push(imgageA.substring(imgageA.lastIndexOf("/") + 1));
        })
        $('#imgorder').val(img_arr);
        
      }
      });
      $( "#img_sortable" ).disableSelection();
     });
  var img_arrs=[];  
   $(document).on("mouseout", ".d-block",function() {  
     $("#img_sortable" ).sortable({     
      stop: function(event, ui) { 
        img_arrs=[];
        $(this).find('#main_d img, #main_d source').each(function(){
          
          var imgageA=$(this).attr('src');
          img_arrs.push(imgageA.substring(imgageA.lastIndexOf("/") + 1));
        })
      }
    });
      $('#imgorder').val(img_arrs);
  $( "#img_sortable" ).disableSelection();
  });
  
</script>