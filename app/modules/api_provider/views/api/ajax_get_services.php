<?php if(!empty($services)){
?>
<?php
  $api_id   = (!empty($api_id))? $api_id: '';
  $api_ids  = (!empty($api_ids))? $api_ids: '';
  
?>
<style>
    .table-responsive{
	    border-top: 1px solid #e4e4e4;
	}
	.td-hd{
		display:none;
	}
	.card-table tr:first-child th:nth-child(2),.card-table tr:first-child th:nth-child(4),.card-table tr:first-child th:nth-child(9){
		display:none;
	}
	.all_chk{
		padding: 1px 35px;
	}
	.catN{
		padding:3% 2% 1% 2%;
	}
	.syn_lb{
		padding: 8px 5px;
	}
	.syn_dr{
		padding:0px 45px 0px 5px;
	}
</style>
<div class="col-md-12 col-xl-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><?=lang("Lists")?></h3>
      <?php 
        if ($api_ids != "") {
      ?>
      <div class="card-options">
	    <div class="syn_lb"><label><?=lang("synchronous_request")?></label></div>
	    <div class="syn_dr">			
			<select  name="api_ids" class="form-control order_by ajaxChange" data-url="<?=cn($module."/ajax_api_provider_services/")?>">
			  <option value=""><?=lang("Select")?></option>
			  <option value="<?=$api_ids.'_'.'All'?>"><?=lang("All")?></option>
			  <option value="<?=$api_ids.'_'.'curr'?>"><?=lang("current_service")?></option>
			  <option value="<?=$api_ids.'_'.'nSer'?>"><?=lang("New Service")?></option>
            </select>
		</div>
	    <div class="d-none">
			<a href="<?=cn($module."/bulk_services/$api_ids")?>" class="ajaxModal btn btn-pill btn-info btn-sm"><span class="mr-1"><i class="fe fe-plus-square"></i></span><?=lang("bulk_add_all_services")?>
			</a>
        </div>
		
      </div>
      <?php } ?>
    </div>
	<div class="all_chk"><div class="custom-controls-stacked">
		  <label class="custom-control custom-checkbox">
			<input type="checkbox" name="chk_all" value=" " class="custom-control-input check-all-sevices">
			<span class="custom-control-label">Select All</span>
		  </label>
		</div>
		</div>
		<?php 
		$liste = array();
		 foreach ($services as $key => $row) {
			 if(!in_array($row->category, $liste, true)){
				array_push($liste, $row->category);
			}
		 }
		?>
		
		<?php $i=0;
   		foreach ($liste as $keys => $category) {
		?>
		<div class="catN"><h4><?=$category?></h4></div>
		<div class="container-fluid">
	       
	    <div class="table-responsive">
	
	  
      <table class="table table-hover table-bordered table-vcenter card-table" id="table_cat">
        <thead>
          <tr>
            <!--<th class="text-center w-1"><?=lang("No_")?></th>-->
			<th class="text-center w-1">
			 <div class="custom-controls-stacked">
				  <label class="custom-control custom-checkbox">
					<input type="checkbox" name="chk_cat" value="" class="custom-control-input check-all">
					<span class="custom-control-label"></span>
				  </label>
				</div>
			</th>
            <?php if (!empty($columns)) {
              foreach ($columns as $key => $row) {
            ?>
            <th><?=$row?></th>
            <?php }}?>
            
            <?php
              if (get_role("admin")) {
            ?>
            <th><?=lang("Action")?></th>
            <?php }?>
          </tr>
		  
        </thead>
		
        <tbody>
		
		  <?php if (!empty($services)) {
            
            foreach ($services as $key => $row) {
           
			$i=$key;
			$txtdesc=$row->desc;
            if(isset($row->desc)){
                $desc=html_entity_decode(strip_tags($row->desc));
            }else{
                $desc="";
            }
			if($row->category!=$category) {
				$i=$key;
								{ continue;}
			}
			
          ?>
		  
		  
          <tr class="tr_<?=$row->service?>">
           <!--<td  class="text-center"><?=$i?></td>-->
			<td>
				<div class="custom-controls-stacked">
				  <label class="custom-control custom-checkbox">
					 <input type="checkbox" name="chk_cur" value="" class="custom-control-input check-alls">
					<span class="custom-control-label"></span>
				  </label>
				</div>
			</td>
            <td class="td-hd">
                <div class="title"><?=$row->service?></div>
            </td>
            <td class=""><?=$row->name?> </td>
            <td class="td-hd"><?=$row->category?> </td>
            <td><?=$row->rate?></td>
            <td><?=$row->min?> / <?=$row->max?></td>
            <td><?= $desc?></td>
            <td class=""><?=($row->dripfeed == 1)? lang("Active") : lang("Deactive")?> </td>
            <td class="txtb td-hd"><?=$txtdesc?></td>
			<td class="text-center td-hd">
              <div class="item-action dropdown getbx">
                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a href="<?=cn("$module/add_service/")?>" data-serviceid="<?=$row->service?>" data-category="<?=$row->category?>" data-name="<?=$row->name?>" data-min="<?=$row->min?>" data-max="<?=$row->max?>" data-price="<?=$row->rate?>" data-type="<?=$row->type?>" data-dripfeed="<?=$row->dripfeed?>" data-api_provider_id="<?=$api_id?>" class="ajaxAddService dropdown-item"><i class="dropdown-icon fe fe-plus-square"></i> <?=lang("add_update_service")?></a>
                </div>
              </div>
            </td>
          </tr>
		  
		 
		 <?php }}?>
		 
		 
        </tbody>
        
      </table>
	  
    </div></div>
	 <?php }?>
  </div>
</div>
<?php }else{?>
<div class="col-md-12 data-empty text-center">
  <div class="content">
    <img class="img mb-1" src="<?=BASE?>assets/images/ofm-nofiles.png" alt="empty">
    <div class="title"><?=lang("look_like_there_are_no_results_in_here")?></div>
  </div>
</div>
<?php }?>

