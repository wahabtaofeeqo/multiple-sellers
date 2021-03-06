<?php if(!empty($faqs)){
  foreach ($faqs as $key => $row) {
?>
<div class="col-md-12 col-xl-12 tr_<?=$row->ids?>">
  <div class="card card-collapsed">
    <div class="card-header">
      <h3 class="card-title" data-toggle="card-collapse">
        <?php 
          if(get_role("admin") || get_role("supporter")) {
            if(!empty($row->status) && $row->status == 1) {?>
          <span class="btn btn-round btn-info btn-sm"><?=lang("Active")?></span>
            <?php }else{?>
          <span class="btn btn-round btn-warning btn-sm"><?=lang("Deactive")?></span>
        <?php }}?>
        <?=$row->question?>
      </h3>
      <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        <?php 
          if(get_role("admin") || get_role("supporter")) {
        ?>
        <div class="item-action dropdown">
          <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
          <div class="dropdown-menu dropdown-menu-right">
            <a href="<?=cn("$module/update/".$row->ids)?>" class="dropdown-item ajaxModal"><i class="dropdown-icon fe fe-edit-3"></i> <?=lang("Edit")?> </a>
            <?php 
              if(get_role("admin")) {
            ?>
            <a href="<?=cn("$module/ajax_delete_item/".$row->ids)?>" class="ajaxDeleteItem dropdown-item"><i class="dropdown-icon fe fe-trash"></i> <?=lang("Delete")?></a>
            <?php }?>
          </div>
        </div>
        <?php }?>
      </div>
    </div>
    <div class="card-body">
      <?=$row->answer?>
    </div>
  </div>
</div>
<?php }}else{?>
<div class="col-md-12 data-empty text-center">
  <div class="content">
    <img class="img mb-1" src="<?=BASE?>assets/images/ofm-nofiles.png" alt="empty">
    <div class="title">Look like there are no results in here!</div>
  </div>
</div>
<?php } ?>

<script src="<?=BASE?>assets/js/core.js" type="text/javascript"></script>