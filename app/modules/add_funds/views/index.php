<?php
  // pr(get_payments_method(), 1);
?>

<style>
.select2-container .select2-selection--single{
    height:34px !important;
}
.select2-container--default .select2-selection--single{
         border: 1px solid #ccc !important; 
     border-radius: 0px !important; 
}
#result_ajaxSearch .se_m_seller{
	display:none;
}
.select2-container {
	margin-bottom: 10px;
}
.add-funds{
	width:100%;
}
#lbl_m{
   margin: 10px 2px;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<div class="container-fluid se_m_seller">
    <div class="row justify-content-md-center">
	
      <div class="col-md-8">
	 
        <div class="card">
          <div class="card-header d-flex align-items-center">
		   
		   <form class="col-md-4">
	        <label id="lbl_m" for=""><?=lang('search_multiseller')?></label>
	        <select class="form-control select2" id="get_mseller">
			
	           <option><?=lang('select')?></option> 
			   <?php
					foreach($mSellers as $seller){
								 
				?>
				<option value="<?=$seller['id']?>"> <?=$seller['first_name'].'  '.$seller['last_name']?></option>
               
			   <?php }?>
	        </select>
	    </form>
		  
		  </div>
</div>
</div>
</div>
</div>

<?php

 if (!empty(trim($mSelle))):	  

