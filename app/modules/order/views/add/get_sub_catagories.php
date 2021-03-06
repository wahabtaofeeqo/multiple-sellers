<label><?=lang("sub_cat")?></label>
<select name="sub_cate_id" class="form-control square ajaxChangesub_cate" data-url="<?=cn($module."/order/get_second_sub_categories_by_cat/")?>">
  <option> <?=lang("choose_a_sub_category")?></option>
  <?php
    if (!empty($subcategories)) {
      $service_item_default = $subcategories[0];
      foreach ($subcategories as $key => $subcategory) {
  ?>
  <option value="<?=$subcategory->id?>" ><?=$subcategory->name?> </option>
  <?php }}?>
</select>
