<?php

$lang_current = get_lang_code_defaut();
?>
<style>
input[name="attach_file"] {
	padding: 4px 5px;
	border: 1px solid #e0e0e0;
}
.file_ups
{   
    left:12px;
    position: absolute;
    background: #fff;
    border: 1px solid #dedede;
    font-family: inherit;
}
@media only screen and (max-width: 500px) {
	
	.file_ups{
		margin-left:0px;
		  width:111px;
	}
}
<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>

<?php }else{ ?>

.file_ups
{ 
    right: 11px !important;
    width: 95px;
    margin: 0px;
    left: auto;
}
#add_edit_service #profile_image {
    direction: rtl;
}
@media only screen and (max-width: 500px) {
	
	.file_ups{

		  width:111px;
	}
}
<?php } ?>

</style>

<div class="row justify-content-md-center justify-content-xl-center" id="result_ajaxSearch">

  <div class="col-md-10 col-xl-10 ">

    <div class="card">

      <div class="card-header d-flex align-items-center">

        <div class="tabs-list">

          <ul class="nav nav-tabs">

            <li class="">

              <a class="active show" data-toggle="tab" href="#new_order"><i class="fa fa-clone"></i> <?=lang("single_order")?></a>

            </li>

            <li>

              <a data-toggle="tab" href="#mass_order"><i class="fa fa-sitemap"></i> <?=lang("mass_order")?></a>

            </li>

          </ul>

        </div>

      </div>

      <div class="card-body">

        <div class="tab-content">

          <div id="new_order" class="tab-pane fade in active show">
            <form class="form actionFormCustom" action="<?=cn($module."/ajax_add_order")?>" data-redirect="<?=cn($module)?>" method="POST">
              <div class="row">

                <div class="col-md-6">

                  <div class="content-header-title">

                    <h6><i class="fa fa-shopping-cart"></i> <?=lang('add_new')?></h6>

                  </div>

                  <div class="form-group">

                    <label><?=lang("Category")?></label>
                    <select name="category_id" id="category_id" class="form-control square ajaxChangeCategory_custom"  data-url="<?=cn($module."/order/get_sub_categories_by_cat/")?>">
                      <option> <?=lang("choose_a_category")?></option>

                      <?php

                        if (!empty($categories)) {



                          foreach ($categories as $key => $category) {

                      ?>

                      <option value="<?=$category->id?>"><?=$category->name?></option>

                      <?php }}?>

                    </select>

                  </div>
                   
                  <div class="form-group" id="result_onChangesubcat">
                    <label><?=lang("sub_cat")?></label>
                    <select name="sub_cate_id" id="sub_cate_id" class="form-control square ajaxChangesub_cate" data-url="<?=cn($module."/order/get_second_sub_categories_by_cat/")?>">
                      <option value=""> <?=lang("choose_a_sub_category")?></option>
                      <?php
                        if (!empty($subcategories)) {
                          $service_item_default = $subcategories[0];
                          foreach ($subcategories as $key => $subcategory) {
                      ?>
                      <option value="<?=$subcategory->id?>" ><?=$subcategory->name?></option>
                      <?php }}?>
                    </select>
                  </div>
                  <div class="form-group" id="result_onChangesecondsubcat">
                    <label><?=lang("second_sub_cat")?></label>
                    <select name="second_sub_cate_id" id="second_sub_cate_id" class="form-control square ajaxChangesecondsub_cate" data-url="<?=cn($module."/order/get_services_by_second_sub_cat/")?>">
                      <option> <?=lang("choose_a_second_sub_category")?></option>
                      <?php
                        if (!empty($second_subcategories)) {
                          $service_item_default = $subcategories[0];
                          foreach ($second_subcategories as $key => $second_subcategory) {
                      ?>
                      <option value="<?=$second_subcategory->id?>" ><?=$second_subcategory->name?></option>
                      <?php }}?>
                    </select>
                  </div>
                  <div class="form-group" id="result_onChange">

                    <label><?=lang("order_service")?></label>

                    <select name="service_id" class="form-control square ajaxChangeService" data-url="<?=cn($module."/order/get_service/")?>">

                      <option> <?=lang("choose_a_service")?></option>

                      <?php

                        if (!empty($services)) {

                          $service_item_default = $services[0];

                          foreach ($services as $key => $service) {

                      ?>

                      <option value="<?=$service->id?>" ><?=$service->name?></option>

                      <?php }}?>

                    </select>

                  </div>
                 
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label><?=lang("Description")?></label>
                          <textarea rows="3" id="editor" class="form-control square" name="desc"></textarea>
						  <label for="myfile" class="btn file_ups"><?=lang("Choose File")?></label>
                          <input type="file" id="myfile"  name="attach_file">
                        </div>
                    </div>
                  <div class="form-group order-default-quantity">

                    <label><?=lang("Quantity")?></label>

                    <input class="form-control square ajaxQuantity" name="quantity" type="number">

                  </div>

                  

                  <div class="form-group order-comments d-none">

                    <label for=""><?=lang("Comments")?></label>

                    <input type="text" class="form-control input-tags ajax_custom_comments" name="comments" value="good pic,great photo,:)">

                  </div> 



                  <div class="form-group order-comments-custom-package d-none">

                    <label for=""><?=lang("Comments")?></label>

                    <input type="text" class="form-control input-tags" name="comments_custom_package" value="good pic,great photo,:)">

                  </div>



                  <div class="form-group order-usernames d-none">

                    <label for=""><?=lang("Usernames")?></label>

                    <input type="text" class="form-control input-tags" name="usernames" value="usenameA,usenameB,usenameC,usenameD">

                  </div>



                  <div class="form-group order-usernames-custom d-none">

                    <label for=""><?=lang("Usernames")?></label>

                    <input type="text" class="form-control input-tags ajax_custom_lists" name="usernames_custom" value="usenameA,usenameB,usenameC,usenameD">

                  </div>



                  <div class="form-group order-hashtags d-none">

                    <label for=""><?=lang("hashtags_format_hashtag")?></label>

                    <input type="text" class="form-control input-tags" name="hashtags" value="#goodphoto,#love,#nice,#sunny">

                  </div>



                  <div class="form-group order-hashtag d-none">

                    <label for=""><?=lang("Hashtag")?> </label>

                    <input class="form-control square" type="text" name="hashtag">

                  </div>



                  <div class="form-group order-username d-none">

                    <label for=""><?=lang("Username")?></label>

                    <input class="form-control square" name="username" type="text">

                  </div>   

                  

                  <!-- Mentions Media Likers -->

                  <div class="form-group order-media d-none">

                    <label for=""><?=lang("Media_Url")?></label>

                    <input class="form-control square" name="media_url" type="link">

                  </div>



                  <!-- Subscriptions  -->

                  <div class="row order-subscriptions d-none">



                    <div class="col-md-6">

                      <div class="form-group">

                        <label><?=lang("Username")?></label>

                        <input class="form-control square" type="text" name="sub_username">

                      </div>

                    </div>



                    <div class="col-md-6">

                      <div class="form-group">

                        <label><?=lang("New_posts")?></label>

                        <input class="form-control square" type="number" placeholder="<?=lang("minimum_1_post")?>" name="sub_posts">

                      </div>

                    </div>



                    <div class="col-md-6">

                      <div class="form-group">

                        <label><?=lang("Quantity")?></label>

                        <input class="form-control square" type="number" name="sub_min" placeholder="<?=lang("min")?>">

                      </div>

                    </div>

                    <div class="col-md-6">

                      <div class="form-group">

                        <label>&nbsp;</label>

                        <input class="form-control square" type="number" name="sub_max" placeholder="<?=lang("max")?>">

                      </div>

                    </div>



                    <div class="col-md-6">

                      <div class="form-group">

                        <label><?=lang("Delay")?> (<?=lang("minutes")?>)</label>

                        <select name="sub_delay" class="form-control square">

                          <option value="0"><?=lang("")?><?=lang("No_delay")?></option>

                          <option value="5">5</option>

                          <option value="10">10</option>

                          <option value="15">15</option>

                          <option value="30">30</option>

                          <option value="60">60</option>

                          <option value="90">90</option>

                        </select>

                      </div>

                    </div>



                    <div class="col-md-6">

                      <div class="form-group">

                        <label><?=lang("Expiry")?></label>

                        <div class="input-group">

                          <input type="text" class="form-control datepicker" name="sub_expiry" onkeydown="return false" name="expiry" placeholder="" id="expiry">

                          <span class="input-group-append">

                            <button class="btn btn-info" type="button" onclick="document.getElementById('expiry').value = ''"><i class="fe fe-trash-2"></i></button>

                          </span>

                        </div>

                        </div>

                    </div>



                  </div>

                  <?php

                    if (get_option("enable_drip_feed","") == 1) {

                  ?>

                  <div class="row drip-feed-option d-none">

                    <div class="col-md-12">

                      <div class="form-group">

                        <div class="form-label"><?=lang("dripfeed")?> 

                          <label class="custom-switch">

                            <span class="custom-switch-description m-r-20"><i class="fa fa-question-circle" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?=lang("drip_feed_desc")?>" data-title="<?=lang("what_is_dripfeed")?>"></i></span>



                            <input type="checkbox" name="is_drip_feed" class="is_drip_feed custom-switch-input" data-toggle="collapse" data-target="#drip-feed" aria-expanded="false" aria-controls="drip-feed">

                            <span class="custom-switch-indicator"></span>

                          </label>

                        </div>

                      </div>



                      <div class="row collapse" id="drip-feed">

                        <div class="col-md-6">

                          <div class="form-group">

                            <label><?=lang("Runs")?></label>

                            <input class="form-control square ajaxDripFeedRuns" type="number" name="runs" value="<?=get_option("default_drip_feed_runs", "")?>">

                          </div>

                        </div>

                        <div class="col-md-6">

                          <div class="form-group">

                            <label><?=lang("interval_in_minutes")?></label>

                            <select name="interval" class="form-control square">

                              <?php

                                for ($i = 1; $i <= 60; $i++) {

                                  if ($i%10 == 0) {

                              ?>

                              <option value="<?=$i?>" <?=(get_option("default_drip_feed_interval", "") == $i)? "selected" : ''?>><?=$i?></option>

                              <?php }} ?>

                            </select>

                          </div>

                        </div>

                        <div class="col-md-12">

                          <div class="form-group">

                            <label><?=lang("total_quantity")?></label>

                            <input class="form-control square" name="total_quantity" type="number" disabled>

                          </div>

                        </div>

                      </div>

                    </div>

                  </div>

                  <?php }?>

                  <div class="form-group" id="result_total_charge">

                    <input type="hidden" name="total_charge" value="0.00">

                    <input type="hidden" name="currency_symbol" value="<?=get_option("currency_symbol", "")?>">

                    <p class="btn btn-info total_charge"><?=lang("total_charge")?> <span class="charge_number">$0</span></p>

                    

                    <?php

                      $user = $this->model->get("balance, custom_rate", 'general_users', ['id' => session('uid')]);

                      if ($user->custom_rate > 0 ) {

                    ?>

                    <p class="small text-muted"><?=lang("custom_rate")?>: <span class="charge_number"><?=$user->custom_rate?>%</span></p>

                    <?php }?>

                    <div class="alert alert-icon alert-danger d-none" role="alert">

                      <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i><?=lang("order_amount_exceeds_available_funds")?>

                    </div>

                  </div>

                  <div class="form-group">

                    <label class="custom-control custom-checkbox">

                      <input type="checkbox" class="custom-control-input" name="agree">

                      <span class="custom-control-label"><?=lang("yes_i_have_confirmed_the_order")?></span>

                    </label>

                  </div>



                  <div class="form-actions left">

                    <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">

                      <?=lang("place_order")?>

                    </button>



                  </div>

                </div>  



                <div class="col-md-6" id="order_resume">

                  <div class="content-header-title">

                    <h6><i class="fa fa-shopping-cart"></i> <?=lang("order_resume")?></h6>

                  </div>

                  <div class="row" id="result_onChangeService">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                      <div class="form-group">

                        <label><?=lang("service_name")?></label>

                        <input type="hidden" name="service_id" id="service_id" value="<?=(!empty($service_item_default->id))? $service_item_default->id :''?>">

                        <input class="form-control square" name="service_name" type="text" value="<?=(!empty($service_item_default->name))? $service_item_default->name :''?>" disabled>

                      </div>

                    </div>   



                    <div class="col-md-4  col-sm-12 col-xs-12">

                      <div class="form-group">

                        <label><?=lang("minimum_amount")?></label>

                        <input class="form-control square" name="service_min" type="text" value="<?=(!empty($service->min))? $service->min :''?>" id="min_amount" disabled>

                      </div>

                    </div>



                    <div class="col-md-4  col-sm-12 col-xs-12">

                      <div class="form-group">

                        <label><?=lang("maximum_amount")?></label>

                        <input class="form-control square" name="service_max" type="text" value="<?=(!empty($service->max))? $service->max :''?>" id="max_amount" disabled>

                      </div>

                    </div>



                    <div class="col-md-4  col-sm-12 col-xs-12">

                      <div class="form-group">

                        <label><?=lang("price")?></label>

                        <input class="form-control square" name="service_price" type="text" value="" disabled>

                      </div>

                    </div>



                    <div class="col-md-12 col-sm-12 col-xs-12">

                      <div class="form-group">

                        <label for="userinput8"><?=lang("Description")?></label>

                        <textarea  rows="10" name="service_desc" class="form-control square" disabled>

                        </textarea>

                      </div>

                    </div>



                  </div>

                </div>

              </div>

            </form>

          </div>

          <div id="mass_order" class="tab-pane fade">

            <form class="form actionForm" action="<?=cn($module."/ajax_mass_order")?>" data-redirect="<?=cn($module."/log")?>" method="POST">

              <div class="x_content row">

                <div class="col-md-6 col-sm-12 col-xs-12">

                  <div class="content-header-title">

                    <h6> <?=lang("one_order_per_line_in_format")?></h6>

                  </div>

                  <div class="form-group">

                    <textarea id="editor" rows="14" name="mass_order" class="form-control square" placeholder="service_id|quantity|link"></textarea>

                  </div>

                  <div class="form-group">

                    <label class="custom-control custom-checkbox">

                      <input type="checkbox" class="custom-control-input" name="agree">

                      <span class="custom-control-label"><?=lang("yes_i_have_confirmed_the_order")?></span>

                    </label>

                  </div>

                </div>

                <div class="col-md-6 col-sm-12 col-xs-12">

                  <div class="mass_order_error" id="result_notification">

                    <div class="content-header-title">

                      <h6><i class="fa fa-info-circle"></i> <?=lang("note")?></h6>

                    </div>

                    <div class="form-group">

                      <?=lang("here_you_can_place_your_orders_easy_please_make_sure_you_check_all_the_prices_and_delivery_times_before_you_place_a_order_after_a_order_submited_it_cannot_be_canceled")?>

                    </div>

                  </div>

                </div>

              </div>

              <div class="form-actions left">

                <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">

                  <?=lang("place_order")?>

                </button>

              </div>

            </form>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>
