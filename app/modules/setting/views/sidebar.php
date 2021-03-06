    <div class="card sidebar">
      <div class="card-body o-auto">
        <div class="item mt-2">
          <div class="title"><?=lang("general_settings")?></div>
          <ul class="list-unstyled">
            <?php if(get_role("admin") ||  get_role("supporter")){ ?>
            <li class="active"><a href="<?=cn($module."/ajax_get_contents/website_setting")?>" class="ajaxGetContents" data-content="website_setting"><?=lang("website_setting")?></a></li>

            <li><a href="<?=cn($module."/ajax_get_contents/website_logo")?>"  class="ajaxGetContents" data-content="website_logo"><?=lang("Logo")?></a></li>

            <li><a href="<?=cn($module."/ajax_get_contents/terms_policy")?>" class="ajaxGetContents" data-content="terms_policy"><?=lang("terms__policy_page")?></a></li>
			<li><a href="<?=cn($module."/ajax_get_contents/about_us")?>" class="ajaxGetContents" data-content="about_us"><?=lang("about_us_page")?></a></li>

            <?php }?>
            <li <?php if(get_role("m-seller")){ ?> class="active" <?php }?>><a href="<?=cn($module."/ajax_get_contents/default_setting")?>" class="ajaxGetContents" data-content="default_setting"><?=lang("default_setting")?></a></li>
            
            <li><a href="<?=cn($module."/ajax_get_contents/currency")?>" class="ajaxGetContents" data-content="currency"><?=lang("currency_setting")?></a></li>
            <?php if(get_role("admin") ||  get_role("supporter")){ ?>
            <li><a href="<?=cn($module."/ajax_get_contents/other")?>" class="ajaxGetContents" data-content="other"><?=lang("Other")?></a></li>
            <?php }?>
          </ul>
        </div>

        <div class="item mt-2">
          <div class="title"><?=lang("Email")?></div>
          <ul class="list-unstyled">
            <li><a href="<?=cn($module."/ajax_get_contents/email_setting")?>" class="ajaxGetContents" data-content="email_setting"><?=lang("email_setting")?></a></li>
            <?php if(get_role("admin") ||  get_role("supporter")){ ?>
                <li><a href="<?=cn($module."/ajax_get_contents/email_template")?>"  class="ajaxGetContents" data-content="email_template"><?=lang("email_template")?></a></li>
            <?php }?>
          </ul>
        </div>

        <div class="item mt-2">
          <div class="title"><?=lang("integrations")?></div>
          <ul class="list-unstyled">

            <li><a href="<?=cn($module."/ajax_get_contents/payment")?>" class="ajaxGetContents" data-content="payment"><?=lang("Payment")?></a></li>

            <?php
              $payments_method = get_payments_method();
              if (!empty($payments_method) && is_array($payments_method)) {
                foreach ($payments_method as $payment) {
                  if (payment_method_exists($payment)) {
            ?>
            <li><a href="<?=cn($module."/ajax_get_contents/".$payment)?>" class="ajaxGetContents text-capitalize" data-content="<?=$payment?>"><?=$payment?></a></li>
            <?php }}} ?>

          </ul>
        </div>
      </div>
    </div>