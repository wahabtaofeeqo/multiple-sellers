<?php 
$api_provider_list=get_api_lists_common(true);
$lang_current = get_lang_code_defaut();

?>
<style>
input[name="attach_file"] {
		padding: 4px 5px;
		border: 1px solid #e0e0e0;
	}
	.file_ups
	{   
		left:12px;
		position: absolute;
		background: #fff;
		border: 1px solid #dedede;
		font-family: inherit;
	}
	@media only screen and (max-width: 500px) {
		
		.file_ups{
			margin-left:0px;
			  width:111px;
		}
		
		input[name="attach_file"]{
            padding: 4px 22px !important;
        } 
	}
<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
	.dropdown-item{
	text-align:left;

	}

<?php; }else{ ?> 
	.dropdown-item{
		text-align:right;
	}
	input[name="attach_file"] {
		padding: 4px 5px;
		border: 1px solid #e0e0e0;
	}
	.file_ups
	{   
		left:12px;
		position: absolute;
		background: #fff;
		border: 1px solid #dedede;
		font-family: inherit;
		width:95px;
	}
	@media only screen and (max-width: 500px) {
		
		.file_ups{
			margin-left:0px;
			  width:111px;
		}
	}
	 

<?php if(!empty($lang_current) && $lang_current->code == 'en'){ ?>

<?php }else{ ?> 

.dropdown-menu.show{
direction: rtl;
text-align: right;
}

	.file_ups
	{   
		
		position: absolute;
		background: #fff;
		border: 1px solid #dedede;
		font-family: inherit; 
		right: 11px !important;
		width: 89px;
		margin: 0px;
		left: auto;
		
	}
	
	@media only screen and (max-width: 500px) {
		
		.file_ups{

			  width:111px;
		}
		
	}

<?php } ?>

.charts{
direction: ltr !important;

text-align: right !important;
}

.card-header{
direction: ltr !important;

text-align: right !important;
}

.card-options{
direction: ltr !important;
text-align: left !important;

}

.card-options-collapse {
direction: ltr !important;
text-align: left !important;

}


.card-options-remove
{
direction: ltr !important;
text-align: left !important;

}

.card-remove
{
direction: ltr !important;
text-align: left !important;

}

.card-collapse {
direction: ltr !important;
text-align: left !important;

}



.item{
direction: ltr !important;

text-align: left !important;
}
<?php; } ?>
</style>
<? if(!empty($lang_current) && $lang_current->code != 'en'){ ?>

<style>
.area_2 .card-options {
  margin-left: -100%;
}
.area_2 .card-title{
 margin-left: 87%;	
}
.fe-list{
  float: right;
    margin-left: 5px;	
}
.d-sm-block .card-title{
 margin-left:40%;	
}

.fe-edit{
  float: right;
    margin-left: 5px;	
}

				 
</style>
<? } ?>
<section class="page-title">

  <div class="row justify-content-between area_1">

    <div class="col-md-6">

      <h1 class="page-title d-flex">

        <a class="d-none" href="<?=cn("$module/add")?>" class="d-inline-block d-sm-none ajaxModal "><span class="add-new" data-toggle="tooltip" data-placement="bottom" title="<?=lang("add_new")?>" data-original-title="Add new"><i class="fe fe-plus-square text-primary" aria-hidden="true"></i></span></a> 

        <span class="d-none d-sm-block"><i class="fa fa-comments-o text-primary" aria-hidden="true"></i></span> 

        &nbsp;<?=lang("Tickets")?>

      </h1>

    </div>

    <div class="col-md-2">

      <div class="form-group ">

        <select  name="status" class="form-control order_by ajaxChange" data-url="<?=cn($module."/ajax_order_by/")?>">

          <option value="all"> <?=lang("sort_by")?></option>

          <option value="all"> <?=lang("All")?></option>

          <?php 

            $status_array = ticket_status_array();

            if (!empty($status_array)) {

              foreach ($status_array as $row_status) {

          ?>

          <option value="<?=$row_status?>"><?=ticket_status_title($row_status)?></option>

          <?php }}?>

        </select>

      </div>

    </div>

  </div>

</section>



