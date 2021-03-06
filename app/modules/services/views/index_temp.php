<?php 

$lang_current = get_lang_code_defaut();

?>
<style>



    <?php

    $lang_current = get_lang_code_defaut();

    ?>
	
    .action-options{

        margin-left: auto;

    }
	
    .dropdown-item.ajaxActionOptions{

        padding-top: 0px!important;

        padding-bottom: 0px!important;

    }
    <?php if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
    .header .nav-item .badge{
        right:-5px;
    }

    <?php }else{ ?>
    .header .nav-item .badge{
        right:5px;
    }
    
    <?php } ?>

    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        center: 100%;
        margin-top: -6px;
        margin-left: -1px;
        -webkit-border-radius: 0 6px 6px 6px;
        -moz-border-radius: 0 6px 6px;
        border-radius: 0 6px 6px 6px;
    }

    .dropdown-submenu:hover>.dropdown-menu {
        display: block;
    }

    .dropdown-submenu>a:after {
        display: block;
        content: " ";
        float: right;
        width: 0;
        height: 0;
        border-color: transparent;
        border-style: solid;
        border-width: 5px 0 5px 5px;
        border-left-color: #ccc;
        margin-top: 5px;
        margin-right: -10px;
    }

    .dropdown-submenu:hover>a:after {
        border-left-color: #fff;
    }

    .dropdown-submenu.pull-left {
        float: none;
    }

    .dropdown-submenu.pull-left>.dropdown-menu {
        left: -100%;
        margin-left: 10px;
        -webkit-border-radius: 6px 0 6px 6px;
        -moz-border-radius: 6px 0 6px 6px;
        border-radius: 6px 0 6px 6px;
    }
    <?php

    $lang_current = get_lang_code_defaut();

    ?>
    

     .action-options{

         margin-left: auto;

     }
	 
    .dropdown-item.ajaxActionOptions{

        padding-top: 0px!important;

        padding-bottom: 0px!important;

    }
	.item-action .dropdown-submenu >.dropdown-menu {
		
		margin-top: 0px;
		margin-left: 130px;
		
	}
	//.item-action .dropdown-submenu >.dropdown-menu > li{
		
	//	 padding: 13px;
		
	//}
    <?php if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
    .header .nav-item .badge{
        right:-5px;
    }

    <?php }else{ ?>
    .header .nav-item .badge{
        right:5px;
    }
    .dropdown-menu.show{
        direction: rtl;
        text-align: right;
    }
    <?php } ?>
	.dropdown-menu .dropdown-item,.dropdown-menu .dropdown-item:hover{
		color:#467fcf;
		background-color:#fff;
		cursor:pointer;
	}
</style>



