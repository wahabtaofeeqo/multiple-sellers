<style>

    .action-options{

        margin-left: auto;

    }
    .table-hover tbody tr:hover{

        background-color: rgba(0, 0, 0, 0.04) !important;
    }
    .second_sub_category_name,.sub_category_name{
        width: 35%;
    }
    @media screen and (max-width: 600px) {
        .second_sub_category_name{
            width:100%;
            margin-right: 0px !important;
            margin-left: 0px !important;
        }
        .sub_category_name{
            width:100%;
            margin-right: 0px !important;
            margin-left: 0px !important;
        }
    }
	
</style>
<?php

$lang_current = get_lang_code_defaut();
//print_r($lang_current);

?>
<style>

    <? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>

    <?php; }else{ ?>

    .dropdown-menu.show{
        direction: rtl;
        text-align: right;
    }
	
	.card-title{
		width:100%;
	}
    <?php; } ?>
</style>


<form class="actionForm"  method="POST">

    <h1 class="page-title">

        <div class="col-md-2">

            <div class="page-header">

                <div class="row justify-content-between">

                    <?php

                    if(get_role("admin")  || get_role("supporter")) {

                        ?>

                        <a href="<?=cn("$module/update")?>" class="ajaxModal"><span class="add-new" data-toggle="tooltip" data-placement="bottom" title="<?=lang("add_new")?>" data-original-title="Add new"><i class="fa fa-plus-square text-primary" aria-hidden="true"></i></span></a>

                    <?php }?>

                    <?=lang("Category")?>

    </h1>

    <div class="page-options d-flex">

        <?php

        if (get_role("admin")) {

            ?>

            <div class="form-group d-flex">

                <div class="item-action dropdown action-options">

                    <button type="button" class="btn btn-pill btn-outline-info dropdown-toggle" data-toggle="dropdown">

                        <i class="fe fe-menu mr-2"></i> <?=lang("Action")?>

                    </button>

                    <div class="dropdown-menu dropdown-menu-right">

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="delete"><i class="fe fe-trash-2 text-danger mr-2"></i> <?=lang("Delete")?></a>

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="all_deactive"><i class="fe fe-trash-2 text-danger mr-2"></i> <?=lang("all_deactivated_categories")?></a>

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="deactive"><i class="fe fe-x-square text-danger mr-2"></i> <?=lang('Deactive')?></a>

                        <a class="dropdown-item ajaxActionOptions" href="<?=cn($module.'/ajax_actions_option')?>" data-type="active"><i class="fe fe-check-square text-success mr-2"></i> <?=lang('Active')?></a>
                        <a class="dropdown-item ajaxModalCustom" href="<?=cn($module.'/add_sub_category')?>" data-type="edit"><i class="fe fe-edit  mr-2"></i><?=lang("add_sub_category")?></a>
                        <a class="dropdown-item ajaxModalCustom" href="<?=cn($module.'/add_second_sub_category')?>" data-type="edit"><i class="fe fe-edit  mr-2"></i><?=lang("add_second_sub_category")?></a>
                    </div>

                </div>

            </div>

        <?php }?>

    </div>

    </div>



    <div class="row" id="result_ajaxSearch">

        <?php if(!empty($categories)){

            ?>

            <div class="col-md-12 col-xl-12">

                <div class="card">

                    <div class="card-header">

                        <h3 class="card-title"><?=lang("Lists")?></h3>

                        <div class="card-options">

                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>

                            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>

                        </div>

                    </div>
					
                    <div class="table-responsive">

                        <table class="table table-hover table-bordered table-vcenter card-table">

                            <thead>

                            <tr>

                                <?php

                                if (get_role("admin")) {

                                    ?>

                                    <th class="text-center w-1">

                                        <div class="custom-controls-stacked">

                                            <label class="custom-control custom-checkbox">

                                                <input type="checkbox" class="custom-control-input check-all" data-name="chk_1">

                                                <span class="custom-control-label"></span>

                                            </label>

                                        </div>

                                    </th>

                                <?php }?>

                                <th class="text-center w-1" style="width: 100px !important;">#</th>
                                <th class="text-center w-1"><?=lang("No_")?></th>

                                <?php if (!empty($columns)) {

                                    foreach ($columns as $key => $row) {

                                        ?>

                                        <th><?=$row?></th>

                                    <?php }}?>



                                <?php

                                if (get_role("admin")  || get_role("supporter")) {

                                    ?>

                                    <th class="text-center"><?=lang("Action")?></th>

                                <?php }?>

                            </tr>

                            </thead>

                            <tbody>
                            <?php if (!empty($categories)) {
                                $i = $from;
                                $colors=['white','white','white','white'];
                                foreach ($categories as $key => $row) {

                                    $i++;

                                    ?>
                                    <tr class="tr_<?=$row->ids?>"  <?php if(isset($colors[$key])){?> style="background-color:<?php echo $colors[$key];?>" <?php } ?> data-toggle="collapse">
                                        <?php

                                        if (get_role("admin")) {

                                            ?>

                                            <th class="text-center w-1">

                                                <div class="custom-controls-stacked">

                                                    <label class="custom-control custom-checkbox">

                                                        <input type="checkbox" class="custom-control-input chk_1"  name="ids[]" value="<?=$row->ids?>">

                                                        <span class="custom-control-label"></span>

                                                    </label>

                                                </div>

                                            </th>

                                        <?php }?>
                                        <td  data-target=".collapseContent<?=$key?>" data-toggle="collapse"  data-role="expander" data-id="<?=$key?>" data-group-id="parent<?=$key?>"><div>&gt;</div></td>
                                        <td  class="text-center"><?=$i?></td>

                                        <td>

                                            <div class="title"><?=$row->name?></div>

                                        </td>

                                        <td><?=$row->desc?></td>

                                        <td><?=$row->sort?></td>

                                        <td>

                                            <?php if(!empty($row->status) && $row->status == 1){?>

                                                <span class="badge badge-info"><?=lang("Active")?></span>

                                            <?php }else{?>

                                                <span class="badge badge-warning"><?=lang("Deactive")?></span>

                                            <?php }?>

                                        </td>



                                        <?php

                                        if (get_role("admin") || get_role("supporter")) {

                                            ?>

                                            <td class="text-center">

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

                                        <?php }?>

                                    </tr>

                                    <?php $j=1;foreach($sub_categories as $sub_key=>$sub){if($sub->cat_id == $row->id){?>
                                        <tr class="collapse collapseContent<?=$key?> tr_<?=$sub->ids?>" aria-expanded="true" <?php if(isset($colors[$key])){?> style="background-color:antiquewhite" <?php } ?>>
                                            <?php

                                        if (get_role("admin")) {

                                            ?>

                                            <th class="text-center w-1">

                                                <div class="custom-controls-stacked">

                                                    <label class="custom-control custom-checkbox">

                                                        <input type="checkbox" class="custom-control-input chk_1"  name="ids[]" value="<?=$row->ids?>">

                                                        <span class="custom-control-label"></span>

                                                    </label>

                                                </div>

                                            </th>

                                        <?php }?>
                                            <td style="text-align: center" data-target=".secondcollapseContentsub<?=$sub_key?>" data-toggle="collapse"  data-role="expander" data-id="<?=$sub_key?>" data-group-id="parent<?=$sub_key?>"><div  >&gt;</div></td>
                                            <td  class="text-center"><?=$j?></td>
                                            <td>
                                                <div class="title sub_category_name" <?php if($lang_current->code == 'en'){?> style="text-align: left;float: right;margin-right: 30%" <?php }else{?> style="text-align: right;float: left;margin-left: 30%" <?php }?>><span <?php if($lang_current->code == 'en'){?> style="text-align: right" <?php }else{?> style="direction: rtl;" <?php }?>><?=$sub->name?></div>
                                            </td>
                                            <td><?=$sub->desc?></td>
                                            <td><?=$sub->sort?></td>
                                            <td>
                                                <?php if(!empty($sub->status) && $sub->status == 1){?>
                                                    <span class="badge badge-info"><?=lang("Active")?></span>
                                                <?php }else{?>
                                                    <span class="badge badge-warning"><?=lang("Deactive")?></span>
                                                <?php }?>
                                            </td>
                                            <td class="text-center">

                                                <div class="item-action dropdown">

                                                    <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>

                                                    <div class="dropdown-menu">



                                                        <a href="<?=cn("$module/update_sub_category/".$sub->id)?>" class="dropdown-item ajaxModal"><i class="dropdown-icon fe fe-edit"></i> <?=lang('Edit')?> </a>

                                                        <?php

                                                        if (get_role("admin")) {

                                                            ?>

                                                            <a href="<?=cn("$module/ajax_delete_sub_category_item/".$sub->id)?>" class="dropdown-item ajaxDeleteItem"><i class="dropdown-icon fe fe-trash"></i> <?=lang('Delete')?> </a>

                                                        <?php }?>

                                                    </div>

                                                </div>

                                            </td>
                                        </tr>
                                        <?php error_log(print_r($second_sub_categories,true),3,"test.log"); $k=1;foreach($second_sub_categories as $second_sub){if($sub->id == $second_sub->sub_cat_id){?>
                                            <tr  class="collapse secondcollapseContentsub<?=$sub_key?> tr_<?=$second_sub->ids?>" aria-expanded="true" <?php if(isset($colors[$key])){?> style="background-color:wheat" <?php } ?>>
                                                <?php

                                        if (get_role("admin")) {

                                            ?>

                                            <th class="text-center w-1">

                                                <div class="custom-controls-stacked">

                                                    <label class="custom-control custom-checkbox">

                                                        <input type="checkbox" class="custom-control-input chk_1"  name="ids[]" value="<?=$row->ids?>">

                                                        <span class="custom-control-label"></span>

                                                    </label>

                                                </div>

                                            </th>

                                        <?php }?>
                                                <td <?php if($lang_current->code == 'en'){?> style="text-align: right" <?php }else{?> style="text-align: left" <?php }?>> ></td>
                                                <td  class="text-center"><?=$k?></td>
                                                <td>
                                                    <div class="title second_sub_category_name" <?php if($lang_current->code == 'en'){?> style="text-align: left;float: right;" <?php }else{?> style="text-align: right;float: left;" <?php }?>><span <?php if($lang_current->code == 'en'){?> style="text-align: right" <?php }else{?> style="direction: rtl;" <?php }?>><?=$second_sub->name?></span></div>
                                                </td>
                                                <td><?=$second_sub->desc?></td>
                                                <td><?=$second_sub->sort?></td>
                                                <td>
                                                    <?php if(!empty($second_sub->status) && $second_sub->status == 1){?>
                                                        <span class="badge badge-info"><?=lang("Active")?></span>
                                                    <?php }else{?>
                                                        <span class="badge badge-warning"><?=lang("Deactive")?></span>
                                                    <?php }?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="item-action dropdown">

                                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>

                                                        <div class="dropdown-menu">



                                                            <a href="<?=cn("$module/update_second_sub_category/".$second_sub->id)?>" class="dropdown-item ajaxModal"><i class="dropdown-icon fe fe-edit"></i> <?=lang('Edit')?> </a>

                                                            <?php

                                                            if (get_role("admin")) {

                                                                ?>

                                                                <a href="<?=cn("$module/ajax_delete_second_sub_category_item/".$second_sub->id)?>" class="dropdown-item ajaxDeleteItem"><i class="dropdown-icon fe fe-trash"></i> <?=lang('Delete')?> </a>

                                                            <?php }?>

                                                        </div>

                                                    </div></td>
                                            </tr>
                                            <?php $k++;}}?>
                                        <?php $j++;}}?>

                                <?php }}?>



                            </tbody>

                        </table>

                    </div>
					
                </div>

            </div>

            <div class="col-md-12">

                <div class="float-right">

                    <?=$links?>

                </div>

            </div>

        <?php }else{?>

            <div class="col-md-12 data-empty text-center">

                <div class="content">

                    <img class="img mb-1" src="<?=BASE?>assets/images/ofm-nofiles.png" alt="empty">

                    <div class="title"><?=lang("look_like_there_are_no_results_in_here")?></div>

                </div>

            </div>

        <?php } ?>

    </div>

</form>
   
<script>
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

    $(document).ready(function(){
        $('.collapse').on('hide.bs.collapse', function () {
            var groupId = $('#expander').attr('data-id');
            if (groupId) {
                $('#parent' + groupId).html('>');
            }
        });
        $('.collapse').on('hide.bs.collapse', function () {
            var groupId = $('#expander').attr('data-id');
            if (groupId) {
                $('#parent' + groupId).html('v');
            }
        });
    });
</script>