<?php 
// if($this->session->flashdata('loginsucess') != ""){
//     echo '<div class="alert-success">'.$this->session->flashdata('loginsucess').'</div>';
// }
?>
<div class="main">
    <section class="banner-section">
    <div class="banner-inner-section01 ">
      <div class="container">
        <div class="row">
          <div class="banner-inner-section wow flipInX">
            <div class="search-home">
              <form action="<?php echo base_url();?>Discussion" id="homefrm">
                <input type="hidden" value="1" id="pagenumber" name="pagenumber">
                <input type="hidden" value="" id="sort_by" name="sort_by">
               
                <div class="main-serch-form">
                  <div class="category comn-group-cls">
                    <select class="form-control" name="category">

                      <option value="">Select Category</option>
                      <?php foreach ($category as $keyvalue) { ?>
                       <option value="<?php echo $keyvalue->category_ID;?>"><?php echo $keyvalue->name;?></option>
                    <?php } ?>
                    </select>
                  </div>
                  <div class="form-to comn-group-cls">
                    <div class="from-date">
                      <label>from</label>
                      <input type="text" value="" id="datepicker-form" name="fromdate" readonly>
                    </div>
                    <div class="form-to-date">
                      <label>to</label>
                      <input type="text" value="" id="datepicker-to" name="todate" readonly>
                    </div>
                  </div>
                  <div class="amount comn-group-cls">
                    <select class="form-control" name="amount">
                      <option value="">Select Amount</option>
                       <?php foreach ($homeamountarr as $key=>$value) { ?>
                       <option value="<?php echo $value;?>"><?php echo $value;?></option>
                    <?php } ?>
                    </select>
                  </div>
                  <div class="find-btn comn-group-cls">
                    <button type="submit" class="blue-button" value="submit"><i class="icon icon-icon-1"></i> find discussions</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>
    </section>
   <!--  <section class="welcome-trader-network-section">
      <?php echo $content;?>
     
    </section> -->
     </section>
     <section class="welcome-trader-network-section wow fadeInUp">
      <div class="container">
          <h2 class="title-txt"><?php echo $homedata[0]->page_title; ?></h2>
          <p><?php echo $homedata[0]->contain; ?></p>
      </div>
    </section>
    <section class="how-it-work-section">
      <div class="container">
        <div class="how-it-work-area">
          <div class="how-it-work-title-area wow fadeInUp">
            <h2 class="title-txt"><?php echo $homedata[1]->page_title; ?></h2>
            <p class="how-it-work-txt"><?php echo $homedata[1]->contain; ?></p> 
          </div>
            <div class="row">
            <div class="col-md-3 col-sm-6 how-it-work-box1 how-it-work-box ">
              <div class="flip_content">
                <div class="how-it-work-box-bg">
                  <div class="custom-icon"><img src="<?php echo base_url(); ?>assets/front/images/how-it-works1.svg"></div>
                  <div class="circle-shape"><span>1</span></div>
                  <div class="smp-txt">
                    <p><?php echo $homedata[2]->page_title; ?></p>
                  </div>
                  <div class="texthover-div">
                    <p><?php echo $homedata[2]->contain; ?></p>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 how-it-work-box2 how-it-work-box ">
              <div class="flip_content">
                <div class="how-it-work-box-bg">
                  <div class="custom-icon"><img src="<?php echo base_url(); ?>assets/front/images/how-it-works2.svg"></div>
                  <div class="circle-shape"><span>2</span></div>
                  <div class="smp-txt">
                    <p><?php echo $homedata[3]->page_title; ?></p>
                  </div>
                  <div class="texthover-div">
                    <p><?php echo $homedata[3]->contain; ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 how-it-work-box3 how-it-work-box ">
              <div class="flip_content">
                <div class="how-it-work-box-bg">
                  <div class="custom-icon"><img src="<?php echo base_url(); ?>assets/front/images/how-it-works3.svg"></div>
                  <div class="circle-shape"><span>3</span></div>
                  <div class="smp-txt">
                    <p><?php echo $homedata[4]->page_title; ?></p>
                  </div>
                  <div class="texthover-div">
                    <p><?php echo $homedata[4]->contain; ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 how-it-work-box4 how-it-work-box ">
              <div class="flip_content">
                <div class="how-it-work-box-bg">
                  <div class="custom-icon"><img src="<?php echo base_url(); ?>assets/front/images/how-it-works4.svg"></div>
                  <div class="circle-shape"><span>4</span></div>
                  <div class="smp-txt">
                    <p><?php echo $homedata[5]->page_title; ?></p>
                  </div>
                  <div class="texthover-div">
                    <p><?php echo $homedata[5]->contain; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <a href="<?php echo base_url(); ?>How-its-works" class="btn-bule-outline">read more</a>
        </div>
      </div>
    </section>
   
    <section class="latest-discussion-section">
      <div class="container">
        <div class="row">
          <h2 class="title-txt">Latest Discussions</h2>
          <div class="latest-discussion-main-box">
            <?php 
            foreach ($discussions as $keyvalue) { 
              $stardate=date('d F,Y',strtotime($keyvalue->discussion_start_datetime));
              $closingdate=date('d F Y',strtotime($keyvalue->closing_date));
              $starttime=date('h:i A',strtotime($keyvalue->discussion_start_datetime));
               if($keyvalue->base_price >99999){
               $Amount = "<span>$</span>".($keyvalue->base_price / 1000).'<span>K</span>';
              }else{
               $Amount = "<span>$</span>".$keyvalue->base_price;
              }
              ?>
            <div class="col-md-4 col-sm-6 latest-discussion-box wow fadeInUp" data-wow-duration="2s">
              <a href="<?php echo base_url() ?>discussion-details/<?php echo $keyvalue->discussion_ID; ?>">
              <div class="col-xs-12 latest-discussion-box-bg">
                <div class="present-seo-title-main">
                  <h3 class="present-seo-title present-seo-title-commen-cls"><?php echo $keyvalue->discussion_title;?></h3>
                  <div class="right-box"><?php echo  $Amount;?></div>
                </div>
                <div class="coordinator-description">
                  <h3 class="inner-txt-title"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo $keyvalue->cat_name;?> </h3>
                  <div class="date-time-txt">
                    <span><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $stardate;?>  |<span> <?php echo $starttime;?></span></span>
                  </div>
                  <div class="closing-date">
                    <p>Bid Closing Date: <?php echo $closingdate;?></p>
                  </div>
                  <div class="presents-attendes-area">
                    <div class="presents-area-commen-cls">
                      <?php
                        if($keyvalue->presenter==$keyvalue->require_presenter){
                          $homeprcls = 'presents-circle-area presenter-attende-green-button';
                        }
                        else{
                          $homeprcls = 'presents-area presents-circle-area';
                        }
                        if($keyvalue->attendee==$keyvalue->require_attendee){
                          $homeatcls = 'presents-circle-area presenter-attende-green-button';
                        }
                        else{
                          $homeatcls = 'attendes-area presents-circle-area';
                        }
                       ?>
                      <span class="<?php echo $homeprcls; ?>"><?php echo $keyvalue->presenter;?>/<?php echo $keyvalue->require_presenter;?></span>
                      <span class="inner-txt">presenters</span>
                    </div>
                    <div class="presents-area-commen-cls attendes-area-cls">
                      <span class="<?php echo $homeatcls; ?>"><?php echo $keyvalue->attendee;?>/<?php echo $keyvalue->require_attendee;?></span>
                      <span class="inner-txt">attendees</span>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>
  </div>
<script type="text/javascript">
$('.flip_content').hover(function(){
  if($(this).hasClass('flip_hover')){
    $(this).removeClass('flip_hover');
  } else {
    $(this).addClass('flip_hover');
  }
});

  $(function(){
    $('#homefrm').validate({
        submitHandler: function(form) {
   form.submit();
        }

    });
    });
</script>