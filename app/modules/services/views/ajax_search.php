<?php if (!empty($services)) { ?>
<div class="col-md-12 col-xl-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><?=(isset($cate_name)) ? $cate_name : lang("Lists")?></h3>
      <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
      </div>
    </div>
    <?php if (!empty($services)) {
      $j = 1;
    ?>
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-outline table-vcenter card-table">
        <thead>
          <tr>
            <?php
              if (get_role("admin")|| get_role("m-seller")) {
            ?>
            <th class="text-center w-1">
              <div class="custom-controls-stacked">
                <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input check-all" data-name="chk_<?=$j?>">
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
                  <input type="checkbox" class="custom-control-input chk_<?=$j?>"  name="ids[]" value="<?=$row->ids?>">
                  <span class="custom-control-label"></span>
                </label>
              </div>
            </th>
            <?php }?>
            <td  class="text-center"><?=$row->id?></td>
            <td>
              <div class="title"><?=$row->name?></div>
            </td>
            <?php
              if (get_role("admin") || get_role("supporter")|| get_role("m-seller")) {
            ?>

            <td><?=(!empty($row->add_type) && $row->add_type == "api")? lang("API"): lang('Manual')?></td>
            <td><?=(!empty($row->api_service_id))? $row->api_service_id: ""?></td>
            <td><?=(!empty($row->api_provider_id))? truncate_string($row->api_provider_id, 13) : ""?></td>
            
            <?php }?>

            <td><?=currency_format($row->price, $decimal_places, $decimalpoint, $separator)?></td>
            <td><?=$row->min?> / <?=$row->max?></td>
			<td class="">
			<a href="<?=cn("$module/service_media/".$row->ids)?>" class="ajaxModal">
					  <span class="btn btn-info btn-sm"><?=lang("Media")?></span> 
					</a>
			</td>
            <td class="">
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
            <td class="w-1">
              <?php if(!empty($row->status) && $row->status == 1){?>
                <span class="badge badge-info"><?=lang("Active")?></span>
                  <?php }else{?>
                  <span class="badge badge-warning"><?=lang("Deactive")?></span>
              <?php }?>
            </td>
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
          <?php }}?>
          
        </tbody>
      </table>
    </div>
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
<?php } ?>
