
    <div class="card content">
      <div class="card-header">
        <h3 class="card-title"><i class="fe fe-dollar-sign"></i> <?=lang("currency_setting")?></h3>
      </div>
      <div class="card-body">
        <form class="actionForm" action="<?=cn("$module/ajax_general_settings")?>" method="POST" data-redirect="<?=cn($module."?t=".$tab)?>">
          <div class="row">
            <div class="col-md-12 col-lg-12">

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("currency_setting")?></h5>
              <div class="form-group">
                <label class="form-label"><?=lang("currency_code")?></label>
                <small><?=lang("the_paypal_payments_only_supports_these_currencies")?></small>
                <select  name="currency_code_<?=session('uid')?>" class="form-control square">
                  <?php 
                    $currency_codes = currency_codes();
                    if(!empty($currency_codes)){
                      foreach ($currency_codes as $key => $row) {
                  ?>
                  <option value="<?=$key?>" <?=(get_option("currency_code_".session('uid'), "USD") == $key)? 'selected': ''?>> <?=$key." - ".$row?></option>
                  <?php }}else{?>
                  <option value="USD" selected> USD - United States dollar</option>
                  <?php }?>
                </select>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label><?=lang("currency_symbol")?></label>
                    <input class="form-control" name="currency_symbol_<?=session('uid')?>" value="<?=get_option('currency_symbol_'.session('uid'),"$")?>">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label><?=lang("thousand_separator")?></label>
                    <select  name="currency_thousand_separator_<?=session('uid')?>" class="form-control square">
                      <option value="dot" <?=(get_option('currency_thousand_separator_'.session('uid'), 'comma') == 'dot')? 'selected': ''?>> <?=lang("Dot")?></option>
                      <option value="comma" <?=(get_option('currency_thousand_separator_'.session('uid'), 'comma') == 'comma')? 'selected': ''?>> <?=lang("Comma")?></option>
                      <option value="space" <?=(get_option('currency_thousand_separator_'.session('uid'), 'comma') == 'space')? 'selected': ''?>> <?=lang("Space")?></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label><?=lang("decimal_separator")?></label>
                    <select  name="currency_decimal_separator_<?=session('uid')?>" class="form-control square">
                      <option value="dot" <?=(get_option('currency_decimal_separator_'.session('uid'), 'dot') == 'dot')? 'selected': ''?>> <?=lang("Dot")?></option>
                      <option value="comma" <?=(get_option('currency_decimal_separator_'.session('uid'), 'dot') == 'comma')? 'selected': ''?>> <?=lang("Comma")?></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label><?=lang("currency_decimal_places")?></label>
                    <select  name="currency_decimal_<?=session('uid')?>" class="form-control square">
                      <option value="0" <?=(get_option('currency_decimal_'.session('uid'), 2) == 0)? 'selected': ''?>> 0</option>
                      <option value="1" <?=(get_option('currency_decimal_'.session('uid'), 2) == 1)? 'selected': ''?>> 0.0</option>
                      <option value="2" <?=(get_option('currency_decimal_'.session('uid'), 2) == 2)? 'selected': ''?>> 0.00</option>
                      <option value="3" <?=(get_option('currency_decimal_'.session('uid'), 2) == 3)? 'selected': ''?>> 0.000</option>
                      <option value="4" <?=(get_option('currency_decimal_'.session('uid'), 2) == 4)? 'selected': ''?>> 0.0000</option>
                    </select>
                  </div>
                </div>

              </div>
              
              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("price_percentage_increase")?></h5>
              <div class="row">

                <div class="col-md-4">
                  <div class="form-group">
                    <label><?=lang("use_for_sync_and_bulk_add_services")?></label>
                    <select name="default_price_percentage_increase_<?=session('uid')?>" class="form-control square">
                      <?php
                        for ($i = 0; $i <= 1000; $i++) {
                      ?>
                      <option value="<?=$i?>" <?=(get_option("default_price_percentage_increase_".session('uid'), 30) == $i)? "selected" : ''?>><?=$i?>%</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>  
                <div class="col-md-4">
                  <div class="form-group">
                    <label><?=sprintf(lang('auto_rounding_to_X_decimal_places'), "X")?></label>
                    <select name="auto_rounding_x_decimal_places_<?=session('uid')?>" class="form-control square">
                      <?php
                        for ($i = 1; $i <= 4; $i++) {
                      ?>
                      <option value="<?=$i?>" <?=(get_option("auto_rounding_x_decimal_places_".session('uid'), 2) == $i)? "selected" : ''?>><?=$i?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div> 
              </div>
              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("auto_currency_converter")?></h5>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="custom-switch">
                      <input type="hidden" name="is_auto_currency_convert_<?=session('uid')?>" value="0">
                      <input type="checkbox" name="is_auto_currency_convert_<?=session('uid')?>" class="custom-switch-input" <?=(get_option("is_auto_currency_convert_".session('uid'), 0) == 1) ? "checked" : ""?> value="1">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description"><?=lang("Active")?></span>
                    </label>
                  </div>
                  <div class="form-group">
                    <label class="form-label"><?=lang("currency_rate")?>
                      <small><?=lang("applying_when_you_fetch_sync_all_services_from_smm_providers")?></small></span>
                    </label>
                    <div class="input-group">
                      <span class="input-group-prepend">
                        <span class="input-group-text"><?=lang("1_original_currency")?> =</span>
                      </span>
                      <input type="text" class="form-control text-right" name="new_currecry_rate_<?=session('uid')?>" value="<?=get_option('new_currecry_rate_'.session('uid'), 1)?>">
                      <span class="input-group-append">
                        <span class="input-group-text"><?=lang("new_currency")?></span>
                      </span>
                    </div>
                    <small class="text-muted"><span class="text-danger">*</span> <?=lang("if_you_dont_want_to_change_currency_rate_then_leave_this_currency_rate_field_to_1")?></small>
                  </div>
                </div>
              </div>
              
            </div> 
            <div class="col-md-8">
              <div class="form-footer">
                <button class="btn btn-primary btn-min-width btn-lg text-uppercase"><?=lang("Save")?></button>
              </div>
            </div>

          </div>
        </form>
      </div>
    </div>
