<?php 

$lang_current = get_lang_code_defaut();

?>
<style>
.def_media .carousel-inner {
    position: relative;
    width: 90%;
    overflow: hidden;
    display: inline-block;
    float: none;
	height: 270px;
}
.def_media .d-block{
	display:inline-block !important;
}
.def_media{
	text-align:center;
	margin-top:5%;
}
.def_media .carousel-control-prev-icon{
	width: 20px;
    height: 20px;
	background-image: url('<?=BASE?>assets/images/left.png');
}
.def_media .carousel-control-prev{
	left: 1px;
    width: 5%;
	opacity: 1;
}

.def_media .carousel-control-next-icon{
	width: 20px;
    height: 20px;
	background-image: url('<?=BASE?>assets/images/right.png');
}
.def_media .carousel-control-next{
	right: 0px;
	width: 5%;
	opacity: 1;
}
.def_media .carousel-item img,.carousel-item source{
	width:98%;
	
}
#grid .video-fluid{
	margin-top: 23%;
}

#grid{
  margin: 10px 2px;
  padding:0px;
}
#list{
   padding:0px;
  
}
#button_list{
	 margin: 17px 0px;
}
.area_actions {
    float: right;
    text-align: right;
}	
.item-action{
   margin-top: 5px;
}
.item-action .form-group{
  margin-right: 10px;
}
.card-header{
	display:block;
}
 .c1,.c2,.c3{
	float:left
}
.c2{
	text-align: left;
    padding-top: 18px;
}
.service_load_tbl{
	overflow-y: scroll;
}
@media only screen and (max-width: 700px) {
  .table th, .text-wrap table th, .table td, .text-wrap table td {
    padding: 0.5rem;
  }
}
@media only screen and (max-width: 500px){
.action-options {
    right: auto;
    margin-top: 0px;
}
.area_actions {
    float: unset;
    text-align: unset;
	
}
.card-header{
	padding:0px;
}
.c3 > .item-action{
	width:50%;
	float:left;
	margin-bottom:10px;
}
}

<?php if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
    .header .nav-item .badge{
        right:-5px;
    }

    <?php }else{ ?>
    #button_list, #button_grid{
		margin: 17px 0px;
		float: right;
	}
	.area_actions {
		float: left;
		text-align: left;
	}
	 .c1,.c2,.c3{
		float:right;
	}
	.c3,.c2{
		text-align: start;
		 padding-top: 0px;
	}
	.c3{
		text-align:left;
	}
	.item-action .form-group{
		margin:unset;
	}
	.custom-controls-stacked{
		float: right;
	}
	@media only screen and (max-width: 500px){
		.c3{
			text-align:right;
		}
		.service_load_tbl{
			overflow-y: scroll;
			display: inline-block;
		}
			
	}
    <?php } ?>
	<?php
	if (!(get_role("admin") ||get_role("supporter") || get_role("m-seller"))) {
	?>
	.main_sub{display:none;}
	<?php }?>
