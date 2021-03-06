<style>
.v_carousel .carousel-inner {
     position: relative;   
    overflow: hidden;
    display: inline-block;
    float: none;
   
}
.v_carousel{
	text-align:center;
}
.v_carousel .carousel-control-prev-icon{
	width: 40px;
    height: 40px;
	background-image: url('<?=BASE?>assets/images/left.png');
}
.v_carousel .carousel-control-prev{
	left: -18px;
	width: 10%;
	opacity: 1;
}

.v_carousel .carousel-control-next-icon{
	width: 40px;
    height: 40px;
	background-image: url('<?=BASE?>assets/images/right.png');
}
.v_carousel .carousel-control-next{
	right: -18px;
	width: 10%;
	opacity: 1;
}
.d-block {
    display: inline-block !important;
}
.video-fluid{
	
    margin-top: 15%;
}

#main-modal-content .modal-content{
	background-color:transparent !important;
}
#main-modal-content .modal-header{
	padding: 0px 70px !important;
	border: none !important;
}
#main-modal-content .modal-title,.close{
	color: #fff !important;
	opacity: 1;
}
#main-modal-content .modal-footer{
	display:none;
}
</style>


<div id="main-modal-content">
  <div class="modal-center">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-pantone">
          <h4 class="modal-title"><i class="fe fe-book-open"></i>  <?=$mname?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body">
          <div class="form-body">
            <div class="row justify-content-md-center">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <div class="content">
				    
                    <?php
                      if (!empty($media)) {?>
							<div id="video-carousel" class="carousel slide carousel-fade v_carousel" data-interval="false" data-ride="carousel">
								<div class="carousel-inner" role="listbox">
								<?php
								
									foreach ($media as $key => $row) {
										$cls='';		
										if($key==0){
											$cls='active';
										}
										//$url='https://'.$row->file_path.'/'.$row->name;
										$url = $row->file_path . '/' . $row->name;
								?>
								<?php if($row->type==1): ?>
									<div class="carousel-item <?=$cls?>">
									  <video class="video-fluid" style="width:100%;" controls>
										<source class="cls_video" src="<?=$url?>" type="video/mp4" />
									  </video>
									</div>
								<?php else: ?>
									<div class="carousel-item <?=$cls?>">
									   <img class="d-block" src="<?=$url?>">
									</div>
								<?php endif; ?>	
								
								<?php }?>
								</div>
  
								<a class="carousel-control-prev" style="height:90%" href="#video-carousel" role="button" data-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="carousel-control-next" style="height:90%"  href="#video-carousel" role="button" data-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
  
							</div>
                       
                    <?php  }else{
                    ?>
                      
                    <div class="text-center m-t-50 m-b-50">
                      <img class="img mb-1" src="<?=BASE?>assets/images/ofm-nofiles.png" alt="empty">
                      <div class="title text-muted"><?=lang("look_like_there_are_no_results_in_here")?></div>
                    </div>
                    <?php }?>    

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn round btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><?=lang("Close")?></button>
        </div>
      </div>
    </div>
  </div>
</div>


<script>

$(document).ready(function() {	
  $('button.close,.carousel-control-prev-icon,.carousel-control-next-icon,button.round').click(function(){ 
    $("video").each(function () { this.pause() }); 
  }); 
  
  $('#main-modal-content .carousel-inner .carousel-item').find('img,source').each(function(){
	 
		var height = 300;
		var width = 300;
		aspect = width / height;

		if($(window).height() < $(window).width()) {
			var resizedHeight = $(window).height();
			var resizedWidth = resizedHeight * aspect;
			
			if($(this).attr('class')!='cls_video'){
				$(this).css({'width':resizedWidth+'px','height':resizedHeight+'px'});
			}else{
				$(this).parent().css({'width':resizedWidth+'px'});
				$(this).parents('.carousel-item').css({'height':resizedHeight+'px'});
			}
		}

		else { // screen width is smaller than height (mobile, etc)
			var resizedWidth = $(window).width();
			var resizedHeight = resizedWidth / aspect; 
					    
			if($(this).attr('class')!='cls_video'){
				$(this).css({'width':resizedWidth+'px','height':resizedHeight+'px'});
			}else{
				$(this).parent().css({'width':resizedWidth+'px'});
				$(this).parents('.carousel-item').css({'height':resizedHeight+'px'});
			}
				
		}
	  
  });
});

</script>