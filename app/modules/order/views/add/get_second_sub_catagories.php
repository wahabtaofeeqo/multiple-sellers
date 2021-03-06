<label><?=lang("second_sub_cat")?></label>
<select name="second_sub_cate_id" class="form-control square ajaxChangesecondsub_cate" data-url="<?=cn($module."/order/get_services_by_second_sub_cat/")?>">
  <option> <?=lang("choose_a_sub_category")?></option>
  <?php
    if (!empty($second_subcategories)) {
      $service_item_default = $second_subcategories[0];
      foreach ($second_subcategories as $key => $second_subcategory) {
  ?>
  <option value="<?=$second_subcategory->id?>" ><?=$second_subcategory->name?> </option>
  <?php }}?>
</select>
