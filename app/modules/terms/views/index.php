<?php
$lang_current = get_lang_code_defaut();
?>
<style>
<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>

<?php }else{ ?>

.card-title{
	width:100%;
}
.dropdown-menu.show{
        direction: rtl;
        text-align: right;
    }
	.card-title {
		width:100%;
	}
<?php } ?>
</style>

<div class="row justify-content-center">

  <div class="col-md-8">
    <div class="page-header">
      <h1 class="page-title">
        <?=lang("Terms__Privacy_Policy")?>
        
      </h1>
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?=lang("Terms")?></h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>
      <div class="card-body collapse show">
        <?=get_option("terms_content", "")?>
      </div>
    </div>
  </div>  

  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?=lang("Privacy_Policy")?></h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>
      <div class="card-body collapse show">
        <?=get_option("policy_content", "")?>
      </div>
    </div>
  </div>

</div>

