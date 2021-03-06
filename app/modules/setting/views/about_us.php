<?php
$lang_current = get_lang_code_defaut();

?>
    <div class="card content">
      <div class="card-header">
        <h3 class="card-title"><i class="fe fe-edit-3"></i> <?=lang("About_us")?></h3>
      </div>
	  <? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
      <div class="card-body">
        <form class="actionForm" action="<?=cn("$module/ajax_general_settings")?>" method="POST" data-redirect="<?=cn($module."?t=".$tab)?>">
          <div class="row">
            <div class="col-md-12 col-lg-12">
          
              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("Content_Of_About_Us")?></h5 class="text-info">
              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="about_us_content_en" id="about_us_content_en" class="form-control"><?=get_option('about_us_content_en', "<p><strong>Lorem Ipsum</strong></p><p>Lorem ipsum dolor sit amet, in eam consetetur consectetuer. Vivendo eleifend postulant ut mei, vero maiestatis cu nam. Qui et facer mandamus, nullam regione lucilius eu has. Mei an vidisse facilis posidonium, eros minim deserunt per ne.</p><p>Duo quando tibique intellegam at. Nec error mucius in, ius in error legendos reformidans. Vidisse dolorum vulputate cu ius. Ei qui stet error consulatu.</p><p>Mei habeo prompta te. Ignota commodo nam ei. Te iudico definitionem sed, placerat oporteat tincidunt eu per, stet clita meliore usu ne. Facer debitis ponderum per no, agam corpora recteque at mel.</p>")?>
                </textarea>
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
	  <?php }else{ ?>
	    <div class="card-body">
        <form class="actionForm" action="<?=cn("$module/ajax_general_settings")?>" method="POST" data-redirect="<?=cn($module."?t=".$tab)?>">
          <div class="row">
            <div class="col-md-12 col-lg-12">
          
              <h5 class="text-info"><i class="fe fe-link"></i> <?=lang("Content_Of_About_Us")?></h5 class="text-info">
              <div class="form-group">
                <label class="form-label"><?=lang("Content")?></label>
                <textarea rows="3" name="about_us_content_ar" id="about_us_content_ar" class="form-control"><?=get_option('about_us_content_ar', "<p><strong>Lorem Ipsum</strong></p><p>Lorem ipsum dolor sit amet, in eam consetetur consectetuer. Vivendo eleifend postulant ut mei, vero maiestatis cu nam. Qui et facer mandamus, nullam regione lucilius eu has. Mei an vidisse facilis posidonium, eros minim deserunt per ne.</p><p>Duo quando tibique intellegam at. Nec error mucius in, ius in error legendos reformidans. Vidisse dolorum vulputate cu ius. Ei qui stet error consulatu.</p><p>Mei habeo prompta te. Ignota commodo nam ei. Te iudico definitionem sed, placerat oporteat tincidunt eu per, stet clita meliore usu ne. Facer debitis ponderum per no, agam corpora recteque at mel.</p>")?>
                </textarea>
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
	  
	  
	  
	  <?php } ?>
    </div>

<script src="<?=BASE?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<? if(!empty($lang_current) && $lang_current->code == 'en'){ ?>
<script>

  CKEDITOR.replace( 'about_us_content_en', {
    height: 500
  });

</script>
<?php }else{ ?>
<script>

  CKEDITOR.replace( 'about_us_content_ar', {
    height: 500,
	contentsLangDirection:'rtl',
  });
</script>
<?php } ?>