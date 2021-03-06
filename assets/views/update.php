<style>
  .ticket-contents .item .avatar.supporter-icon {
    height: 40px;
  }
</style>
<section class="<?=(isset($module))? $module : ''?> p-t-20">   
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header d-flex align-items-center">
          <h3 class="h4"><i class="fa fa-ticket"></i> <?=lang("Ticket_no")?><?=$ticket->id?></h3>
        </div>
        <div class="card-body">
          <div class="ticket-details">
            <table class="table">
              <tbody>
                <tr>
                  <td scope="row"><?=lang("Status")?></td>
                  <td>
                    <?php
                      $button_type = "info";
                      if (!empty($ticket->status)) {
                        switch ($ticket->status) {
                          case 'pending':
                            $button_type = "primary";
                            break;
                          case 'closed':
                            $button_type = "dark";
                            break;
                          case 'new':
                            $button_type = "info";
                            break;
                        }
                      }
                    ?>
                    <div class="btn-group">
                      <?php 
                        if (get_role("admin") || get_role('supporter')) {
                      ?>
                      <div class="dropdown">
                        <button  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle btn round btn-<?=$button_type?> dropdown-toggle btn-sm">
                          <span class="p-r-5 p-l-5"><?=ticket_status_title($ticket->status)?> </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right has-shadow">

                          <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$ticket->ids)?>" data-status="closed" class="ajaxChangeStatus dropdown-item"><?=lang("submit_as_closed")?></a>
                          <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$ticket->ids)?>" data-status="pending" class="ajaxChangeStatus dropdown-item"><?=lang("submit_as_pending")?></a>
                          <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$ticket->ids)?>" data-status="new" class="ajaxChangeStatus dropdown-item"><?=lang("submit_as_new")?></a>
                        </div>

                      </div>
                      <?php }else{?>
                        <span class="btn round btn-<?=$button_type?> btn-sm"><?=ticket_status_title($ticket->status)?>
                        </span>
                      <?php }?>
                    </div>
                  </td>
                </tr>


                <tr>
                  <td scope="row"><?=lang("Created")?></td>
                  <td><?=(!empty($ticket->created)) ? convert_timezone($ticket->created, 'user'): "" ?></td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-header d-flex align-items-center">
          <h3 class="h4"></i> <?=$ticket->subject?></h3>
        </div>
        <div class="card-body">
          <div class="ticket-contents">
         
            <div class="item p-l-5 d-flex">
              <div class="media-left pr-1">
                <span class="avatar avatar-md"hidden>
                    <span class="media-object rounded-circle text-circle "><?=$short_name_user?></span>
                </span>
              </div>
              <div class="content">
                <div class="username"hidden>
                  <?=(!empty($ticket->first_name)) ? $ticket->first_name. " ".$ticket->last_name: ""?>
                  <span class="text-muted time"><?=(!empty($ticket->created)) ? convert_timezone($ticket->created, 'user'): "" ?></span>
                </div>
                <div class="message p-t-10">
                    <div><?=(!empty($ticket->description)) ? $ticket->description: "" ?></div>
                    <div>
                        <?php
                          if($ticket->file_link !="" && $ticket->file_link !="NULL"){
                              $file_name=explode("/assets/uploads/ticket_file/",$ticket->file_link);
                              ?>
                        <a href="<?=$ticket->file_link?>" download><?=$file_name[1]?></a>
                          <?php }
                        ?>
                    </div>
                </div>
              </div>
            </div>
            
            <?php
              if (!empty($ticket_content)) {
                foreach ($ticket_content as $key => $row) {
                  $short_name = "U";
                  if (!empty($row->first_name)) {
                    $last_name = $row->last_name;
                    $first_name = $row->first_name;
                    $short_name = $first_name[0].$last_name[0];
                  }
            ?>
            <div class="item p-l-5 d-flex">
              <div class="media-left pr-1">
                <?php
                  if ($row->role != 'supporter') {
                ?>
                <span class="avatar avatar-md">
                    <span class="media-object rounded-circle text-uppercase text-circle <?=(!empty($row->role) && $row->role=='admin') ? 'admin': "" ?>"><?=$short_name?></span>
                </span>
                <?php }else{?>
                <span class="avatar supporter-icon" style="background-image: url(<?=BASE.'assets/images/support.svg'?>)"></span>
               <?php }?>
              </div>
              <div class="content">
                <div class="username"hidden>
                  <?=(!empty($row->first_name) ? $row->first_name. " ".$row->last_name: "")?>
                  <span class="text-muted time"><?=(!empty($row->created)) ? convert_timezone($row->created, 'user'): "" ?></span>
                </div>
                <div class="message p-t-10">
                  <div><?=(!empty($row->message)) ? $row->message: "" ?></div>
                  <div>
                      <?php
                        if($row->file_link !="" && $row->file_link !="NULL"){
                            $file_name=explode("/assets/uploads/ticket_file/",$row->file_link);
                            ?>
                      <a href="<?=$row->file_link?>" download><?=$file_name[1]?></a>
                        <?php }
                      ?>
                  </div>
                </div>
              </div>
            </div>
            <?php }}?>
          </div>
          <?php
            if (get_role("admin") || get_role("supporter") || $ticket->status == 'pending' || $ticket->status == 'new') {
          ?>
          <form class="form actionFormCustom m-t-20" enctype="multipart/form-data" action="<?=cn($module."/ajax_update/".$ticket->ids)?>" data-redirect="<?=cn("$module/view/".$ticket->id)?>" method="POST">
            <div class="form-group">
              <label for="userinput8"><?=lang("Message")?></label>
              <textarea id="editor"  rows="5" class="form-control square" name="message" ></textarea>
              <!--<label for="myfile" class="btn round btn-primary btn-min-width mr-1 mb-1" style="float: right;"><?=lang("attach_file")?></label>-->
              <input type="file" id="myfile"  name="attach_file">
              <!--<input type="file" id="myfile" style="visibility:hidden;" name="attach_file">-->
            </div>
            <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1"><?=lang("Submit")?></button>
            <!--<button style="float: right;" class="btn round btn-default btn-min-width mr-1 mb-1" id="ticket_attach_file"><?=lang("attach_file")?></button>-->
          </form>
          <?php }?>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="<?=BASE?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script>
  CKEDITOR.replace( 'editor', {
    height: 300
  });
</script>