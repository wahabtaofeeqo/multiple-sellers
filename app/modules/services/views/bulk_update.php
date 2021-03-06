<?php 
$lang_current = get_lang_code_defaut();
echo $lang_current->code;
?>
<style>
<?php if(!empty($lang_current) && $lang_current->code == 'en'){ ?>

<?php }else{ ?>
.modal-title{
	width:100%;
}
    
<?php } ?>
</style>
	<div id="main-modal-content">
  <div class="modal-right">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <?php
            $url = cn($module."/ajax_bulk_update");
        ?>
        <form class="form actionFormCustomService" action="<?=$url?>" data-redirect="<?=cn($module)?>" method="POST">
          <div class="modal-header bg-pantone">
            <h4 class="modal-title"><i class="fa fa-edit"></i> <?=lang("edit_service")?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <div class="form-body" id="add_edit_service">
              <div class="row justify-content-md-center">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label><?=lang("choose_a_category")?></label>
                    <select  name="category" id="catgory" class="form-control square">
                        <option value=""> <?=lang("choose_a_category")?></option>
                        <?php if(!empty($categories)){
                          foreach ($categories as $key => $category) {
                        ?>
                        <option value="<?=$category->id?>"><?=$category->name?></option>
                     <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label><?=lang("choose_a_sub_category")?></label>
                    <select  name="sub_category" id="sub_category" class="form-control square">
                        <option value=""> <?=lang("choose_a_category")?></option>
                      <?php if(!empty($sub_categories)){
                        foreach ($sub_categories as $key => $sub) {
                      ?>
                      <option value="<?=$sub->id?>" class="sub_class cat_<?=$sub->cat_id?>"><?=$sub->name?></option>
                     <?php }}?>
                    </select>
                  </div>
                </div>
				<div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" id="result_onChangesecondsubcat">
                    <label><?=lang("second_sub_cat")?></label>
                    <select name="second_sub_cate_id" id="second_sub_cate_id" class="form-control square ajaxChangesecondsub_cate" data-url="<?=cn($module."/order/get_services_by_second_sub_cat/")?>">
                       <option value=""> <?=lang("choose_a_second_sub_category")?></option>
                      <?php if(!empty($second_subcategories)){
                        foreach ($second_subcategories as $key => $secsub) {
                      ?>
                       <option value="<?=$secsub->id?>" class="sub_classs cat_<?=$secsub->cat_id?>"><?=$secsub->name?></option>
                     <?php }}?>
                    </select>
                  </div>
                 </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label><?=lang("minimum_amount")?></label>
                    <input type="number" class="form-control square" name="min" value="">
                  </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label><?=lang("maximum_amount")?></label>
                    <input type="number" class="form-control square" name="max" value="">
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label><?=lang("Price")?></label>
                    <input type="text" class="form-control square" name="price" value="">
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label><?=lang("Description")?></label>
                    <textarea rows="3" id="editor" class="form-control square" name="desc"></textarea>
                    <input type="file" id="myfile"  name="attach_file">
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

<script>
$(function() {
	 setTimeout(function() {	
	$("#catgory").val($.trim($('#m_cateid').val())).change();
	$('#sub_category').val($.trim($('#sub_cateid').val())).change();
	$('#second_sub_cate_id').val($.trim($('#sec_sub_cateid').val())).change();
	}, 500);
});

$(document).on('change', '#category', function(){  
  console.log( alert( this.value ));
  cate_id=this.value;
  $('.sub_class').hide();
  $('.cat_'+cate_id).hide();
});

<?php if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
	  CKEDITOR.replace( 'editor', {

    height: 300

  });

<?php }else{ ?> 
  CKEDITOR.replace( 'editor', {
contentsLangDirection: 'rtl',
    height: 300

  });
<?php } ?>
</script>