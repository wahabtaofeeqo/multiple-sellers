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
.multiselect-container>li>a>label {
        padding: 4px 20px 3px 20px;
      }
</style>

<div id="main-modal-content">

  <div class="modal-right">

    <div class="modal-dialog modal-lg" role="document">

      <div class="modal-content">

        <?php

          $ids = (!empty($category->ids))? $category->ids: '';

          if ($ids != "") {

            $url = cn($module."/ajax_update/$ids");

          }else{

            $url = cn($module."/ajax_update");

          }

        ?>

        <form class="form actionForm" action="<?=$url?>" data-redirect="<?=cn($module)?>" method="POST">

          <div class="modal-header bg-pantone">

            <h4 class="modal-title"><i class="fa fa-edit"></i> <?=lang("edit_category")?></h4>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            </button>

          </div>

          <div class="modal-body">

            <div class="form-body">

              <div class="row justify-content-md-center">

                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="form-group">

                    <label ><?=lang('Name')?></label>

                    <input type="text" class="form-control square"  id="target" name="name" value="<?=(!empty($category->name))? $category->name: ''?>">

                  </div>

                </div> 

                

                <div class="col-md-6 col-sm-6 col-xs-6">

                  <div class="form-group">

                    <label for="eventRegInput1"><?=lang("Default_sorting_number")?></label>

                    <input type="number" class="form-control square" name="sort"  value="<?=(!empty($category->sort))? $category->sort: ''?>">

                  </div>

                </div>



                <div class="col-md-6 col-sm-6 col-xs-6">

                  <div class="form-group">

                    <label><?=lang("Status")?></label>

                    <select name="status" class="form-control square">

                      <option value="1" <?=(!empty($category->status) && $category->status == 1) ? 'selected' : ''?>><?=lang("Active")?></option>

                      <option value="0" <?=(isset($category->status) && $category->status != 1) ? 'selected' : ''?>><?=lang("Deactive")?></option>

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
							  
							   $muti_arr=explode(',', $category->seller_permission);
                               
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

                    <textarea rows="3" id="editor" class="form-control square" name="desc" placeholder="About Project"><?=(!empty($category->desc))? $category->desc: ''?></textarea>

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


<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>


<script src="<?=BASE?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>


<style>
    .multiselect-container>li>a>label {
        padding: 4px 20px 3px 20px;
      }
</style>
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
contentsLangDirection: 'rtl',
    height: 150

  });
<?php; } ?>
</script>



<script>

dropdowLoad();
function dropdowLoad() { 
   setTimeout(function(){
    $("#target" ).trigger('click');
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

</script>