</style>

	<div class="col-lg-12 main_sub">
	<div class="card" style="margin-bottom:0.5rem">
			<div class="card-header">
			<?php if(get_role("admin") || get_role("supporter") ||get_role("m-seller")) { ?>
			
            <div class="col-lg-12 col-md-12 col-sm-12 area_actions">
			 <div class="col-lg-1 col-md-1 col-sm-1 c1">
			<button type="button" id="button_list" style="background: transparent; border: transparent;"><i class="fe fe-list" aria-hidden="true"> </i></button>
			<button type="button" id="button_grid" style="background: transparent; border: transparent;"><i class="fe fe-grid" aria-hidden="true"> </i></button>
			</div>
			
			 <div class="col-lg-2 col-md-2 col-sm-2 c2"><strong><?=$catename?></strong></div>
			 <div class="col-lg-9 col-md-9 col-sm-9 c3">
             <div class="item-action dropdown">
				<div class="form-group">

                    <select  name="status" class="form-control order_by ajaxChange btn btn-pill btn-outline-info dropdown-toggle" data-url="<?=cn($module."/ajax_service_sort_by_cate/")?>">

                        <option value="all"> <?=lang("sort_by")?></option>
						<option value="1"> <?=lang("Newest")?></option>
						<option value="2"> <?=lang("Price High - Low")?></option>
						<option value="3"> <?=lang("Price Low - High")?></option>						
						<option value="4"> <?=lang("Orders More - Less")?></option>
						<option value="5"> <?=lang("Orders Less - More")?></option>
						

                    </select>

                </div>
            </div>

            <?php
            if (get_role("admin")) {

            ?>

            <div class=" item-action dropdown">

                <div class="item-action dropdown action-options">

                    <button type="button" class="btn btn-pill btn-outline-info dropdown-toggle" data-toggle="dropdown">

                        <i class="fe fe-menu mr-2"></i> <?=lang("Action")?>

                    </button>

                    <div class="dropdown-menu dropdown-menu-right">

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="delete"><i class="fe fe-trash-2 text-danger mr-2"></i> <?=lang("Delete")?></a>

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="all_deactive"><i class="fe fe-trash-2 text-danger mr-2"></i> <?=lang("all_deactivated_services")?></a>

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="deactive"><i class="fe fe-x-square text-danger mr-2"></i> <?=lang("Deactive")?></a>

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="active"><i class="fe fe-check-square text-success mr-2"></i> <?=lang("Active")?></a>
                        <a class="dropdown-item ajaxModalCustom" href="<?=cn($module.'/bulk_update')?>" data-type="edit"><i class="fe fe-edit  mr-2"></i><?=lang("bulk_edit")?></a>
                    </div>

                </div>

            </div>


         

        <?php }?>
       
    				   
			<?php } ?>
			</div>
			</div>
	</div>
	</div>

