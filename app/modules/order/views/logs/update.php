<?php
$lang_current = get_lang_code_defaut();

?>
<style>
input[name="myfile"] {
	padding: 4px 5px;
	border: 1px solid #e0e0e0;
	text-indent:-1000px;
}
.file_ups
{   
    left:12px;
    position: absolute;
    background: #fff;
    border: 1px solid #dedede;
    font-family: inherit;
}
#fileLabel{
	position: absolute;
    left: 18%;
    padding: 7px 0px;
    background: #fff;
    width: 28%;
}
@media only screen and (max-width: 500px) {
	
	.file_ups{
		margin-left:0px;
		  width:111px;
	}
}

<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>

<?php; }else{ ?>

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
<?php; } ?>

</style>
<div id="main-modal-content">
  <div class="modal-right">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <?php
          $ids = (!empty($order->ids))? $order->ids: '';
        ?>
		<form id="Form1" action="<?=cn($module."/media_update/$ids")?>" method="post" enctype="multipart/form-data"></form>
        <form class="form actionFor" action="<?=cn($module."/ajax_logs_update/$ids")?>" data-redirect="<?=cn($module."/log")?>" method="POST">
          <div class="modal-header bg-pantone">
            <h4 class="modal-title"><i class="fa fa-edit"></i> <?=lang("Edit_Order")?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <div class="form-body">
              <div class="row justify-content-md-center">

                <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label ><?=lang("order_id")?></label>
                    <input type="text" class="form-control square"  disabled value="<?=(!empty($order->id))? $order->id: ''?>">
                  </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label ><?=lang("api_orderid")?></label>
                    <input type="text" class="form-control square"  disabled value="<?=(!empty($order->api_order_id) && $order->api_order_id > 0)? $order->api_order_id: ''?>">
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label><?=lang("Type")?></label>
                    <input type="text" class="form-control square"  disabled value="<?=(!empty($order->api_order_id) && $order->api_order_id != 0 )? lang("API"): lang("Manual")?>">
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label ><?=lang("User")?></label>
                    <input type="text" class="form-control square" name="user_id" disabled value="<?=(!empty($order->uid))? get_field(USERS, ["id" => $order->uid], 'email'): ''?>">
                  </div>
                </div>
                
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label ><?=lang("Service")?></label>
                    <input type="text" class="form-control square" name="service_id" disabled value="<?=(!empty($order->service_id))? get_field(SERVICES, ["id" => $order->service_id], 'name'): ''?>">
                  </div>
                </div>  
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label ><?=lang("Quantity")?></label>
                    <input type="text" class="form-control square" name="quantity" disabled value="<?=(!empty($order->quantity))? $order->quantity : ''?>">
                  </div>
                </div>    

                <div class="col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label ><?=lang("Amount")?></label>
                    <input type="text" class="form-control square" name="charge" disabled value="<?=(!empty($order->charge))? $order->charge : ''?>">
                  </div>
                </div>
                
                <div class="col-md-4 col-sm-4 col-xs-4 " style="display:none">
                  <div class="form-group">
                  
                  </div>
                </div>
                 <input type="hidden" class="form-control square" id="attach_path" name="attach_path">
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label><?=lang("Status")?></label>
                    <select  name="status" class="form-control square">
                      <?php 
                        $order_status_array = order_status_array();
                        if(!empty($order_status_array)){
                        foreach ($order_status_array as $status) {
                      ?>
                      <option value="<?=$status?>" <?=(!empty($order->status) && $status == $order->status)? 'selected': ''?> ><?=order_status_title($status)?></option>
                     <?php }}?>
                    </select>
                  </div>
                </div>
				
				<div class="col-md-12 col-sm-12 col-xs-12">
				 <div class="form-group">

                        <label><?=lang("Description")?></label>

                        <textarea  rows="10" id="editor" name="order_desc" class="form-control square">
							<?=(!empty($order->comment))? html_entity_decode($order->comment, ENT_QUOTES): ''?>
                        </textarea>
						<label for="myfile" class="btn file_ups"><?=lang("Choose File")?></label>
                        <input type="file" id="myfile" value="fff" name="myfile" form="Form1">
						<?php if(isset($order->comment_link)){
							$fl_name=basename($order->comment_link)?>
						<label id="fileLabel"><?=$fl_name?></label>
							<?php }?>
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
<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
CKEDITOR.replace( 'editor', {
    height: 200
  });
<?php; }else{ ?>
CKEDITOR.replace( 'editor', {
    height: 200,
	contentsLangDirection:'rtl',
  });

<?php; } ?>
</script>


<script>

		$("#myfile").on('change',(function (e) {
			if($(this).val()!=''){
			   $("#Form1").submit();
			}
		})); 
		
		$('#Form1').on('submit',(function(e) {
			$('#fileLabel').hide();
			e.preventDefault();
			_that       = $(this);
			_action     = _that.attr("action");
			_data=_that.serializeArray();
			    var data=new FormData();
			
				$.each(_data, function (key, input) {
					data.append(input.name, input.value);
				});
		
		        var file_data = $('input[name="myfile"]')[0].files;
				
				for (var i = 0; i < file_data.length; i++) {
					data.append("myfile[]", file_data[i]);
				}
				
				data.append('token', token);
				
			    $.ajax({
			     url:_action,
			     type: "POST",
			     data:data,
			     contentType: false,
				 cache: false,
			     processData:false,			   
			     success: function(data){
					
				    
				 }
				          
			});
 }));
 
 
</script>