?>	  
<section class="add-funds">   
  <div class="container-fluid">
    <div class="row justify-content-md-center" id="result_ajaxSearch">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <div class="tabs-list">
              <ul class="nav nav-tabs">
                <?php
                  if (!get_option("is_active_paypal_".$mSelle) && !get_option("is_active_stripe_".$mSelle) && !get_option("is_active_2checkout_".$mSelle) && !get_option("is_active_manual_".$mSelle)) {
                ?>
                <li class="m-t-10">
                  <a class="active show" data-toggle="tab" href="#payment_null"><?=lang("payment_gateway")?></a>
                </li>
                <?php }?>

                <?php
                if (get_option("is_active_paypal_".$mSelle)) {
                ?>
                <li class="m-t-10">
                  <a class="active show" data-toggle="tab" href="#paypal"><i class="fa fa-cc-paypal"></i> <?=lang("Paypal")?></a>
                </li>
                <?php }?>

                <?php
                if (get_option("is_active_stripe_".$mSelle)) {
                ?>
                <li class="m-t-10">
                  <a data-toggle="tab" href="#stripe"><i class="fa fa-cc-stripe"></i> <?=lang("Stripe")?></a>
                </li>
                <?php }?>

                <?php
                if (get_option("is_active_2checkout_".$mSelle)) {
                ?>
                <li class="m-t-10">
                  <a data-toggle="tab" href="#2checkout"><i class="fa fa-credit-card"></i> <?=lang("2Checkout")?></a>
                </li> 
                <?php }?>
                <input type="hidden" name="payment_user" value="<?=$mSelle?>">
                <?php
                    $payments_method = get_payments_method();
                    if (!empty($payments_method) && is_array($payments_method)) {
                      foreach ($payments_method as $payment) {
                        if (payment_method_exists($payment) && get_option('is_active_'.$payment)) {
                ?>
                <li class="m-t-10">
                  <a class="text-capitalize" data-toggle="tab" href="#<?=$payment?>"><i class="fa fa-credit-card"></i> <?=$payment?></a>
                </li>
                <?php }}} ?>

                <?php
                if (get_option("is_active_manual_".$mSelle)) {
                ?>
                <li class="m-t-10">
                  <a data-toggle="tab" href="#manual"><i class="fa fa-hand-o-right"></i> <?=lang("manual_payment")?></a>
                </li>
                <?php }?>

              </ul>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">

              <?php
                  if (!get_option("is_active_paypal_".$mSelle) && !get_option("is_active_stripe_".$mSelle) && !get_option("is_active_2checkout_".$mSelle) && !get_option("is_active_manual_".$mSelle)) {
                ?>
                <div id="payment_null" class="tab-pane fade in active show">
                    <div class="row">
                      <div class="col-md-12">
                        
                        <div class="form-group">
                          <div class="alert alert-danger p-t-10" role="alert">
                            <?=lang("there_is_no_any_payment_gateway_at_the_present")?>
                          </div>
                        </div>

                      </div>  
                    </div>
                </div>
              <?php }?>

              <?php
                if (get_option("is_active_paypal_".$mSelle)) {
              ?>
              <div id="paypal" class="tab-pane fade in active show">
                <form class="form actionForm" action="<?=cn($module."/process")?>" data-redirect="<?=cn($module."/paypal/create_payment")?>" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <?php 
                        if (get_option("paypal_client_id_".$mSelle, '') != "" && get_option("paypal_client_secret_".$mSelle, '') != "") {
                      ?>
                      <div class="for-group text-center">
                        <img src="<?=BASE?>/assets/images/paypal.svg" alt="Paypay icon">
                        <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Paypal')?></small></p>
                      </div>

                      <div class="form-group">
                        <label><?=sprintf(lang("amount_usd"), get_option("currency_code_".$mSelle,'USD'))?></label>
                        <input class="form-control square" type="number" name="amount" placeholder="<?=get_option('currency_symbol_'.$mSelle, "$").get_option('payment_transaction_min_'.$mSelle)?>">
                        <input type="hidden" name="payment_method" value="paypal">
                      </div>                      

                      <div class="form-group">
                        <small class=""><?=lang("transaction_fee")?>: <?=lang("4.4% + 0.3$")?></small>
                      </div>

                      <div class="form-group">
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" name="agree" value="1">
                          <span class="custom-control-label"><?=lang("yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback")?></span>
                        </label>
                      </div>
                      <input type="hidden" name="payment_user" value="<?=$mSelle?>">
                      <div class="form-actions left">
                        <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">
                          <?=lang("Pay")?>
                        </button>
                      </div>

                      <?php }else{?>
                      <div class="form-group">
                        <div class="alert alert-danger p-t-10" role="alert">
                          <?=lang("this_payment_gateway_is_not_already_active_at_the_present")?>
                        </div>
                      </div>
                      <?php }?>

                    </div>  
                  </div>
                </form>
              </div>
              <?php }?>

              <?php
                if (get_option("is_active_stripe_".$mSelle)) {
              ?>
              <div id="stripe" class="tab-pane fade">
                <form class="form actionForm" action="<?=cn($module."/process")?>" data-redirect="<?=cn($module."/stripe_form")?>" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <?php 
                        if (get_option("stripe_secret_key_".$mSelle, '') != "" && get_option("stripe_publishable_key_".$mSelle, '') != "") {
                      ?>
                      <div class="for-group text-center">
                        <img src="<?=BASE?>/assets/images/payments/stripe-dark.svg" alt="Stripe icon">
                        <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Stripe')?></small></p>
                      </div>

                      <div class="form-group">
                        <label><?=sprintf(lang("amount_usd"), get_option("currency_code_".$mSelle,'USD'))?></label>
                        <input class="form-control square" type="number" name="amount" placeholder="<?=get_option('currency_symbol_'.$mSelle, "$").get_option('payment_transaction_min_'.$mSelle)?>" id="">
                        <input type="hidden" name="payment_method" value="stripe">
                      </div>

                      <div class="form-group">
                        <small class=""><?=lang("transaction_fee")?>: <?=lang("4.4% + 0.3$")?></small>
                      </div>

                      <div class="form-group">
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" name="agree" value="1">
                          <span class="custom-control-label"><?=lang("yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback")?></span>
                        </label>
                      </div>
                       <input type="hidden" name="payment_user" value="<?=$mSelle?>">
                      <div class="form-actions left">
                        <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">
                          <?=lang("Pay")?>
                        </button>
                      </div>
                      <?php }else{?>
                      <div class="form-group">
                        <div class="alert alert-danger p-t-10" role="alert">
                          <?=lang("this_payment_gateway_is_not_already_active_at_the_present")?>
                        </div>
                      </div>
                      <?php }?>
                    </div> 
                  </div> 
                </form>
              </div>
              <?php }?>

              <?php
                if (get_option("is_active_2checkout_".$mSelle)) {
              ?>
              <div id="2checkout" class="tab-pane fade">
                <form class="form actionForm" action="<?=cn($module."/process")?>" data-redirect="<?=cn($module."/two_checkout_form")?>" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <?php 
                        if (get_option("2checkout_publishable_key_".$mSelle, '') != "" && get_option("2checkout_private_key_".$mSelle, '') != "" && get_option("2checkout_seller_id_".$mSelle, '') != "") {
                      ?>
                      <div class="for-group text-center">
                        <img src="<?=BASE?>/assets/images/2checkout.svg" alt="2checkout icon">
                        <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), '2Checkout')?></small></p>
                      </div>

                      <div class="form-group">
                        <label><?=sprintf(lang("amount_usd"), get_option("currency_code_".$mSelle,'USD'))?></label>
                        <input class="form-control square" type="number" name="amount" placeholder="<?=get_option('currency_symbol_'.$mSelle, "$").get_option('payment_transaction_min_'.$mSelle)?>" id="">
                        <input type="hidden" name="payment_method" value="two_checkout">
                      </div>


                      <div class="form-group">
                        <small class=""><?=lang("transaction_fee")?>: <?=lang("4.4% + 0.3$")?></small>
                      </div>

                      <div class="form-group">
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" name="agree" value="1">
                          <span class="custom-control-label"><?=lang("yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback")?></span>
                        </label>
                      </div>
                      <input type="hidden" name="payment_user" value="<?=$mSelle?>">
                      <div class="form-actions left">
                        <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">
                          Pay
                        </button>
                      </div>
                      <?php }else{?>
                      <div class="form-group">
                        <div class="alert alert-danger p-t-10" role="alert">
                          <?=lang("this_payment_gateway_is_not_already_active_at_the_present")?>
                        </div>
                      </div>
                      <?php }?>
                    </div>  
                  </div>
                </form>
              </div>
              <?php }?>

              <?php
                $payments_method = get_payments_method();
                if (!empty($payments_method) && is_array($payments_method)) {
                  foreach ($payments_method as $payment) {
                    if (payment_method_exists($payment) && get_option('is_active_'.$payment)) {
                      $data = array(
                        'module' => $module
                      );
                      $this->load->view($payment.'/index', $data);
                    }
                  }
                }
              ?>
              <?php
                if (get_option("is_active_manual_".$mSelle)) {
              ?>
              <div id="manual" class="tab-pane fade">
                <form class="form actionForm" action="#" data-redirect="<?=cn($module."/log")?>" method="POST">
                  <div class="row">
                    <div class="col-md-12">

                      <div class="form-group">
                        <p class="p-t-10">
                        <?=lang("you_can_make_a_manual_payment_to_cover_an_outstanding_balance_you_can_use_any_payment_method_in_your_billing_account_for_manual_once_done_open_a_ticket_and_contact_with_administrator")?>
                        </p>
                      </div>

                    </div> 
                  </div> 
                </form>
              </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

   <?php else: ?>

<section class="add-funds">   
  <div class="container-fluid">
    <div class="row justify-content-md-center" id="result_ajaxSearch">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <div class="tabs-list">
              <ul class="nav nav-tabs">
                <?php
                  if (!get_option("is_active_paypal") && !get_option("is_active_stripe") && !get_option("is_active_2checkout") && !get_option("is_active_manual")) {
                ?>
                <li class="m-t-10">
                  <a class="active show" data-toggle="tab" href="#payment_null"><?=lang("payment_gateway")?></a>
                </li>
                <?php }?>

                <?php
                if (get_option("is_active_paypal")) {
                ?>
                <li class="m-t-10">
                  <a class="active show" data-toggle="tab" href="#paypal"><i class="fa fa-cc-paypal"></i> <?=lang("Paypal")?></a>
                </li>
                <?php }?>

                <?php
                if (get_option("is_active_stripe")) {
                ?>
                <li class="m-t-10">
                  <a data-toggle="tab" href="#stripe"><i class="fa fa-cc-stripe"></i> <?=lang("Stripe")?></a>
                </li>
                <?php }?>

                <?php
                if (get_option("is_active_2checkout")) {
                ?>
                <li class="m-t-10">
                  <a data-toggle="tab" href="#2checkout"><i class="fa fa-credit-card"></i> <?=lang("2Checkout")?></a>
                </li> 
                <?php }?>
              
                <?php
                    $payments_method = get_payments_method();
                    if (!empty($payments_method) && is_array($payments_method)) {
                      foreach ($payments_method as $payment) {
                        if (payment_method_exists($payment) && get_option('is_active_'.$payment)) {
                ?>
                <li class="m-t-10">
                  <a class="text-capitalize" data-toggle="tab" href="#<?=$payment?>"><i class="fa fa-credit-card"></i> <?=$payment?></a>
                </li>
                <?php }}} ?>

                <?php
                if (get_option("is_active_manual")) {
                ?>
                <li class="m-t-10">
                  <a data-toggle="tab" href="#manual"><i class="fa fa-hand-o-right"></i> <?=lang("manual_payment")?></a>
                </li>
                <?php }?>

              </ul>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">

              <?php
                  if (!get_option("is_active_paypal") && !get_option("is_active_stripe") && !get_option("is_active_2checkout") && !get_option("is_active_manual")) {
                ?>
                <div id="payment_null" class="tab-pane fade in active show">
                    <div class="row">
                      <div class="col-md-12">
                        
                        <div class="form-group">
                          <div class="alert alert-danger p-t-10" role="alert">
                            <?=lang("there_is_no_any_payment_gateway_at_the_present")?>
                          </div>
                        </div>

                      </div>  
                    </div>
                </div>
              <?php }?>

              <?php
                if (get_option("is_active_paypal")) {
              ?>
              <div id="paypal" class="tab-pane fade in active show">
                <form class="form actionForm" action="<?=cn($module."/process")?>" data-redirect="<?=cn($module."/paypal/create_payment")?>" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <?php 
                        if (get_option("paypal_client_id", '') != "" && get_option("paypal_client_secret", '') != "") {
                      ?>
                      <div class="for-group text-center">
                        <img src="<?=BASE?>/assets/images/paypal.svg" alt="Paypay icon">
                        <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Paypal')?></small></p>
                      </div>

                      <div class="form-group">
                        <label><?=sprintf(lang("amount_usd"), get_option("currency_code",'USD'))?></label>
                        <input class="form-control square" type="number" name="amount" placeholder="<?=get_option('currency_symbol', "$").get_option('payment_transaction_min')?>">
                        <input type="hidden" name="payment_method" value="paypal">
                      </div>                      

                      <div class="form-group">
                        <small class=""><?=lang("transaction_fee")?>: <strong><?=(get_option("paypal_chagre_fee", 4))?>% + <?=lang("0.3$")?></strong></small>
                      </div>

                      <div class="form-group">
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" name="agree" value="1">
                          <span class="custom-control-label"><?=lang("yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback")?></span>
                        </label>
                      </div>
                      
                      <div class="form-actions left">
                        <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">
                          <?=lang("Pay")?>
                        </button>
                      </div>

                      <?php }else{?>
                      <div class="form-group">
                        <div class="alert alert-danger p-t-10" role="alert">
                          <?=lang("this_payment_gateway_is_not_already_active_at_the_present")?>
                        </div>
                      </div>
                      <?php }?>

                    </div>  
                  </div>
                </form>
              </div>
              <?php }?>

              <?php
                if (get_option("is_active_stripe")) {
              ?>
              <div id="stripe" class="tab-pane fade">
                <form class="form actionForm" action="<?=cn($module."/process")?>" data-redirect="<?=cn($module."/stripe_form")?>" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <?php 
                        if (get_option("stripe_secret_key", '') != "" && get_option("stripe_publishable_key", '') != "") {
                      ?>
                      <div class="for-group text-center">
                        <img src="<?=BASE?>/assets/images/payments/stripe-dark.svg" alt="Stripe icon">
                        <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), 'Stripe')?></small></p>
                      </div>

                      <div class="form-group">
                        <label><?=sprintf(lang("amount_usd"), get_option("currency_code",'USD'))?></label>
                        <input class="form-control square" type="number" name="amount" placeholder="<?=get_option('currency_symbol', "$").get_option('payment_transaction_min')?>" id="">
                        <input type="hidden" name="payment_method" value="stripe">
                      </div>

                      <div class="form-group">
                        <small class=""><?=lang("transaction_fee")?>: <strong><?=(get_option("stripe_chagre_fee", 4))?>% + <?=lang("0.3$")?></strong></small>
                      </div>

                      <div class="form-group">
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" name="agree" value="1">
                          <span class="custom-control-label"><?=lang("yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback")?></span>
                        </label>
                      </div>
                      
                      <div class="form-actions left">
                        <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">
                          <?=lang("Pay")?>
                        </button>
                      </div>
                      <?php }else{?>
                      <div class="form-group">
                        <div class="alert alert-danger p-t-10" role="alert">
                          <?=lang("this_payment_gateway_is_not_already_active_at_the_present")?>
                        </div>
                      </div>
                      <?php }?>
                    </div> 
                  </div> 
                </form>
              </div>
              <?php }?>

              <?php
                if (get_option("is_active_2checkout")) {
              ?>
              <div id="2checkout" class="tab-pane fade">
                <form class="form actionForm" action="<?=cn($module."/process")?>" data-redirect="<?=cn($module."/two_checkout_form")?>" method="POST">
                  <div class="row">
                    <div class="col-md-12">
                      <?php 
                        if (get_option("2checkout_publishable_key", '') != "" && get_option("2checkout_private_key", '') != "" && get_option("2checkout_seller_id", '') != "") {
                      ?>
                      <div class="for-group text-center">
                        <img src="<?=BASE?>/assets/images/2checkout.svg" alt="2checkout icon">
                        <p class="p-t-10"><small><?=sprintf(lang("you_can_deposit_funds_with_paypal_they_will_be_automaticly_added_into_your_account"), '2Checkout')?></small></p>
                      </div>

                      <div class="form-group">
                        <label><?=sprintf(lang("amount_usd"), get_option("currency_code",'USD'))?></label>
                        <input class="form-control square" type="number" name="amount" placeholder="<?=get_option('currency_symbol', "$").get_option('payment_transaction_min')?>" id="">
                        <input type="hidden" name="payment_method" value="two_checkout">
                      </div>


                      <div class="form-group">
                        <small class=""><?=lang("transaction_fee")?>: <strong><?=(get_option("twocheckout_chagre_fee", 4))?>% + <?=lang("0.3$")?></strong></small>
                      </div>

                      <div class="form-group">
                        <label class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" name="agree" value="1">
                          <span class="custom-control-label"><?=lang("yes_i_understand_after_the_funds_added_i_will_not_ask_fraudulent_dispute_or_chargeback")?></span>
                        </label>
                      </div>
                      
                      <div class="form-actions left">
                        <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">
                          Pay
                        </button>
                      </div>
                      <?php }else{?>
                      <div class="form-group">
                        <div class="alert alert-danger p-t-10" role="alert">
                          <?=lang("this_payment_gateway_is_not_already_active_at_the_present")?>
                        </div>
                      </div>
                      <?php }?>
                    </div>  
                  </div>
                </form>
              </div>
              <?php }?>

              <?php
                $payments_method = get_payments_method();
                if (!empty($payments_method) && is_array($payments_method)) {
                  foreach ($payments_method as $payment) {
                    if (payment_method_exists($payment) && get_option('is_active_'.$payment)) {
                      $data = array(
                        'module' => $module
                      );
                      $this->load->view($payment.'/index', $data);
                    }
                  }
                }
              ?>

              <?php
                if (get_option("is_active_manual")) {
              ?>
              <div id="manual" class="tab-pane fade">
                <form class="form actionForm" action="#" data-redirect="<?=cn($module."/log")?>" method="POST">
                  <div class="row">
                    <div class="col-md-12">

                      <div class="form-group">
                        <p class="p-t-10">
                        <?=lang("you_can_make_a_manual_payment_to_cover_an_outstanding_balance_you_can_use_any_payment_method_in_your_billing_account_for_manual_once_done_open_a_ticket_and_contact_with_administrator")?>
                        </p>
                      </div>

                    </div> 
                  </div> 
                </form>
              </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

   <?php endif; ?>
 <script>
    $('.select2').select2();
	
	$(document).on("change", "#get_mseller" , function(){
            event.preventDefault();
            _that       = $(this);
            _id         = _that.val();
            if (_id == "") {
                return;
            }
			
            _action     ='https://10.192.run/add_funds/set_funds';
            _data       = $.param({token:token,id:_id});
            $.post( _action, _data,function(_result){
                setTimeout(function () {
                    $("#result_ajaxSearch").html(_result);
                }, 100);
            }); 
        });
</script>