<div id="list" class="col-lg-12 col-md-12 col-xs-12" >
<?php if (!empty($services)) {
?>

<div class="card service_load_tbl">
	<div class="card-header">
		<h3 class="card-title"></h3>
		<div class="card-options"></div>
	</div>
	<table class="table table-hover table-bordered table-outline table-vcenter card-table">
	  <thead>
		<tr>
      <?php
        if (get_role("admin")|| get_role("m-seller")) {
      ?>
      <th class="text-center w-1">
        <div class="custom-controls-stacked">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input check-all" data-name="chk_<?=$cate_id?>">
            <span class="custom-control-label"></span>
          </label>
        </div>
      </th>
      <?php }?>
      <th class="text-center w-1">ID</th>
      <?php if (!empty($columns)) {
        foreach ($columns as $key => $row) {
      ?>
      <th><?=$row?></th>
      <?php }}?>
      
      <?php
        if (get_role("admin") || get_role("supporter")|| get_role("m-seller")) {
      ?>
      <th><?=lang("Action")?></th>
      <?php }?>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($services)) {
      $decimal_places = get_option('currency_decimal', 2);
      switch (get_option('currency_decimal_separator', 'dot')) {
        case 'dot':
          $decimalpoint = '.';
          break;
        case 'comma':
          $decimalpoint = ',';
          break;
        default:
          $decimalpoint = '';
          break;
      }

      switch (get_option('currency_thousand_separator', 'comma')) {
        case 'dot':
          $separator = '.';
          break;
        case 'comma':
          $separator = ',';
          break;
        case 'space':
          $separator = ' ';
          break;
        default:
          $separator = '';
          break;
      }
		
      $i = 0;
      foreach ($services as $key => $row) {
		  
      $i++;
    ?>
    <tr class="tr_<?=$row->ids?>">
      <?php
        if (get_role("admin")|| get_role("m-seller")) {
      ?>
      <th class="text-center w-1">
        <div class="custom-controls-stacked">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input chk_<?=$row->cate_id?>"  name="ids[]" value="<?=$row->ids?>">
            <span class="custom-control-label"></span>
          </label>
        </div>
      </th>
      <?php }?>
      <td class="text-center text-muted"><?=$row->id?></td>
      <td>
        <div class="title"><?=$row->name?></div>
      </td>
      
      <?php
        if (get_role("admin") || get_role("supporter")|| get_role("m-seller")) {
      ?>
      <td class="text-muted" style="width: 5%;"><?=(!empty($row->add_type) && $row->add_type == "api")? lang("API"): lang('Manual')?></td>
      <td class="text-muted" style="width: 5%;"><?=(!empty($row->api_service_id))? $row->api_service_id: ""?></td>
      <td class="text-muted"  style="width: 8%;"><?=(!empty($row->api_name))? truncate_string($row->api_name, 13) : "Default"?></td>
      <?php }?>
      <td style="width: 8%;">
        <?=currency_format($row->price, $decimal_places, $decimalpoint, $separator)?>
        <?php 
          if (get_role("admin") && isset($row->original_price)) {
            echo '<small class="text-muted"> - '.currency_format($row->original_price, $decimal_places, $decimalpoint, $separator).'</small>';
        }?>
      </td>

      <td style="width: 8%;"><?=$row->min?> / <?=$row->max?></td>
		
	  <td style="width: 6%;">
        <a href="<?=cn("$module/service_media/".$row->ids)?>" class="ajaxModal">
          <span class="btn btn-info btn-sm"><?=lang("Media")?></span> 
        </a>
      </td>	
      <td style="width: 6%;">
        <a href="<?=cn("$module/desc/".$row->ids)?>" class="ajaxModal">
          <span class="btn btn-info btn-sm"><?=lang("Details")?></span> 
        </a>
      </td>

      <?php
        if (get_role("admin") || get_role("supporter")|| get_role("m-seller")) {
      ?>
      <td class="w-1">
        <?php if(!empty($row->dripfeed) && $row->dripfeed == 1){?>
          <span class="badge badge-info"><?=lang("Active")?></span>
          <?php }else{?>
          <span class="badge badge-warning"><?=lang("Deactive")?></span>
        <?php }?>
      </td>

      <td class="w-1" >
        <?php if(!empty($row->status) && $row->status == 1){?>
          <span class="badge badge-info"><?=lang("Active")?></span>
          <?php }else{?>
          <span class="badge badge-warning"><?=lang("Deactive")?></span>
        <?php }?>
      </td>  


      <td class="text-center"  style="width: 5%;">
        <div class="item-action dropdown">
          <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
          <div class="dropdown-menu">
            <a href="<?=cn("$module/update/".$row->ids)?>" class="dropdown-item ajaxModal"><i class="dropdown-icon fe fe-edit"></i> <?=lang('Edit')?> </a>
            <?php
            //   if (get_role("admin")) {
            ?>
            <a href="<?=cn("$module/ajax_delete_item/".$row->ids)?>" class="dropdown-item ajaxDeleteItem"><i class="dropdown-icon fe fe-trash"></i> <?=lang('Delete')?> </a>
            <?php 
            // }
            ?>
          </div>
        </div>
      </td>
      <?php }?>

    </tr>
    <?php }}?>
    
  </tbody>
</table>
</div>
<?php } ?>
</div>

