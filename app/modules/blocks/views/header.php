<?php if(get_role("admin") ||  get_role("supporter") ||  get_role("user") ){ ?>
<div class="header top  py-4">

  <div class="container">

    <div class="d-flex" dir="ltr">

      <a class="" href="<?=cn('statistics')?>">

        <img src="<?=get_option('website_logo_white', BASE."assets/images/logo-white.png")?>" alt="Website logo" style="max-height: 40px;">

      </a>

      <div class="d-flex order-lg-2 ml-auto my-auto">

        <?php

          if (session('uid_tmp')) {

        ?>

        <div class="notifcation m-r-10">

          <a href="<?=cn("blocks/back_to_admin")?>" data-toggle="tooltip" data-placement="bottom" title="<?=lang('Back_to_Admin')?>" class="text-white ajaxBackToAdmin">

            <i class="fe fe-log-out"></i>

          </a>

        </div>

        <?php } ?>

        <?php

          if (get_option("enable_news_announcement") == 1) {

        ?>

        <div class="notifcation">

          <a href="<?=cn("news/ajax_notification")?>" data-toggle="tooltip" data-placement="bottom" title="<?=lang("news__announcement")?>" class="ajaxModal text-white">

            <i class="fe fe-bell"></i>

            <div class="test">

              <span class="nav-unread <?=(isset($_COOKIE["news_annoucement"]) && $_COOKIE["news_annoucement"] == "clicked") ? "" : "change_color"?>"></span>

            </div>

          </a>

        </div>

        <?php }?>





        <div class="dropdown">

          <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">

            <span class="avatar" style="background-image: url(<?=BASE?>assets/images/user-avatar.png)"></span>

            <span class="ml-2 d-none d-lg-block">

              <span class="text-default text-white"><?=lang("Hi")?>, <span class="text-uppercase"><?=get_field(USERS, ["id" => session('uid')], 'first_name')?></span>!</span>

              <small class="text-muted  text-white d-block mt-1">

                <?php

                  // !get_role("admin")

                  if (!get_role("admin")) {

                    
						$balance = get_field(USERS, ["id" => session('uid')], 'balance');
					



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

                    if (empty($balance) || $balance == 0) {

                      $balance = 0.00;

                    }else{

                      $balance = currency_format($balance,  get_option('currency_decimal', 2), $decimalpoint, $separator);

                    }

                ?>

                <?=lang("Balance")?>: <?=get_option('currency_symbol',"$")?><?=$balance?>ggg

                <?php }else{?> 

                  <?=lang("Admin_account")?>

                <?php }?> 

              </small>

            </span>

          </a>

          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

            <a class="dropdown-item" href="<?=cn('profile')?>">

              <i class="dropdown-icon fe fe-user"></i> <?=lang("Profile")?>

            </a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="<?=cn("auth/logout")?>">

              <i class="dropdown-icon fe fe-log-out"></i> <?=lang("Sign_out")?>

            </a>

          </div>

        </div>

      </div>

      <a href="#" class="header-toggler text-white d-lg-none ml-3 ml-lg-0 my-auto" data-toggle="collapse" data-target="#headerMenuCollapse">

        <span class="header-toggler-icon"></span>

      </a>

    </div>

  </div>

</div>

<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">

  <div class="container">

    <div class="row align-items-center">

      <?php

        $array_allow = array('user_block_ip', 'user_logs', 'user_mail_logs', 'services', 'category', 'subscriptions', 'dripfeed', 'users', 'tickets', 'faqs', 'log', 'transactions','aboutus');

        if (in_array(segment(1), $array_allow) || in_array(segment(2), $array_allow)) {

      ?>

      <div class="col-md-3 ml-auto">

        <form class="ajaxSearchItem input-icon my-3 my-lg-0" method="POST" action="<?=cn(segment(1)."/ajax_search/keyword")?>">

          <div class="form-group">

            <div class="input-group">

              <input type="text" class="form-control" name="k" placeholder="<?=lang("Search_for_")?>">

              <span class="input-group-append">

                <button class="btn btn-secondary" type="submit"><i class="fe fe-search"></i></button>

              </span>

            </div>

          </div>

        </form>

      </div>

      <?php }?>

    

      <div class="col-lg order-lg-first">

        <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
             <?php if(in_array("statistics",$menu_permission)){?>
          <li class="nav-item">

            <a href="<?=cn('statistics')?>" class="nav-link <?=(segment(1) == 'statistics')?"active":""?>"><i class="fe fe-bar-chart-2"></i> <?=lang("Statistics")?></a>

          </li>
             <?php }?>
          <?php if(in_array("order",$menu_permission)){?>
          <li class="nav-item">

            <a href="javascript:void(0)" class="nav-link  <?=(segment(1) == 'dripfeed' || segment(1) == 'order' || segment(1) == 'subscriptions')?"active":""?>" data-toggle="dropdown"><i class="fe fe-edit"></i><?=lang('Order')?></a>

            <div class="dropdown-menu dropdown-menu-arrow">

              <a href="<?=cn('order/add')?>" class="dropdown-item "><?=lang("New_order")?></a>

              <a href="<?=cn('order/log')?>" class="dropdown-item "><?=lang("order_logs")?></a>

              <a href="<?=cn('dripfeed')?>" class="dropdown-item "><?=lang("dripfeed")?></a>

              <a href="<?=cn('subscriptions')?>" class="dropdown-item "><?=lang("Subscriptions")?></a>

            </div>

          </li>
          <?php }?>
          <?php

            if (get_role("admin") || get_role("supporter")) {

          ?>
            <?php if(in_array("category",$menu_permission)){?>
            <li class="nav-item">
              <a href="<?=cn('category')?>" class="nav-link <?=(segment(1) == 'category')?"active":""?>"><i class="fa fa-table"></i> <?=lang("Category")?></a>
            </li>
            <?php }?>
          <?php }?>
            
            <?php if(in_array("services",$menu_permission)){?>
                <li class="nav-item dropdown">
                  <a href="<?=cn('services')?>" class="nav-link <?=(segment(1) == 'services')?"active":""?>"><i class="fe fe-list"></i> <?=lang('Services')?></a>
                </li>  
            <?php }?>
          
              <?php if(in_array("support",$menu_permission)){?>   
            <li class="nav-item">
              <a href="javascript:void(0)" class="nav-link <?=(segment(1) == 'tickets' || segment(1) == 'faqs')?"active":""?>" data-toggle="dropdown"><i class="fa fa-comments-o"></i>
                <?=lang('Support')?> <span class="badge badge-info" style="margin-left: 6px;"><?=$total_unread_tickets?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-arrow">
                  <?php if(in_array("tickets",$menu_permission)){?>
                <a href="<?=cn('tickets')?>" class="dropdown-item ">
                  <?=lang("Tickets")?>
                  <span class="badge badge-info" style="margin-left: 6px;"><?=$total_unread_tickets?></span>
                </a>
                  <?php }?>
                <a href="<?=cn('faqs')?>" class="dropdown-item "><?=lang("FAQs")?></a>
              </div>
            </li>
              <?php }?> 
          <?php

            if (get_role("user")) {

          ?>
    
               
          <li class="nav-item dropdown">

            <a href="<?=cn('add_funds')?>" class="nav-link <?=(segment(1) == 'add_funds')?"active":""?>"><i class="fa fa-money"></i> <?=lang("Add_funds")?></a>

          </li>   



          <li class="nav-item dropdown">

            <a href="<?=cn('transactions')?>" class="nav-link <?=(segment(1) == 'transactions')?"active":""?>"><i class="fe fe-calendar"></i> <?=lang("Transaction_logs")?></a>

          </li>

          <?php }?>

          

          <?php if(get_role("admin") || get_role("supporter")){

            $user_manager = array(

              'users',

              'add_funds',

              'transactions',

            );

          ?>
          <?php if(in_array("user_manager_tab",$menu_permission)){?>
          <li class="nav-item">

            <a href="javascript:void(0)" class="nav-link <?=(in_array(segment(1), $user_manager)) ? "active":""?>" data-toggle="dropdown"><i class="fe fe-users"></i><?=lang("user_manager")?></a>

            <div class="dropdown-menu dropdown-menu-arrow">
                
              <a href="<?=cn('users')?>" class="dropdown-item"><?=lang("users")?></a>

              <div class="dropdown-divider"></div>
               <?php if(in_array("payments",$menu_permission)){?>
              <a href="<?=cn('add_funds')?>" class="dropdown-item"><?=lang("Add_funds")?></a>
              <?php }?>
              <a href="<?=cn('transactions')?>" class="dropdown-item"><?=lang("Transaction_logs")?></a>

            </div>

          </li>

          <?php }?>
          <?php }?>

          <?php if(get_role("admin") ||  get_role("supporter")){

            $setting_system = array(

              'setting',

              'api_provider',

              'news',

              'language',

              'module',

            );

          ?>
          <?php if(in_array("system_settings",$menu_permission)){?>
          <li class="nav-item">

            <a href="javascript:void(0)" class="nav-link <?=(in_array(segment(1), $setting_system))?"active":""?>" data-toggle="dropdown"><i class="fe fe-settings"></i><?=lang("system_settings")?></a>

            <div class="dropdown-menu dropdown-menu-arrow">

              <?php if(get_role("admin")){?>
                <?php if(in_array("settings",$menu_permission)){?>
              <a href="<?=cn('setting')?>" class="dropdown-item"><?=lang("Settings")?></a>
               <?php }?>
              <a href="<?=cn('api_provider')?>" class="dropdown-item"><?=lang("API_providers")?></a>

              <div class="dropdown-divider"></div>

              <?php } ?>

              <?php if(get_role("admin") ||  get_role("supporter")){?>

              <a href="<?=cn('news')?>" class="dropdown-item"><?=lang("news__announcement")?></a>

              <a href="<?=cn('language')?>" class="dropdown-item"><?=lang("Language")?></a>

              <?php } ?>



              <?php if(get_role("admin")){?>

              <a href="<?=cn('module')?>" class="dropdown-item"><?=lang("Modules")?></a>

              <a href="https://smartpanel.cf/docs/" class="dropdown-item"><?=lang("Documentation")?></a>

              <?php } ?>

            </div>

          </li>
          <?php } ?>
          <?php } ?>

        </ul>

      </div>

    </div>

  </div>

</div>

<?php } else if(get_role("m-seller")){?>

<div class="header top  py-4">

  <div class="container">

    <div class="d-flex" dir="ltr">

      <a class="" href="<?=cn('statistics')?>">

        <img src="<?=get_option('website_logo_white', BASE."assets/images/logo-white.png")?>" alt="Website logo" style="max-height: 40px;">

      </a>

      <div class="d-flex order-lg-2 ml-auto my-auto">

        <?php

          if (session('uid_tmp')) {

        ?>

        <div class="notifcation m-r-10">

          <a href="<?=cn("blocks/back_to_admin")?>" data-toggle="tooltip" data-placement="bottom" title="<?=lang('Back_to_Admin')?>" class="text-white ajaxBackToAdmin">

            <i class="fe fe-log-out"></i>

          </a>

        </div>

        <?php } ?>

        <?php

          if (get_option("enable_news_announcement") == 1) {

        ?>

        <div class="notifcation">

          <a href="<?=cn("news/ajax_notification")?>" data-toggle="tooltip" data-placement="bottom" title="<?=lang("news__announcement")?>" class="ajaxModal text-white">

            <i class="fe fe-bell"></i>

            <div class="test">

              <span class="nav-unread <?=(isset($_COOKIE["news_annoucement"]) && $_COOKIE["news_annoucement"] == "clicked") ? "" : "change_color"?>"></span>

            </div>

          </a>

        </div>

        <?php }?>





        <div class="dropdown">

          <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">

            <span class="avatar" style="background-image: url(<?=BASE?>assets/images/user-avatar.png)"></span>

            <span class="ml-2 d-none d-lg-block">

              <span class="text-default text-white"><?=lang("Hi")?>, <span class="text-uppercase"><?=get_field(USERS, ["id" => session('uid')], 'first_name')?></span>!</span>

              <small class="text-muted  text-white d-block mt-1">

                <?php

                  // !get_role("admin")

                  if (!get_role("admin")) {

                    
					if (get_role("m-seller")) {
                       $balance = $user_balance_seller;
					}else{
						$balance = get_field(USERS, ["id" => session('uid')], 'balance');
					}


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

                    if (empty($balance) || $balance == 0) {

                      $balance = 0.00;

                    }else{

                      $balance = currency_format($balance,  get_option('currency_decimal', 2), $decimalpoint, $separator);

                    }

                ?>

               <!--  <?=lang("Balance")?>: <?=get_option('currency_symbol',"$")?><?=$balance?> -->

                <?php }else{?> 

                  <?=lang("Admin_account")?>

                <?php }?> 

              </small>

            </span>

          </a>

          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

            <a class="dropdown-item" href="<?=cn('profile')?>">

              <i class="dropdown-icon fe fe-user"></i> <?=lang("Profile")?>

            </a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="<?=cn("auth/logout")?>">

              <i class="dropdown-icon fe fe-log-out"></i> <?=lang("Sign_out")?>

            </a>

          </div>

        </div>

      </div>

      <a href="#" class="header-toggler text-white d-lg-none ml-3 ml-lg-0 my-auto" data-toggle="collapse" data-target="#headerMenuCollapse">

        <span class="header-toggler-icon"></span>

      </a>

    </div>

  </div>

</div>

<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">

  <div class="container">

    <div class="row align-items-center">

      <div class="col-md-3 ml-auto">

        <form class="ajaxSearchItem input-icon my-3 my-lg-0" method="POST" action="<?=cn(segment(1)."/ajax_search/keyword")?>">

          <div class="form-group">

            <div class="input-group">

              <input type="text" class="form-control" name="k" placeholder="<?=lang("Search_for_")?>">

              <span class="input-group-append">

                <button class="btn btn-secondary" type="submit"><i class="fe fe-search"></i></button>

              </span>

            </div>

          </div>

        </form>

      </div>

    

    

      <div class="col-lg order-lg-first">

        <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
            
          <li class="nav-item">

            <a href="<?=cn('statistics')?>" class="nav-link <?=(segment(1) == 'statistics')?"active":""?>"><i class="fe fe-bar-chart-2"></i> <?=lang("Statistics")?></a>

          </li>
          
          <li class="nav-item">

            <a href="javascript:void(0)" class="nav-link  <?=(segment(1) == 'order')?"active":""?>" data-toggle="dropdown"><i class="fe fe-edit"></i><?=lang('Order')?></a>

            <div class="dropdown-menu dropdown-menu-arrow">

              <a href="<?=cn('order/log')?>" class="dropdown-item "><?=lang("order_logs")?></a>

            </div>

          </li>
           
            <li class="nav-item dropdown">
              <a href="<?=cn('services')?>" class="nav-link <?=(segment(1) == 'services')?"active":""?>"><i class="fe fe-list"></i> <?=lang('Services')?></a>
            </li>  
              
            <li class="nav-item">
              <a href="javascript:void(0)" class="nav-link <?=(segment(1) == 'tickets')?"active":""?>" data-toggle="dropdown"><i class="fa fa-comments-o"></i>
                <?=lang('Support')?> <span class="badge badge-info" style="margin-left: 6px;"><?=$total_unread_tickets?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-arrow">
               
                <a href="<?=cn('tickets')?>" class="dropdown-item ">
                  <?=lang("Tickets")?>
                  <span class="badge badge-info" style="margin-left: 6px;"><?=$total_unread_tickets?></span>
                </a>
                
              
              </div>
            </li>
         
          <li class="nav-item dropdown">

            <a href="<?=cn('transactions')?>" class="nav-link <?=(segment(1) == 'transactions')?"active":""?>"><i class="fe fe-calendar"></i> <?=lang("Transaction_logs")?></a>

          </li>

          <?php if(get_role("m-seller")){

            $setting_system = array(

              'setting',

              'api_provider',

              'news',

              'language',

              'module',

            );

          ?>
		  
          <?php if(in_array("system_settings",$menu_permission)){?>
          <li class="nav-item">

            <a href="javascript:void(0)" class="nav-link <?=(in_array(segment(1), $setting_system))?"active":""?>" data-toggle="dropdown"><i class="fe fe-settings"></i><?=lang("system_settings")?></a>

            <div class="dropdown-menu dropdown-menu-arrow">

            <a href="<?=cn('setting')?>" class="dropdown-item"><?=lang("Settings")?></a>
             
			   
			<?php if(in_array("api_provider",$menu_permission)){?> 
                <a href="<?=cn('api_provider')?>" class="dropdown-item"><?=lang("API_providers")?></a>
			<?php }?>
            </div>

          </li>
          <?php } ?>
          <?php } ?>
         
        

        </ul>

      </div>

    </div>

  </div>

</div>

<?php }else {}?>
