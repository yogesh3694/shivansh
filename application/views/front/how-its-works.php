<div class="main">
   <div class="bradcume-section">
            <div class="container">
               <h2><?php echo $data[8]->page_title; ?></h2>
            </div>
   </div>

      <?php //echo "<pre>"; print_r($data); echo "</pre>"; ?> 
      <section class="how-it-work-section how-it-work01">
      <div class="container">
        <div class="how-it-work-area">
          <div class="row">
            <div class="col-md-3 col-sm-6 how-it-work-box1 how-it-work-box">
              <div class="flip_content">
                <div class="how-it-work-box-bg">
                  <div class="custom-icon"><img src="http://php1.nyusoft.in/trader-network/assets/front/images/how-it-works1.svg"></div>
                  <div class="circle-shape"><span>1</span></div>
                  <div class="smp-txt">
                    <p><?php echo $data[0]->page_title; ?></p>
                  </div>
                  <div class="texthover-div">
                    <p><?php echo $data[0]->contain; ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 how-it-work-box2 how-it-work-box">
              <div class="flip_content">
                <div class="how-it-work-box-bg">
                  <div class="custom-icon"><img src="http://php1.nyusoft.in/trader-network/assets/front/images/how-it-works2.svg"></div>
                  <div class="circle-shape"><span>2</span></div>
                  <div class="smp-txt">
                    <p><?php echo $data[1]->page_title; ?></p>
                  </div>
                  <div class="texthover-div">
                    <p><?php echo $data[1]->contain; ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 how-it-work-box3 how-it-work-box">
              <div class="flip_content">
                <div class="how-it-work-box-bg">
                  <div class="custom-icon"><img src="http://php1.nyusoft.in/trader-network/assets/front/images/how-it-works3.svg"></div>
                  <div class="circle-shape"><span>3</span></div>
                  <div class="smp-txt">
                    <p><?php echo $data[2]->page_title; ?></p>
                  </div>
                  <div class="texthover-div">
                    <p><?php echo $data[2]->contain; ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 how-it-work-box4 how-it-work-box">
              <div class="flip_content">
                <div class="how-it-work-box-bg">
                  <div class="custom-icon"><img src="http://php1.nyusoft.in/trader-network/assets/front/images/how-it-works4.svg"></div>
                  <div class="circle-shape"><span>4</span></div>
                  <div class="smp-txt">
                    <p><?php echo $data[3]->page_title; ?></p>
                  </div>
                  <div class="texthover-div">
                    <p><?php echo $data[3]->contain; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
 <section class="howitwork-discription">
      <div class="container">
          <div class="howitwork-row">
          <div class="img-section1 wow fadeInLeft" data-wow-duration="2s">
            <img src="http://php1.nyusoft.in/trader-network/assets/images/howitwork-img1.png">
            <a href="javascript:void(0)" class="white-btn"><?php echo $data[4]->page_title; ?></a>
        </div>
        <div class="text-discription-main wow fadeInRight" data-wow-duration="2s">
            <div class="text-discriptionfirst box1">
              <div class="custom_scroll_content">
                 <?php echo $data[4]->contain; ?>
              </div>
            </div>
         </div>
         </div>
<div class="howitwork-row">
        <div class="text-discription-main wow fadeInLeft" data-wow-duration="2s">
            <div class="text-discriptionsecond box2">
              <div class="custom_scroll_content">
                 <?php echo $data[5]->contain; ?>
              </div>
            </div>
         </div>
          <div class="img-section2 wow fadeInRight" data-wow-duration="2s">
            <img src="http://php1.nyusoft.in/trader-network/assets/images/howitwork-img2.png">
            <a href="javascript:void(0)" class="white-btn"><?php echo $data[5]->page_title; ?></a>
          </div>
         </div>
         

          <div class="howitwork-row">
          <div class="img-section1 wow fadeInLeft" data-wow-duration="2s">
            <img src="http://php1.nyusoft.in/trader-network/assets/images/howitwork-img3.png">
            <a href="javascript:void(0)" class="white-btn"><?php echo $data[6]->page_title; ?></a>
        </div>
        <div class="text-discription-main wow fadeInRight" data-wow-duration="2s">
            <div class="text-discriptionfirst box3">
              <div class="custom_scroll_content">
                <?php echo $data[6]->contain; ?> 
            </div>
          </div>
         </div>
         </div>
         

         <div class="howitwork-row">
        <div class="text-discription-main wow fadeInLeft" data-wow-duration="2s">
            <div class="text-discriptionsecond box4">
              <div class="custom_scroll_content">
                <?php echo $data[7]->contain; ?>
              </div>
            </div>
         </div>
          <div class="img-section2 wow fadeInRight" data-wow-duration="2s">
            <img src="http://php1.nyusoft.in/trader-network/assets/images/howitwork-img4.png">
            <a href="javascript:void(0)" class="white-btn"><?php echo $data[7]->page_title; ?> </a>
          </div>
         </div>
   </div>
    </section>
  
  </div>
<script src="<?php echo base_url();?>assets/front/js/jquery.flip.min.js"></script>
<script type="text/javascript">
$('.flip_content').hover(function(){
	if($(this).hasClass('flip_hover')){
		$(this).removeClass('flip_hover');
	} else {
		$(this).addClass('flip_hover');
	}
});
</script>