<div id="modal-add-service" class="modal fade" tabindex="-1">
  <div id="main-modal-content">
    <div class="modal-right">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          
          <form class="form actionForm" action="<?=cn($module."/ajax_add_api_provider_service")?>" method="POST">
            <div class="modal-header bg-pantone">
              <h4 class="modal-title"><i class="fa fa-edit"></i><?=lang("add_update_service")?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body">
              <div class="form-body">
                <div class="row justify-content-md-center">
				
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <label ><?=lang("Name")?></label>
                      <input type="text" class="form-control square" name="name">
                      <input type="hidden" class="form-control square" name="service_id">
                      <input type="hidden" class="form-control square" name="api_provider_id">
                      <input type="hidden" class="form-control square" name="dripfeed">
                      <input type="hidden" class="form-control square" name="type">
                    </div>
                  </div>
                                  
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <label><?=lang("choose_a_category")?></label>
                      <select  name="category" class="form-control square">
                        <?php if(!empty($categories)){
                          foreach ($categories as $key => $category) {
                        ?>
                        <option value="<?=$category->id?>" <?=(!empty($service->ids) && $category->id == $service->cate_id)? 'selected': ''?> ><?=$category->name?></option>
                       <?php }}?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                      <label><?=lang("minimum_amount")?></label>
                      <input type="number" class="form-control square" name="min">
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                      <label><?=lang("maximum_amount")?></label>
                      <input type="number" class="form-control square" name="max">
                    </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <label><?=lang("Price")?></label>
                      <input type="text" class="form-control square" name="price" disabled>
                      <input type="hidden" class="form-control square" name="price">
                    </div>
                  </div>
                  
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <label><?=lang("price_percentage_increase")?> <?=sprintf(lang('auto_rounding_to_X_decimal_places'), get_option("auto_rounding_x_decimal_places", 2))?></label>
                      <select name="price_percentage_increase" class="form-control square">
                        <?php
                          for ($i = 0; $i <= 1000; $i++) {
                        ?>
                        <option value="<?=$i?>" <?=(get_option("default_price_percentage_increase", 30) == $i)? "selected" : ''?>><?=$i?>%</option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="is_convert_to_new_currency">
                        <span class="custom-control-label">Auto convert to new currency with currency rate like in <a href="<?=cn("setting")."?t=currency"?>" target="_blank">Currency Setting page</a></span>
                      </label>
                    </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <label><?=lang("Description")?></label>
                      <textarea rows="3" id="editor" class="form-control square" name="desc"></textarea>
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
</div>

<script src="<?=BASE?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script>
  CKEDITOR.replace( 'editor', {
    height: 100
  });
  
  
</script>
<script>

$(document).ready(function(){
	var check=0;
	var arrservice=[];
	
	$('.check-all').click(function() {		
		
		if($(this).prop("checked")==true){
			
			$(this).parents('table').find('.check-alls').prop('checked', this.checked);
			$(this).val(1);
			$(this).parents('table').find('.check-alls').val(1);
            
             arrservice=[];
			$('input:checkbox').each(function() { 
			   if($(this).prop('checked')==true){
				   
				 	arrservice.push($(this).parents('tr').find('td:nth-child(2)').text());
			   }
			
			})
			/*	$(this).parents('table').find(".check-alls").each(function() {
					
					if($(this).val()=='1'){
					  arrservice.push($(this).parents('tr').find('td:nth-child(2)').text());
					}
				});*/
			check=1;			
			
		}else{
			
			$(this).parents('table').find('.check-alls').prop('checked', this.checked);
			
			$(this).val(0);
			$(this).parents('table').find('.check-alls').val(0);
			 arrservice=[];
			$('input:checkbox').each(function() { 
			   if($(this).prop('checked')==true){
				   
				 	arrservice.push($(this).parents('tr').find('td:nth-child(2)').text());
			   }
			
			})
				/* $('.check-alls').each(function() { 
				    arrservice=[];
					if($(this).val()==''){	 */
						/* arrservice.push($(this).parents('tr').find('td:nth-child(2)').text()); */
						/*var val=$(this).parents('tr').find('td:nth-child(2)').text()
						 arrservice = jQuery.grep(arrservice, function(value) {
							return value != val;
						}); */
					/* }
					
				}); */
			check=1;
		}
               
    });
	
	$('.check-alls').click(function() {
		
		if($(this).prop("checked")==true){			
			$(this).val(2);
			check=2;
			
			/*$(this).parents('table').find('.check-alls').each(function() {
				
				if($(this).val()=='2'){
					arrservice.push($(this).parents('tr').find('td:nth-child(2)').text());
				}
			});*/
			arrservice=[];
			$('input:checkbox').each(function() { 
			   if($(this).prop('checked')==true){
				   
				 	arrservice.push($(this).parents('tr').find('td:nth-child(2)').text());
			   }
			
			})
			check=2;
			
		}else{
			$(this).attr("checked", false);
			check=0;
			$(this).val(0);
			/* $(this).parents('table').find('.check-alls').each(function() {
				
				var val=$(this).parents('tr').find('td:nth-child(2)').text();
				arrservice = jQuery.grep(arrservice, function(value) {
					return value != val;
				});
			}); */
			arrservice=[];
			$('input:checkbox').each(function() { 
			   if($(this).prop('checked')==true){
				   
				 	arrservice.push($(this).parents('tr').find('td:nth-child(2)').text());
			   }
			
			})
			check=2;
		}
               
    });
	
	$('.check-all-sevices').click(function() {
		 if($(this).prop("checked")==true){
			 
			$('input:checkbox').prop('checked', this.checked);
			$(this).val(3);
			check=3;
			arrservice=[];				
		}else{
			$('input:checkbox').prop('checked', this.checked);
			$(this).val(0);
			check=0;
			arrservice=[];
		} 
    });
	
	$('.ajaxModal').click(function() {
		setInterval(function(){ 
			$('#chekopt').val(check);
			$('#s_opt').val(arrservice);
				
		}, 1000);
	});
	
})
</script>
<script>
		  
	$('.getbx').click(function(event) {
         event.preventDefault();		
		CKEDITOR.instances.editor.setData($(this).parents('tr').find('td.txtb').text());
	});
		  
</script>