<form class="actionForm"  method="POST">

    <section class="page-title">

        <div class="row justify-content-between">

            <div class="col-md-2">

                <h1 class="page-title">

                    <?php

                    if(get_role("admin") || get_role("supporter")) {

                        ?>

                        <a href="<?=cn("$module/update")?>" class="ajaxModal"><span class="add-new" data-toggle="tooltip" data-placement="bottom" title="<?=lang("add_new")?>" data-original-title="Add new"><i class="fa fa-plus-square text-primary" aria-hidden="true"></i></span></a>

                    <?php }else{?>

                        <i class="fe fe-list" aria-hidden="true"> </i>

                    <?php }?>

                    <?=lang("Services")?>

                </h1>

            </div>

            <div class="col-md-7">

                <?php

                if (get_option("enable_explication_service_symbol")) {

                    ?>

                    <div class="btn-list">

                        <span class="btn round btn-secondary ">⭐ = <?=lang("__good_seller")?></span>

                        <span class="btn round btn-secondary ">⚡️ = <?=lang("__speed_level")?></span>

                        <span class="btn round btn-secondary ">🔥 = <?=lang("__hot_service")?></span>

                        <span class="btn round btn-secondary ">💎 = <?=lang("__best_service")?></span>

                        <span class="btn round btn-secondary ">💧 = <?=lang("__drip_feed")?></span>

                    </div>

                <?php } ?>

            </div>







        </div>

    </section>
    <section>




        <div class="form-group">
            <?php  foreach ($all_categories as $key => $category) {?>
                <div class="item-action dropdown">
                    <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary get_service maCat" value="<?=$category->id?>" data-url="<?=cn($module.'/ajax_load_services_by_id/'.$category->id)?>" href="/page.html">
                        <i class="fe fe-menu mr-2"></i> <?=$category->name?><span class="caret"></span>
                    </a>
					 
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="padding: 10px !important;">
                        <?php 
						     if(!empty($this->model->get_services($category->id,'0','main'))){
                            ?>
						<li> 
						  <a tabindex="-1" class="get_service maCat dropdown-item" value="<?=$category->id?>" data-url="<?=cn($module.'/ajax_load_services_by_id/'.$category->id)?>"><?=$category->name?></a>
                        </li> 
						<?php }?>
						
						<?php foreach($all_sub_categories as $sub){
                            if($sub->cat_id!=$category->id){
                                {continue;}
                            }
                            ?>
						
						
						<li class="dropdown-submenu">           
                                <a tabindex="-1" class="get_service mCat dropdown-item" value="<?=$sub->id?>" data-url="<?=cn($module.'/ajax_load_services_by_id/'.$sub->id)?>"><?=$sub->name?></a>
                                <ul class="dropdown-menu">
								<?php 
									if(!empty($this->model->get_services($category->id,$sub->id,'sub'))){
								?>
								<li> 
								  <a tabindex="-1" class="get_service mCat dropdown-item" value="<?=$sub->id?>" data-url="<?=cn($module.'/ajax_load_services_by_id/'.$sub->id)?>"><?=$sub->name?></a>
								</li>
								<?php }?>
								<?php foreach($second_sub_categories as $seond_sub){
                                        if($seond_sub->sub_cat_id!=$sub->id){
                                            {continue;}
                                        }
                                        ?>
										
											<li>
											  <a tabindex="-1" class="get_service sCat dropdown-item" value="<?=$seond_sub->id?>" data-url="<?=cn($module.'/ajax_load_services_by_id/'.$seond_sub->id)?>" ><?=$seond_sub->name?></a>
											</li>
                                 <?php }?>   
										</ul>
								
                        </li>
						<?php }?>
						
                    </ul>
					 
                </div>
				
				<script>				   
				   $('.get_service').on("click",function(){
						_type='cate_id';
						if($(this).hasClass('mCat')){
							_type='sub_cat_id';
							
						}else if($(this).hasClass('sCat')){
							_type='second_sub_cat_id';
						}else{ _type='cate_id'; }
						
						if($(this).next('ul.dropdown-menu').length ==0){
						var _that       = $(this);
						_action     = _that.data("url");
						_data       = $.param({token:token,'type':_type});
						$.post( _action, _data, function(_result){
							var html='<div class="card service_load_tbl">'+
										'<div class="card-header">'+
											'<h3 class="card-title"></h3>'+
											'<div class="card-options"></div>'+
										'</div>'+
										'<table class="able table-hover table-bordered table-outline table-vcenter card-table">'+
										_result+
										'</table>'+
											 
									   '</div>';
							
							$('#result_ajaxSearch').empty().append(html);
							if (_that.hasClass('active')) {
								_that.removeClass('active');
							}
						});
						}
						})
                </script>
            <?php }?>

            <div class="item-action dropdown" <?php if($lang_current->code == 'en'){?> style="float: right;" <?php }else{?> style="float: left;" <?php }?>>

                <div class="form-group " style="margin-right: 10px">

                    <select  name="status" class="form-control order_by ajaxChange btn btn-pill btn-outline-info dropdown-toggle" data-url="<?=cn($module."/ajax_service_sort_by_cate/")?>">

                        <option value="all"> <?=lang("sort_by")?></option>

                        <?php
                        if (!empty($all_categories)) {
                            foreach ($all_categories as $key => $category) {
                                ?>

                                <option value="<?=$category->id?>"><?=$category->name?></option>

                            <?php }}?>

                    </select>

                </div>





            </div>
            <?php
            if (get_role("admin")) {

            ?>

            <div class=" item-action dropdown" <?php if($lang_current->code == 'en'){?> style="float: right;" <?php }else{?> style="float: left;" <?php }?> >

                <div class="item-action dropdown action-options" style="margin-left: 10px;margin-right: 10px">

                    <button type="button" class="btn btn-pill btn-outline-info dropdown-toggle" data-toggle="dropdown">

                        <i class="fe fe-menu mr-2"></i> <?=lang("Action")?>

                    </button>

                    <div class="dropdown-menu dropdown-menu-right">

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="delete"><i class="fe fe-trash-2 text-danger mr-2"></i> <?=lang("Delele")?></a>

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="all_deactive"><i class="fe fe-trash-2 text-danger mr-2"></i> <?=lang("all_deactivated_services")?></a>

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="deactive"><i class="fe fe-x-square text-danger mr-2"></i> <?=lang("Deactive")?></a>

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="active"><i class="fe fe-check-square text-success mr-2"></i> <?=lang("Active")?></a>
                        <a class="dropdown-item ajaxModalCustom" href="<?=cn($module.'/bulk_update')?>" data-type="edit"><i class="fe fe-edit  mr-2"></i><?=lang("bulk_edit")?></a>
                    </div>

                </div>

            </div>


            <!--                                        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>-->
            <!--                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>-->


        <?php }?>
        </div>
    </section>
	
    <div class="row m-t-5" id="result_ajaxSearch">

        <?php if(!empty($all_services)){

            foreach ($all_services as $key => $category) {

                if ($category->is_exists_services) {

                    ?>
<div style="background-color: white;min-height: 20px"></div>
                    <div class="col-md-12 col-xl-12">
                        <h3 class="card-title" style="background-color: white;margin-bottom: 0px;padding-bottom: 20px;padding-left: 20px;padding-top: 15px;"><?="$category->name / $sub->name"?></h3>
                        <?php foreach($second_sub_categories as $second_sub){if($second_sub->cat_id!=$sub_categories->id){    continue;}?>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><?=$second_sub->name?></h3>
                                    <div class="card-options">
                          

<!--                                        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>-->
<!--                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>-->
                                    </div>


                                </div>
                                <?php
                                if ($sub->is_exists_services) {
                                    $services = (isset($sub->services))? $category->services : "";
                                    ?>
                                    <div class="table-responsive dimmer ajaxLoadServices_<?=$sub->id?>" data-url="<?=cn($module."/ajax_load_services_by_sub_cate/".$sub->id)?>">
                                        <div class="loader"></div>
                                        <table class="dimmer-content table table-hover table-bordered table-outline table-vcenter card-table">
                                        </table>
                                    </div>
                                    <script>
                                        $(function() {
                                            var _that       = $(".ajaxLoadServices_<?=$sub->id?>");
                                            _action     = _that.data("url");
                                            _data       = $.param({token:token});
                                            $.post( _action, _data, function(_result){
                                                $(_that).html(_result);
                                                if (_that.hasClass('active')) {
                                                    _that.removeClass('active');
                                                }
                                            });
                                        });
                                    </script>
                                <?php }?>
                            </div>
                        <?php }?>
                    </div>
                <?php }}}else{?>
            <div class="col-md-12 data-empty text-center">

                <div class="content">

                    <img class="img mb-1" src="<?=BASE?>assets/images/ofm-nofiles.png" alt="empty">

                    <div class="title"><?=lang("look_like_there_are_no_results_in_here")?></div>

                </div>

            </div>

        <?php } ?>

    </div>
	