<div id="grid" class="col-lg-12" style="display: none;">


    <?php if (!empty($services)) {
?>



    <?php if (!empty($services)) {
      $decimal_places = get_option('currency_decimal', 2);
      switch (get_option('currency_decimal_separator', 'dot')) {
        case 'dot':
          $decimalpoint = '.';
          break;
        case 'comma':
          $decimalpoint = ',';
          break;
        default:
          $decimalpoint = '';
          break;
      }

      switch (get_option('currency_thousand_separator', 'comma')) {
        case 'dot':
          $separator = '.';
          break;
        case 'comma':
          $separator = ',';
          break;
        case 'space':
          $separator = ' ';
          break;
        default:
          $separator = '';
          break;
      }
?>
    <div class="row mx-0">
	           
        <div class="col-12" style="margin-bottom:1rem">
            <div class="custom-controls-stacked">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input check-all" data-name="chk_<?=$cate_id?>">
                    <span class="custom-control-label"></span>
                </label>
            </div>
        </div>
		<input type="hidden" value="<?=$row->cate_id?>" id="m_cateid"/>
		<input type="hidden" value="<?=$row->sub_cat_id?>" id="sub_cateid"/>
		<input type="hidden" value="<?=$row->second_sub_cat_id?>" id="sec_sub_cateid"/>		
		    
			<?php
				  $i = 0;
				  
				  foreach ($services as $key => $row) {
					
				  $i++;
		  
			?>

		<div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3">
            <div class="card table-responsive">
                <!--       <img src="http://magento2.flytheme.net/themes/sm_venuse/pub/media/wysiwyg/slidershow/home-1/item-3.jpg" class="img-fluid"> -->
                <table class="table table-sm table-hover uffLastTimeAlign">
					<tr>
                    <th class="text-center w-1">
                        <div class="custom-controls-stacked" style="
								background: white;
								padding-left: 20px;
							">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input chk_<?=$cate_id?>" name="ids[]" value="<?=$row->ids?>">
                                <span class="custom-control-label"></span>
                            </label>
                        </div>
                    </th>
					 </tr>
					 <div>
						<?php						
                      if (!empty($medias)) {?>
					    <div id="video-carousels_<?=$row->id?>" class="carousel slide carousel-fade def_media" data-interval="false" data-ride="carousel">
							
							<div class="carousel-inner" role="listbox">
								<?php
								
									foreach ($medias as $keys => $rows) {
										 
										if(trim($rows->media_id) === trim($row->media_url)){
										
										
										$url='https://'.$rows->file_path.'/'.$rows->name;
										
								?> 
								<?php if($rows->type==1): ?>
								     
									<div class="carousel-item">
									<a href="<?=cn("$module/service_media/".$row->ids)?>" class="ajaxModal">
									  <video class="video-fluid" style="width:98%;" controls>
									  
										<source class="cls_video" src="<?=$url?>" type="video/mp4" />
										
									  </video>
									  </a>
									</div>
								<?php else: ?>
							
									<div class="carousel-item">
									  <a href="<?=cn("$module/service_media/".$row->ids)?>" class="ajaxModal">
									  <img class="d-block" src="<?=$url?>">
									  </a>
									 </div>
								<?php endif; ?>	
								
								<?php }}?>
								</div>
  
								<a class="carousel-control-prev"  href="#video-carousels_<?=$row->id?>" role="button" data-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="carousel-control-next"   href="#video-carousels_<?=$row->id?>" role="button" data-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
							</div>
							<?php }?>  
						</div>	
                    <tr>
                        <td width="40%"><?=lang("service_id")?></td>
                        <td width="60%"><?=$row->id?></td>
                    </tr>
                    <tr>
                        <td><?=lang("Name")?></td>
                        <td title="<?=$row->name?>"><div class="textWrap" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis; width:150px;"><?=$row->name?></div></td>
                    </tr>
                    <?php
                      if (get_role("admin") || get_role("supporter")|| get_role("m-seller")) {
                    ?>
                    <tr>
                        <td><?=lang("Type")?></td>
                        <td><?=(!empty($row->add_type) && $row->add_type == "api")? lang("API"): lang('Manual')?></td>
                    </tr>
                    <tr>
                        <td><?=lang("api_service_id")?></td>
                        <td><?=(!empty($row->api_service_id))? $row->api_service_id: ""?></td>
                    </tr>
                    <tr>
                        <td><?=lang("api_provider")?></td>
                        <td><?=(!empty($row->api_name))? truncate_string($row->api_name, 13) : "Default"?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td><?=lang("rate")?>($)</td>
                        <td>
                            <?=currency_format($row->price, $decimal_places, $decimalpoint, $separator)?>
                            <?php 
                    if (get_role("admin") && isset($row->original_price)) {
                      echo '<small class="text-muted"> - '.currency_format($row->original_price, $decimal_places, $decimalpoint, $separator).'</small>';
                  }?>


                        </td>
                    </tr>
                    <tr>
                        <td style="white-space: pre;"><?=lang("Min/Max_Order")?></td>
                        <td>
                            <?=$row->min?> / <?=$row->max?>
                        </td>
                    </tr>
                    <tr>
                        <td><?=lang("Description")?></td>
                        <td> <a href="<?=cn("$module/desc/".$row->ids)?>" class="ajaxModal">
                                <span class="btn btn-info btn-sm"><?=lang("Details")?></span>
                            </a>
                        </td>

                    </tr>
                    <?php
						if (get_role("admin") || get_role("supporter")|| get_role("m-seller")) {
					  ?>
                    <tr>
                        <td><?=lang("__drip_feed")?></td>
                        <td class="w-1">
                            <?php if(!empty($row->dripfeed) && $row->dripfeed == 1){?>
                            <span class="badge badge-info"><?=lang("Active")?></span>
                            <?php }else{?>
                            <span class="badge badge-warning"><?=lang("Deactive")?></span>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td><?=lang("Status")?></td>
                        <td class="w-1">
                            <?php if(!empty($row->status) && $row->status == 1){?>
                            <span class="badge badge-info"><?=lang("Active")?></span>
                            <?php }else{?>
                            <span class="badge badge-warning"><?=lang("Deactive")?></span>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td><?=lang("Action")?></td>
                        <td>
                            <div class="item-action dropdown">
                                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                <div class="dropdown-menu">
                                    <a href="<?=cn("$module/update/".$row->ids)?>" class="dropdown-item ajaxModal"><i class="dropdown-icon fe fe-edit"></i> <?=lang('Edit')?> </a>
                                    <?php
              if (get_role("admin")) {
            ?>
                                    <a href="<?=cn("$module/ajax_delete_item/".$row->ids)?>" class="dropdown-item ajaxDeleteItem"><i class="dropdown-icon fe fe-trash"></i> <?=lang('Delete')?> </a>
                                    <?php }?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
              </div>
        </div>

        <?php }}?>
    </div>

    <?php } ?>
</div>
<script>
$(function() {
	
	$('#button_list,#button_grid').click(function(){
		$('#btnTy').val($(this).attr('id'));
	})
	if($('#btnTy').val()=='button_list'){
		$('#list').show();
		$('#grid').hide();
	}else if($('#btnTy').val()=='button_grid'){
		$('#grid').show();
		$('#list').hide();
	}else{}
	
	$('.def_media').find('.carousel-item:first').addClass('active');
});

$(document).on("click", ".carousel-item .ajaxModal" , function(event){
	
	/* var sld=$('#video-carousels .ajaxModal').index(this); */
	 var sld=$(this).parents('.def_media').get(0).innerHTML;
	
	 setTimeout(function () {
		
		$('#video-carousel').empty().append(sld);
		
	    $('#video-carousel').find('.carousel-control-prev,.carousel-control-next').attr('href','#video-carousel');
		
		$('#video-carousel .carousel-inner .carousel-item').find('img,source').each(function(){
	  
			var height = 300;
			var width = 300;
			aspect = width / height;

			if($(window).height() < $(window).width()) {
				var resizedHeight = $(window).height();
				var resizedWidth = resizedHeight * aspect;
				
				if($(this).attr('class')!='cls_video'){
					$(this).css({'width':resizedWidth+'px','height':resizedHeight+'px'});
				}else{
					$(this).parent().css({'width':resizedWidth+'px'});
					$(this).parents('.carousel-item').css({'height':resizedHeight+'px'});
				}
			}

			else { // screen width is smaller than height (mobile, etc)
				var resizedWidth = $(window).width();
				var resizedHeight = resizedWidth / aspect; 
							
				if($(this).attr('class')!='cls_video'){
					$(this).css({'width':resizedWidth+'px','height':resizedHeight+'px'});
				}else{
					$(this).parent().css({'width':resizedWidth+'px'});
					$(this).parents('.carousel-item').css({'height':resizedHeight+'px'});
				}
					
			}
	  
		});	
	  }, 300); 
})


</script>
