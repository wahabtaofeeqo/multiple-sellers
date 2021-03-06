<style>
.multiselect-container .input-group{
	margin:0px !important;
}
.seller_permission_area .dropdown-menu {
   
    width: 300px !important;
}
.seller_permission_area .btn-default{
	width: 300px !important;
}
button.multiselect-clear-filter{
	display:none !important;
}
</style>
<div id="main-modal-content">
    <div class="modal-right">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <?php
                $id = (!empty($second_sub_category->id)) ? $second_sub_category->id : '';

                if ($id != "") {

                    $url = cn($module . "/ajax_update_second_sub_category/$id");

                } else {

                    $url = cn($module . "/ajax_update_second_sub_category");

                }


                ?>
                <form class="form actionForm" action="<?=$url?>" data-redirect="<?=cn($module)?>" method="POST">
                    <div class="modal-header bg-pantone">
                        <h4 class="modal-title"><i class="fa fa-edit"></i>Update Second Sub Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row justify-content-md-center">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label ><?=lang('Name')?></label>
                                         <input type="text" id="target" class="form-control square"  name="name" value="<?=(!empty($second_sub_category->name))? $second_sub_category->name: ''?>">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label ><?=lang('Category')?></label>
                                        <select name="cateegory_id" class="form-control square main_cate">
                                            <?php foreach( $categories as $category){?>
                                                <option value="<?=$category->id?>"><?=$category->name?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label ><?=lang('Sub Category')?></label>
                                        <select name="sub_category_id" class="form-control square" id="sub_cateegory_id">
                                            <?php foreach( $sub_categories as $category){?>
                                                <option <?php if($category->id==$sub_category->sub_cat_id){ ?> selected <?php }?> value="<?=$category->id?>"><?=$category->name?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="eventRegInput1"><?=lang("Default_sorting_number")?></label>
                                        <input type="number" class="form-control square" name="sort"  value="<?=(!empty($second_sub_category->sort))? $second_sub_category->sort: ''?>">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label><?=lang("Status")?></label>
                                        <select name="status" class="form-control square">
                                            <option value="1" <?=(!empty($second_sub_category->status) && $second_sub_category->status == 1) ? 'selected' : ''?>><?=lang("Active")?></option>
                                            <option value="0" <?=(isset($second_sub_category->status) && $second_sub_category->status != 1) ? 'selected' : ''?>><?=lang("Deactive")?></option>
                                        </select>
                                    </div>
                                </div>
								<?php if(is_super_admin()){?>
									<div class="col-md-12 col-sm-12 col-xs-12 seller_permission_area">
									   <label for=""><?=lang('multiseller_permission')?></label>
									</div>
								   <div class="col-md-12 col-sm-12 col-xs-12 seller_permission_area">
									   <div class="form-group">
										   
										   <select  id="seller_permission" name="seller_permission[]" class="form-control square" multiple="multiple">
											   <?php
											  
											   $muti_arr=explode(',', $second_sub_category->seller_permission);
											   
											   foreach($mSellers as $seller){
												 
												   ?>
												  <option value="<?=$seller['id']?>" <?=in_array($seller['id'],$muti_arr)?"selected=\"selected\"":""?>> <?=$seller['first_name'].'  '.$seller['last_name']?></option>
												 
											   <?php }?>
										   </select>

										 </div>
									 </div> 
								<?php }?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label><?=lang("Description")?></label>
                                        <textarea rows="3" id="editor" class="form-control square" name="desc" placeholder="About Project"><?=(!empty($second_sub_category->desc))? $second_sub_category->desc: ''?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?=lang("Submit")?></button>
                        <button type="button" class="btn round btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><?=lang("Cancel")?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?=BASE?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

<script>
    CKEDITOR.replace( 'editor', {
        height: 100
    });
</script>

<script>
	dropdowLoad();
	function dropdowLoad() { 
	   setTimeout(function(){
		$("#target").trigger('click');
		 //$('#seller_permission').val([]).multiselect('refresh')
	   },100);
	};

	$(document).on("click", ".actionForm", function(){

		$('#seller_permission').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,
			includeSelectAllOption: true
		});
		  
	  
	});
    $(function(){
        $('.datepicker').datepicker({
            autoclose: true,
            startDate: truncateDate(new Date())
        });
        $(".datepicker").datepicker().datepicker("setDate", new Date());

        function truncateDate(date) {
            return new Date(date.getFullYear(), date.getMonth(), date.getDate());
        }
    });
	$('.main_cate').change(function () {
		var cate =$(this).val();
		_action     = "<?=cn($module)?>/category/GetSubCat";
		_data       = $.param({token:token,cate:cate});
		$.post( _action, _data, function(_result){
			$('#sub_cateegory_id').html(_result);
		});

  }) 
</script>