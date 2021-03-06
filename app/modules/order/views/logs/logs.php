<?php

$lang_current = get_lang_code_defaut();
//print_r($lang_current);

?>
<style type="text/css">
  .order_btn_group .list-inline-item{
    margin-right: 0px!important;
  }
  .order_btn_group .list-inline-item a.btn{
    font-size: 0.9rem;
    font-weight: 400;
  }
  
</style>
<div class="page-header">
  <h1 class="page-title">
    <a href="<?=cn("$module/add")?>">
      <span class="add-new" data-toggle="tooltip" data-placement="bottom" data-original-title="<?=lang("add_new")?>"><i class="fa fa-plus-square text-primary" aria-hidden="true"></i></span>
    </a>
    <?=lang("order_logs")?>
  </h1>

  <div class="page-options d-flex">
    <ul class="list-inline mb-0 order_btn_group">
      <li class="list-inline-item"><a class="nav-link btn <?=($order_status == 'all') ? 'btn-info' : ''?>" href="<?=cn($module."/log/all")?>">All</a></li>
      <?php 
        $status_array = order_status_array();
        if (!empty($status_array)) {
          foreach ($status_array as $row_status) {
      ?>
      <li class="list-inline-item"><a class="nav-link btn <?=($order_status == $row_status) ? 'btn-info' : ''?>" href="<?=cn($module."/log/".$row_status)?>"><?=order_status_title($row_status)?></a></li>
      <?php }}?>
    </ul>
  </div>
</div>

<div class="row" id="result_ajaxSearch">
  <?php if(!empty($order_logs)){
  ?>
  
  <style>

<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>

<?php }else{ ?>

.dropdown-menu.show{
	direction: rtl;
	text-align: right;
}
.card-title{
	width:100%;
}
<?php } ?>

</style>
  <div class="col-md-12">
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
              <?php if (!empty($columns)) {
                foreach ($columns as $key => $row) {
              ?>
              <th><?=$row?></th>
              <?php }}?>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($order_logs)) {
               $i = 0;			  
              foreach ($order_logs as $key => $row) {
              $i++;
            ?>
            <tr class="tr_<?=$row->ids?>">
              <td class="text-center"><?=$row->id?></td>

              <?php
                if (get_role("admin") || get_role("supporter") || get_role("m-seller")) {
              ?>
              <td class="text-center"><?=($row->api_order_id == 0 || $row->api_order_id ==-1)? "" : $row->api_order_id?></td>
              
              <td><?=$row->user_email?></td>
              <?php } ?>
              <td>
                <div class="title">
                  <h6><?=$row->service_id." - ".$row->service_name?></h6>
                </div>
                <div>
                  <small>
                    <ul style="margin:0px">
                      <?php
                        if (get_role("admin")) {
                      ?>
                      <li>
                        <?=lang("Type")?>:<?=(!empty($row->api_provider_id) && $row->api_provider_id != "0")? lang("API")." (".$row->api_name.")" : lang("Manual")?>    
                      </li>
                      <?php }?>

                      <!--<li><?=lang("Link")?>: <a href="<?=$row->link?>" target="_blank"><?=truncate_string($row->link, 60)?></a></li>-->

                      <li><?=lang("Quantity")?>: <?=$row->quantity?></li>
                      <li><?=lang("Amount")?>: <?=get_option("currency_symbol","").$row->charge?></li>
                      <li><?=lang("Start_counter")?>: <?=(!empty($row->start_counter)) ? $row->start_counter : ""?></li>
                      <li><?=lang("Remains")?>: <?=(!empty($row->remains)) ? $row->remains : ""?></li>
                    </ul>
                  </small>
                </div>
              </td>
              <td>
                <?=$row->description?><br/>

                  <?php if ($row->file_link !="" && $row->file_link !="NULL"): ?>
                    <?php  $file_name=explode("/assets/uploads/ticket_file/",$row->file_link); ?>
                    <a href="<?=$row->file_link?>" download><?=$file_name[1]?></a>
                  <?php endif ?>
              </td>
              <td><?=convert_timezone($row->created, "user")?></td>
              <td>
                <?php
                  if ($row->status == "pending" || $row->status == "processing") {
                    $btn_background = "btn-info";
                  }elseif ($row->status == "inprogress") {
                    $btn_background = "btn-orange";
                  }elseif($row->status == "completed"){
                    $btn_background = "btn-blue";
                  }else{
                    $btn_background = "btn-danger";
                  }
                ?>
                <span class="btn round btn-sm <?=$btn_background?>"><?=order_status_title($row->status)?></span>
              </td>
				<td><?=(!empty($row->comment))? html_entity_decode($row->comment, ENT_QUOTES): ''?><br/>  
                    <?php
                        if($row->comment_link !="" && $row->comment_link !="NULL"){
                            $file_name=explode("/assets/uploads/order_file/",$row->comment_link);
                            ?>
                      <a href="<?=$row->comment_link?>" download><?=$file_name[1]?></a>
                        <?php }
                      ?> </td>
              <?php
                if (get_role("admin") || get_role("supporter") || get_role("m-seller")) {
              ?>
              <td class="text-red"><?=(empty($row->note))? "" : lang("not_enough_funds_on_balance")?></td>
              <td class="text-center">
                <div class="item-action dropdown">
                  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                  <div class="dropdown-menu">
                    <a href="<?=cn("$module/log_update/".$row->ids)?>" class="dropdown-item ajaxModal"><i class="dropdown-icon fe fe-edit"></i> <?=lang('Edit')?> </a>
                    <?php
                      if (get_role('admin')) {
                    ?>
                    <a href="<?=cn("$module/ajax_log_delete_item/".$row->ids)?>" class="dropdown-item ajaxDeleteItem"><i class="dropdown-icon fe fe-trash"></i> <?=lang('Delete')?> </a>
                    <?php } ?>
                  </div>
                </div>
              </td>
              <?php }?>

            </tr>  
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
  <?php; }else{?>
  <div class="col-md-12 data-empty text-center">
    <div class="content">
      <img class="img mb-1" src="<?=BASE?>assets/images/ofm-nofiles.png" alt="empty">
      <div class="title"><?=lang("look_like_there_are_no_results_in_here")?></div>
    </div>
  </div>
  <?php; }?>
</div>
