
    <div class="card content">
      <div class="card-header">
        <h3 class="card-title"><i class="fe fe-credit-card"></i> <?=lang("payment_integration")?></h3>
      </div>
      <div class="card-body">
        <form class="actionForm" action="<?=cn("$module/ajax_general_settings")?>" method="POST" data-redirect="<?=cn($module."?t=".$tab)?>">
          <div class="row">

            <div class="col-md-12 col-lg-12">
              
              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("transaction_limits")?></h5>
              <div class="form-group">
                <label for="form-label"><?=lang("minimum_amount")?></label>
                <input class="form-control" disabled name="payment_transaction_min_<?=session('uid')?>" value="<?=get_option("payment_transaction_min_".session('uid'), 50)?>">
              </div>

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("Environment")?></h5>
              <div class="form-group">
                <select  name="payment_environment_<?=session('uid')?>" class="form-control square">
                  <option value="sandbox" <?=(get_option("payment_environment_".session('uid'), "sandbox") == 'sandbox')? 'selected': ''?>><?=lang("sandbox_test")?></option>
                  <option value="live" <?=(get_option("payment_environment_".session('uid'), "sandbox") == 'live')? 'selected': ''?>><?=lang("Live")?></option>
                </select>
              </div>

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("Paypal")?></h5>

              <div class="form-group">
                <div class="form-label"><?=lang("Status")?></div>
                <div class="custom-controls-stacked">
                  <label class="custom-control custom-checkbox">
                    <input type="hidden" name="is_active_paypal_<?=session('uid')?>" value="0">
                    <input type="checkbox" class="custom-control-input" name="is_active_paypal_<?=session('uid')?>" value="1" <?=(get_option('is_active_paypal_'.session('uid'), "") == 1)? "checked" : ''?>>
                    <span class="custom-control-label"><?=lang("Active")?></span>
                  </label>
                </div>
              </div>
              <div class="form-group"hidden>
                <label class="form-label"><?=lang("transaction_fee")?></label>
				<label </small> <?=lang("transaction")?> % + <?=lang("0.3_USD")?></strong></small></label>
                <select name="paypal_chagre_fee_<?=session('uid')?>" class="form-control square">
                  <?php
                    for ($i = 0; $i <= 7;  $i += 0.1) {
                  ?>
                  <option value="<?=$i?>" <?=(get_option("paypal_chagre_fee_".session('uid'), 4) == $i)? "selected" : ''?>><?=$i?>%</option>
                  <?php } ?>
                </select>
              </div>


              <div class="form-group">
                <label class="form-label"><?=lang("paypal_client_id")?></label>
                <input class="form-control" name="paypal_client_id_<?=session('uid')?>" value="<?=get_option('paypal_client_id_'.session('uid'),"")?>">
              </div>

              <div class="form-group">
                <label class="form-label"><?=lang("paypal_client_secret")?></label>
                <input class="form-control" name="paypal_client_secret_<?=session('uid')?>" value="<?=get_option('paypal_client_secret_'.session('uid'),"")?>">
              </div>

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("Stripe")?></h5>

              <div class="form-group">
                <div class="form-label"><?=lang("Status")?></div>
                <div class="custom-controls-stacked">
                  <label class="custom-control custom-checkbox">
                    <input type="hidden" name="is_active_stripe_<?=session('uid')?>" value="0">
                    <input type="checkbox" class="custom-control-input" name="is_active_stripe_<?=session('uid')?>" value="1" <?=(get_option('is_active_stripe_'.session('uid'), "") == 1)? "checked" : ''?>>
                    <span class="custom-control-label"><?=lang("Active")?></span>
                  </label>
                </div>
              </div>

              <div class="form-group"hidden>
                <label class="form-label"><?=lang("transaction_fee")?></label>
				<label </small> <?=lang("transaction")?> % + <?=lang("0.3_USD")?></strong></small></label>
                <select name="stripe_chagre_fee_<?=session('uid')?>" class="form-control square">
                  <?php
                    for ($i = 0; $i <= 7;  $i += 0.1) {
                  ?>
                  <option value="<?=$i?>" <?=(get_option("stripe_chagre_fee_".session('uid'), 4) == $i)? "selected" : ''?>><?=$i?>%</option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label class="form-label"><?=lang("publishable_key")?></label>
                <input class="form-control" name="stripe_publishable_key_<?=session('uid')?>" value="<?=get_option('stripe_publishable_key_'.session('uid'),"")?>">
              </div>

              <div class="form-group">
                <label class="form-label"><?=lang("secret_key")?></label>
                <input class="form-control" name="stripe_secret_key_<?=session('uid')?>" value="<?=get_option('stripe_secret_key_'.session('uid'),"")?>">
              </div>

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("2Checkout")?></h5 class="text-info">
              <div class="form-group">
                <div class="form-label"><?=lang("Status")?></div>
                <div class="custom-controls-stacked">
                  <label class="custom-control custom-checkbox">
                    <input type="hidden" name="is_active_2checkout_<?=session('uid')?>" value="0">
                    <input type="checkbox" class="custom-control-input" name="is_active_2checkout_<?=session('uid')?>" value="1" <?=(get_option('is_active_2checkout_'.session('uid'), "") == 1)? "checked" : ''?>>
                    <span class="custom-control-label"><?=lang("Active")?></span>
                  </label>
                </div>
              </div>

              <div class="form-group"hidden>
                <label class="form-label"><?=lang("transaction_fee")?></label>
				<label </small> <?=lang("transaction")?> % + <?=lang("0.3_USD")?></strong></small></label>
                <select name="twocheckout_chagre_fee" class="form-control square">
                  <?php
                    for ($i = 0; $i <= 7;  $i += 0.1) {
                  ?>
                  <option value="<?=$i?>" <?=(get_option("twocheckout_chagre_fee_".session('uid'), 4) == $i)? "selected" : ''?>><?=$i?>%</option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group">
                <label class="form-label"><?=lang("publishable_key")?></label>
                <input class="form-control" name="2checkout_publishable_key_<?=session('uid')?>" value="<?=get_option('2checkout_publishable_key_'.session('uid'),"")?>">
              </div>

              <div class="form-group">
                <label class="form-label"><?=lang("private_key")?></label>
                <input class="form-control" name="2checkout_private_key_<?=session('uid')?>" value="<?=get_option('2checkout_private_key_'.session('uid'),"")?>">
              </div>

              <div class="form-group">
                <label class="form-label"><?=lang("2checkout_account_number_sellerid")?></label>
                <input class="form-control" name="2checkout_seller_id_<?=session('uid')?>" value="<?=get_option('2checkout_seller_id_'.session('uid'),"")?>">
              </div> 

              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("manual_payment")?></h5 class="text-info">
              <div class="form-group">
                <div class="form-label"><?=lang("Status")?></div>
                <div class="custom-controls-stacked">
                  <label class="custom-control custom-checkbox">
                    <input type="hidden" name="is_active_manual_<?=session('uid')?>" value="0">
                    <input type="checkbox" class="custom-control-input" name="is_active_manual_<?=session('uid')?>" value="1" <?=(get_option('is_active_manual_'.session('uid'), "") == 1)? "checked" : ''?>>
                    <span class="custom-control-label"><?=lang("Active")?></span>
                  </label>
                </div>
              </div>

            </div> 
            <div class="col-md-12 col-lg-12">
              <div class="form-footer">
                <button class="btn btn-primary btn-min-width btn-lg text-uppercase"><?=lang("Save")?></button>
              </div>
            </div>

          </div>
        </form>
      </div>
    </div>