</form>
<script type="text/javascript">

    // load ajax-Modal
    $(document).off().on("click", ".ajaxModalCustom", function(){
        event.preventDefault();
        _that = $(this);
        _url = _that.attr("href");
        _form       = _that.closest('form');
        _ids        = _form.serialize();
        $('#modal-ajax').load(_url, function(){
            $('#modal-ajax').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#modal-ajax').modal('show');
        });
        return false;
    });
    $(document).on("submit", ".actionFormCustomService", function(){
        pageOverlay.show();
        event.preventDefault();
        _that       = $(this);
        _action     = _that.attr("action");
        _redirect   = _that.data("redirect");
        _data       = _that.serializeArray();
        var data=new FormData();
        $.each(_data, function (key, input) {
            data.append(input.name, input.value);
        });
        //File data
        var file_data = $('input[name="attach_file"]')[0].files;
        if (typeof file_data[0] !== 'undefined') {
            if(file_data[0]["size"]>20971520){
                pageOverlay.hide();
                setTimeout(function(){
                    notify("Unsupported File Size", "error");
                },1500);
                return false;
            }
        }
        for (var i = 0; i < file_data.length; i++) {
            data.append("attach_file[]", file_data[i]);
        }
        //Custom data
        data.append('token', token);
        data.append('ids', _ids);
        $.ajax({
            url: _action,
            method: "post",
            processData: false,
            contentType: false,
            data: data,
            success: function (_result) {
                setTimeout(function(){
                    pageOverlay.hide();
                },1500);

                if (is_json(_result)) {
                    _result = JSON.parse(_result);
                    setTimeout(function(){
                        notify(_result.message, _result.status);
                    },1500)
                    setTimeout(function(){
                        if(_result.status == 'success' && typeof _redirect != "undefined"){
                            reloadPage(_redirect);
                        }
                    }, 2000)
                }else{
                    setTimeout(function(){
                        $("#result_notification").html(_result);
                    }, 1500)
                }
            }
        });
        return false;
    });
	
	
</script>
<script>
    $(document).on('click', '#ask_seller_btn', function(){
        $('#modal-ajax').modal('toggle');
        service_id=$(this).data("service_id");
        url="<?php echo base_url().'tickets/index/'?>"+service_id;
        window.location=url;
    });

</script>