<div class="row justify-content-end area_2">

  <div class="col-md-5 d-block d-sm-block">

    <div class="card">

      <div class="card-header">

        <h3 class="card-title">

          <h4 class="modal-title"><i class="fe fe-edit"></i> <?=lang("add_new_ticket")?></h4>

        </h3>

        <div class="card-options">

          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>

          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>

        </div>

      </div>



      <div class="card-body o-auto" style="height: calc(100vh - 180px);">

        <form class="form actionFormCustom" action="<?=cn($module."/ajax_add")?>" data-redirect="<?=cn($module)?>" method="POST">

          <div class="form-body" id="add_new_ticket">

            <div class="row justify-content-md-center">

              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="form-group">

                  <label><?=lang("Subject")?></label>

                  <select name="subject" class="form-control square ajaxChangeTicketSubject">

                    <option value="subject_order"><?=lang("Order")?></option>

                    <option value="subject_payment"><?=lang("Payment")?></option>

                    <option value="subject_service" <?= ($ticket_data!=0)?'selected':""?>><?=lang("Service")?></option>

                    <option value="subject_other"><?=lang("Other")?></option>

                  </select>

                </div>



                <div class="form-group subject-order <?= ($ticket_data!=0)?'d-none':""?>">

                  <label><?=lang("Request")?></label>

                  <select name="request" class="form-control square">

                    <option value="refill"><?=lang("Refill")?></option>

                    <option value="cancellation"><?=lang("Cancellation")?></option>

                    <option value="speed_up"><?=lang("Speed_Up")?></option>

                    <option value="other"><?=lang("Other")?></option>

                  </select>

                </div>



                <div class="form-group subject-order <?= ($ticket_data!=0)?'d-none':""?>">

                  <label><?=lang("order_id")?></label>

                  <input class="form-control square" type="text" name="orderid" placeholder="<?=lang("for_multiple_orders_please_separate_them_using_comma_example_123451234512345")?>">

                </div>

		<div class="form-group subject-service  <?= ($ticket_data!=0)?'':"d-none"?>">
                  <label><?=lang("service_id")?></label>
                  <?php if($ticket_data !=0){?>
                  <input class="form-control square" type="text" name="serviceid" value="<?= $ticket_data?>" placeholder="<?=lang("for_multiple_orders_please_separate_them_using_comma_example_123451234512345")?>">
                  <?php }else{?>
                  <input class="form-control square" type="text" name="serviceid"  placeholder="<?=lang("")?>">
                  <?php }?>
                </div>

                <div class="form-group subject-payment d-none">

                  <label><?=lang("Payment")?></label>

                  <select name="payment" class="form-control square">

                    <option value="paypal"><?=lang("Paypal")?></option>

                    <option value="stripe"><?=lang("Stripe")?></option>

                    <option value="twocheckout"><?=lang("2Checkout")?></option>

                    <option value="other"><?=lang("Other")?></option>

                  </select>

                </div>



                <div class="form-group subject-payment d-none">

                  <label><?=lang("Transaction_ID")?></label>

                  <input class="form-control square" type="text" name="transaction_id" placeholder="<?=lang("enter_the_transaction_id")?>">

                  </select>

                </div>
		<?php if(get_role("admin")){?>
                <div class="form-group subject-payment-other d-none">
                  <label><?=lang("send_to")?></label>
                  <select name="api_sender" class="form-control square">
                    <?php foreach($api_provider_list as $api_sender){?>
                      <option value="<?=$api_sender["id"]?>"><?=$api_sender["name"]?></option>
                    <?php }?>
                  </select>
                </div>
                <?php }?>

              </div> 

              

              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="form-group">

                  <label><?=lang("Description")?></label>

                  <textarea rows="3" id="editor" class="form-control square" name="description"></textarea>
				  <label for="myfile" class="btn file_ups"><?=lang("Choose File")?></label>
				  <input type="file" id="myfile"  name="attach_file" class="w-100">
				  

                </div>

              </div>



              <div class="col-md-12 col-sm-12 col-xs-12">

                <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?=lang('Submit')?></button>

              </div>

            </div>

          </div>

        </form>

      </div>

    </div>

  </div>

  <div class="col-md-7">

    <div class="row" id="result_ajaxSearch">

      <div class="col-md-12">

        <div class="card">

          <div class="card-header">

            <h3 class="card-title"><i class="fe fe-list"></i> <?=lang("Lists")?>

            </h3>

            <div class="card-options">

              <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>

              <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>

            </div>

          </div>



          <div class="card-body o-auto" style="height: calc(100vh - 180px);">

            

            <?php if(!empty($tickets)){?>

            <div class="ticket-lists">

              <?php

                $is_admin = get_role('admin');
                $is_user_sm = get_role("m-seller");
                foreach ($tickets as $key => $row) {

                  $short_name_user = '<i class="fe fe-user"></i>';

                  if (!empty($row->first_name)) {

                    $last_name_user = $row->last_name;

                    $first_name_user = $row->first_name;

                    $short_name_user = $first_name_user[0].$last_name_user[0];

                  }

              ?>

              <div class="item tr_<?=$row->ids?>">

                <a href="<?=cn("$module/".$row->id)?>" class="p-l-5 d-flex text-decoration-none">

                  <div class="media-left p-r-10">

                      <span class="avatar avatar-md">

                        <span class="media-object rounded-circle text-circle text-uppercase <?=$row->status?> "><?=$short_name_user?></span>

                      </span>

                  </div>

                  <div class="content">

                    <div class="subject <?=(isset($row->status) && $row->status == "closed") ? "text-muted" : ""?>">

                      <?="#".$row->id." - ".$row->subject?>

                      <?php

                        $is_unread = false;

                        if ($row->status == 'new' && $is_admin && $row->uid !=session("uid")) {

                          $is_unread = true;

                        }

                        if (!$is_unread) {

                          $is_unread = check_unread_ticket($row->id);

                        }

                      ?>

                      <?php if($is_unread){

                      ?>

                      <span class="badge badge-warning"><?=lang("Unread")?></span>

                      <?php }?>

                    </div>

                    <?php 
                      if($is_user_sm){
                      ?>
                      <div class="email"><?=$admin_data->first_name." ".$admin_data->last_name." - ".$admin_data->email;?></div>
                      <?php    
                      }
                      else{
                        ?>
                          <div class="email"><?=$row->sender_first_name." ".$row->sender_last_name." - ".$row->sender_email?></div>   
                        <?php
                      }
                    ?>
                    <!--<div class="email"><?=$row->sender_first_name." ".$row->sender_last_name." - ".$row->sender_email?></div>-->
                    <div class="time">

                      <small><?=convert_timezone($row->changed, 'user')?> </small>

                    </div>

                  </div>

                </a>



                <div class="action item-action dropdown m-t-10">

                  <?php

                    $button_type = "btn-info";

                    if (!empty($row->status)) {

                      switch ($row->status) {

                        case 'pending':

                          $button_type = "btn-primary";

                          break;

                        case 'closed':

                          $button_type = "btn-gray";

                          break;

                        case 'new':

                          $button_type = "btn-info";

                          break;

                      }

                    }

                  ?>

                  <a href="javascript:void(0)"class="m-r-5">

                    <span class="btn round <?=$button_type?> btn-sm"><small><?=ticket_status_title($row->status)?></small>

                    </span>

                  </a>

                  <?php 

                  if(get_role("admin") || get_role('supporter')) {?>

                  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>

                  <div class="dropdown-menu dropdown-menu-right">

                    <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$row->ids)?>" data-status="new" class="ajaxChangeStatus dropdown-item"> <i class="dropdown-icon fe fe-mail"></i> <?=lang("mark_as_new")?></a>



                    <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$row->ids)?>" data-status="pending" class="ajaxChangeStatus dropdown-item"> <i class="dropdown-icon fa fa-envelope-open"></i> <?=lang("mark_as_pending")?></a>



                    <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$row->ids)?>" data-status="closed" class="ajaxChangeStatus dropdown-item"> <i class="dropdown-icon fe fe-unlock"></i> <?=lang("mark_as_closed")?></a>

                    <?php 

                      if (get_role('admin')) {

                    ?>

                    <a href="<?=cn("$module/ajax_delete_item/".$row->ids)?>" class="ajaxDeleteItem dropdown-item"> <i class="dropdown-icon fe fe-trash"></i> <?=lang("Delete")?></a>

                    <?php }?>

                  </div>

                  <?php }?>

                </div>

                <div class="clearfix"></div>

              </div>

              <?php }?>

            </div>

            <?php }else{?>

            <div class="col-md-12 data-empty text-center">

              <div class="content">

                <img class="img mb-1" src="<?=BASE?>assets/images/ofm-nofiles.png" alt="empty">

                <div class="title"><?=lang("look_like_there_are_no_results_in_here")?></div>

              </div>

            </div>

            <?php } ?>  

          </div>

        </div>

      </div>

      <?php if(!empty($tickets)){?>

      <div class="col-md-12">

        <div class="float-right">

          <?=$links?>

        </div>

      </div>

      <?php } ?> 

    </div>

  </div>

</div>



<script src="<?=BASE?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<?php 

$lang_current = get_lang_code_defaut();

?>
<script>


<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
	  CKEDITOR.replace( 'editor', {

    height: 150

  });

<?php; }else{ ?> 
  CKEDITOR.replace( 'editor', {
contentsLangDirection: 'rtl',
    height: 150

  });
<?php; } ?>
</script>


