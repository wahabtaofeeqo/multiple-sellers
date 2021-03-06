<div class="page-header">
    <h1 class="page-title">
        <?php if (get_role('admin')): ?>
          <a href="<?=cn("$module/update")?>" class="ajaxModal"><span class="add-new" data-toggle="tooltip" data-placement="bottom" title="<?=lang("add_new")?>" data-original-title="Add new"><i class="fa fa-plus-square text-primary" aria-hidden="true"></i></span></a>
        <?php endif ?>

        <?php if (!get_role('admin')): ?>
          <i class="fe fe-calendar" aria-hidden="true"> </i>
        <?php endif ?>
        <?=lang("Transaction_logs")?>
    </h1>
</div>

<div class="row" id="result_ajaxSearch">
    <?php if (!empty($transactions)): ?>
        <style type="text/css">
            <?php if (empty($lang_current) && $lang_current->code == 'en'): ?>
                .card-title {
                    width: 100%;
                }
            <?php endif ?>
        </style>
    <?php endif ?>


    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?=lang('Lists')?></h3>

                <div class="card-options">
                    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                    <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered table-outline table-vcenter card-title">
                    <thead>
                       <tr>
                           <?php if (!empty($columns)): ?>
                              <?php foreach ($columns as $key => $row): ?>
                                  <th><?=$row?></th>
                              <?php endforeach ?>
                          <?php endif ?>

                          <?php if (get_role('admin') || get_role('m-seller')): ?>
                               <th class="text-center"><?=lang('Action')?></th>
                          <?php endif ?>
                       </tr>
                    </thead>

                    <tbody>
                        <?php if ($transactions): ?>
                            <?php foreach ($transactions as $key => $row): ?>
                                <tr class="tr_<?=$row->ids?>">
                                    <td><?=($key + 1)?></td>

                                    <?php if (get_role('admin') || get_role('m-seller')): ?>
                                        <td>
                                            <div class="title"><?=get_field('general_users', ["id" => $row->uid], "email")?></div>
                                        </td>
                                    <?php endif ?>

                                     <td>
                                        <?php
                                          switch ($row->transaction_id) {
                                            case 'empty':
                                              if ($row->type == 'manual') {
                                                echo lang($row->transaction_id);
                                              }else{
                                                echo lang($row->transaction_id)." ".lang("transaction_id_was_sent_to_your_email");
                                              }
                                              break;

                                            default:
                                              echo $row->transaction_id;
                                              break;
                                          }
                                      ?>
                                    </td>

                                    <td class="">
                                        <img class="payment" src="<?=BASE?>/assets/images/payments/<?=$row->type?>.png" alt="<?=$row->type?> icon">
                                    </td>
                                    <td><?=get_option("currency_symbol", '')?><?=$row->amount?> </td>
                                    <td><?=convert_timezone($row->created, 'user')?></td>

                                    <td>
                                        <?php
                                          switch ($row->status) {
                                            case 1:
                                                echo '<span class="badge badge-default">'.lang('Paid').'</span>';
                                              break;

                                            case 0:
                                                echo '<span class="badge badge-warning">'.lang("waiting_for_buyer_funds").'</span>';
                                              break; 

                                            case -1:
                                                echo '<span class="badge badge-danger">'.lang('cancelled_timed_out').'</span>';
                                              break;
                                          }
                                        ?>
                                    </td>

                                    <?php if (get_role('admin')): ?>
                                         <td class="text-center">
                                            <div class="item-action dropdown">
                                              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                              <div class="dropdown-menu dropdown-menu-right">
                                                <a href="<?=cn("$module/ajax_delete_item/".$row->ids)?>" class="dropdown-item ajaxDeleteItem"><i class="dropdown-icon fe fe-trash"></i> <?=lang('Delete')?> </a>
                                              </div>
                                            </div>
                                        </td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

     <div class="col-md-12">
      <div class="float-right">
        <?=$links?>
      </div>
    </div>

    <?php if (empty($transactions)): ?>
      <div class="col-md-12 data-empty text-center">
        <div class="content">
          <img class="img mb-1" src="<?=BASE?>assets/images/ofm-nofiles.png" alt="empty">
          <div class="title"><?=lang('look_like_there_are_no_results_in_here')?></div>
        </div>
      </div>
    <?php endif ?>
</div>