<script src="<?=BASE?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script>


var sub_id=0;
var sec_sub_id=0;
var ser_id=0;
  $(function(){

    $('.datepicker').datepicker({

      format: "dd/mm/yyyy",

      autoclose: true,

      startDate: truncateDate(new Date())

    });

    $(".datepicker").datepicker().datepicker("setDate", new Date());



    function truncateDate(date) {

      return new Date(date.getFullYear(), date.getMonth(), date.getDate());

    }



    $('.input-tags').selectize({

        delimiter: ',',

        persist: false,

        create: function (input) {

            return {

                value: input,

                text: input

            }

        }

    });
    
    
       // callback ajaxChangeCategory
        $(document).on("change", ".ajaxChangeCategory_custom" , function(event){
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
					
					if(sub_id!=0){
						
					  $(".ajaxChangesub_cate").val(sub_id).change();
					}
					
                }, 100);
            });
			
			 _action_sr='<?=cn($module."/order/get_services/")?>' +_id;
			$.post( _action_sr, _data,function(_result_sr){
                setTimeout(function () {
                    $("#result_onChange").html(_result_sr);
					if(sub_id!=0){
					   getService();
					}
                }, 100);
            }); 
        });  
        $(document).on("change", ".ajaxChangesub_cate" , function(event){
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
					if(sec_sub_id!=0){
					  $(".ajaxChangesecondsub_cate").val(sec_sub_id).change();
					}
                }, 100);
            });
			
			_action_sr='<?=cn($module."/order/get_services_by_sub_cat/")?>' +_id;
			$.post( _action_sr, _data,function(_result_sr){
                setTimeout(function () {
					
					$("#result_onChange").html(_result_sr);
					if(sec_sub_id!=0){
						getService();
					}
					
                }, 100);
            });
        });  
        $(document).on("change", ".ajaxChangesecondsub_cate" , function(event){
            event.preventDefault();
            $("#new_order .drip-feed-option").addClass("d-none");
            if ($("#order_resume").length > 0) {
                $("#order_resume input[name=service_name]").val("");
                $("#order_resume input[name=service_min]").val("");
                $("#order_resume input[name=service_max]").val("");
                $("#order_resume input[name=service_price]").val("");
                $("#order_resume textarea[name=service_desc]").val("");
                $("#order_resume #service_desc").val("");
            }
            _that       = $(this);
            _id         = _that.val();
            if (_id == "") {
                return;
            }
            _action     = _that.data("url") + _id;
            _data       = $.param({token:token});
			var datas=new FormData();	
            $.post( _action, _data,function(_result){
                setTimeout(function () {
					
                    $("#result_onChange").html(_result);
					if(ser_id!=0){
					     getService();
					}
					
                }, 100);
				
				
            });
			
			
        });  
  });
  CKEDITOR.replace( 'editor', {
    height: 200
  });
  
  var id='<?php echo $_GET["id"] ?>';
  if(id!=''){
     loadData();
  }
 
  function loadData(){
  
    var id='<?php echo $_GET["id"] ?>';
	
	 var data=new FormData();
	 data.append('token', token);
	 data.append('id', id);
	 $.ajax({
				url:'<?=cn($module."/getAll_values")?>',
				method: "post",
				processData: false,
				contentType: false,
				cache: false,
				data: data,
				dataType: 'JSON',
				success: function (_result) {					
					setTimeout(function () {	
						$("#category_id").val($.trim(_result.cate_id)).change();
						if($("#category_id").val()==''){
							location.reload();
						}
						sub_id=$.trim(_result.sub_cat_id);
						sec_sub_id=$.trim(_result.second_sub_cat_id);
						ser_id=id;
						
						if((sub_id==0)&&(sec_sub_id==0)){
						     getService();
						}
						
					}, 100);
				}
                
     });
}

function getService(){
	
	if(ser_id!=0){
		
		_data       = $.param({token:token});
		_action_sr='<?=cn($module."/order/get_service/")?>' +ser_id;
		$.post( _action_sr, _data,function(_result_sr){
			setTimeout(function () {
			
				$("#result_onChangeService").html(_result_sr);
				$('.ajaxChangeService option[value='+ser_id+']').attr('selected','selected');
				
			}, 100);
		}) 				  
	}
}
</script>

