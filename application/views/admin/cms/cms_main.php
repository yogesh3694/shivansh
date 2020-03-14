<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url(); ?>assets/admin/js/ckeditor.js" type="text/javascript"></script> -->
<script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
<script type="text/javascript">

$(document).ready(function () {
CKEDITOR.replace( 'privacypolicy' );
CKEDITOR.replace( 'termscondition' );
$('#form1').validate({
    rules:{
        pagetitle1:"required",
        pagecontent1:"required",
        pagetitle2:"required",
        pagecontent2:"required"
      },
    messages:{
        pagetitle1:"Please enter welcome text title.",
        pagecontent1:"Please enter welcome text description.",
        pagetitle2:"Please enter how it works title.",
        pagecontent2:"Please enter how it works description."
      },
  });
$('#form2').validate({
    rules:{
        pagetitle:"required",
        pagecontent:"required"
    },
    messages:{
        pagetitle:"Please enter page title.",
        pagecontent:"Please enter page description."
      },
    });
$('#form3').validate({
    rules:{
    	pagetitle:"required",
        steptitle1:"required", 
        stepcontent1:"required", 
        steptitle2:"required",
        stepcontent2:"required", 
        steptitle3:"required",
        stepcontent3:"required", 
        steptitle4:"required",
        stepcontent4:"required", 
        usertitle:"required",
        usercontent:"required", 
        pretitle:"required",
        precontent:"required", 
        atttitle:"required",
        attcontent:"required", 
        paytitle:"required",
        paycontent:"required" 
      },
    messages:{
    	pagetitle:"Please enter page title.",
        steptitle1:"Please enter register & create profile title.",
        stepcontent1:"Please enter register & create profile description.",
        steptitle2:"Please enter create & participate discussion title.",
        stepcontent2:"Please enter create & participate discussion description.",
        steptitle3:"Please enter earn & build profile title.",
        stepcontent3:"Please enter earn & build profile description.",
        steptitle4:"Please enter get pay & earn points title.",
        stepcontent4:"Please enter get pay & earn points description.",
        usertitle:"Please enter as a user title.",
        usercontent:"Please enter as a user description.",
        pretitle:"Please enter as a presenter title.",
        precontent:"Please enter as a presenter description.",
        atttitle:"Please enter as a attendee title.",
        attcontent:"Please enter as a attendee description.",
        paytitle:"Please enter pay title.",
        paycontent:"Please enter pay description.",

      },
});
$('#form4').validate({
    rules:{
        pagetitle:"required",
        pagecontent:"required"
    },
    messages:{
        pagetitle:"Please enter page title.",
        pagecontent:"Please enter page description."
    },
});
$('#form5').validate({
	rules:{
        pagetitle:"required",
        pagecontent:"required"
    },
    messages:{
        pagetitle:"Please enter page title.",
        pagecontent:"Please enter page description."
    },
  });

});
</script>
<div class="content-i manage_cms_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box table_container">
              <h6 class="element-header">Manage CMS Pages</h6>
                <div class="table-responsive accordion_content">
<div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">
<!-- Accordion card -->
  <?php 
  	if($this->session->flashdata('message') != ''){
	?>
	<div class="alert-success alert alert-dismissible">
  		<?php echo $this->session->flashdata('message'); ?>
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	</div>
	<?php
  	}
  ?>
  <div class="card">
    <!-- Card header -->
    <div class="card-header accordion" role="tab" id="headingTwo1">
      <a class="" href="javascript:void(0)">
        <h5 class="mb-0">
          HOME PAGE <i class="fa fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>
    <!-- Card body -->
    <div class="accordion_inner" style="display: none;">
      <div class="card-body">
        <form id="form1" class="settingform cmsform light_font_form" action="<?php echo base_url(); ?>admin/Cms_Master/update" method="post">
          <div class="row">
  	      	<div class="col-sm-12">
              <div class="form_group">
                <h6>Welcome Text</h6>
                  <label>Title</label>
  	        	      <input type="text" name="pagetitle1" class="pagetitle input_text" value="<?php echo $allcms[0]->page_title; ?>">
  	        	      <input type="hidden" name="pageslug" value="homepage">
                    <input type="hidden" name="homehidden" value="homesection1">
              </div>
  	    	  </div>
    	    	<div class="col-sm-12">
              <div class="form_group">
                <label>Description</label>
    	           	<textarea name="pagecontent1" rows="5" class="input_textarea" ><?php echo $allcms[0]->contain; ?></textarea>
              </div>
    	    	</div>
            <div class="margin_top">
              <div class="col-sm-12">
                <div class="form_group">
                  <h6>How It Works</h6>
                    <label>Title</label>
                      <input type="text" name="pagetitle2" class="pagetitle input_text" value="<?php echo $allcms[2]->page_title; ?>">
                      <input type="hidden" name="homehidden2" value="homesection2">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form_group">
                  <label>Description</label>
                    <textarea name="pagecontent2" rows="5" class="input_textarea" ><?php echo $allcms[2]->contain; ?></textarea>
                </div>
              </div>
            </div>
    	    	<div class="col-sm-12">
    	        	<input type="submit" value="Update" class="input_submit" name="homesubmit">
    	    	</div>
          </div>
    	  </form>
      </div>
    </div>

  </div>
  <!-- Accordion card -->

  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header accordion" role="tab" id="headingTwo2">
      <a href="javascript:void(0)" class="">
        <h5 class="mb-0">
          ABOUT US <i class="fa fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>
    <!-- Card body -->
    <div class="accordion_inner" style="display: none;">
      <div class="card-body">
      	<form id="form2" class="settingform cmsform" method="post" action="<?php echo base_url(); ?>admin/Cms_Master/update">
          <div class="row">
  	      	<div class="col-sm-12">
              <div class="form_group">
                <label>Title</label>
      	        	<input type="text" name="pagetitle" class="pagetitle input_text" value="<?php echo $allcms[1]->page_title; ?>">
      	        	<input type="hidden" name="pageslug" value="about-us">
  	    	    </div>
            </div>
    	    	<div class="col-sm-12">
              <div class="form_group">
                <label>Description</label>
    	        	<textarea name="pagecontent"  rows="5" class="input_textarea"><?php echo $allcms[1]->contain; ?></textarea>
              </div>
    	    	</div>
    	    	<div class="col-sm-12">
    	        	<input type="submit" value="Update" class="input_submit" name="aboutsubmit">
    	    	</div>
          </div>
    	</form>
      </div>
    </div>
  </div>
  
  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header accordion" role="tab" id="headingThree3">
      <a href="javascript:void(0)" class="">
        <h5 class="mb-0">
          HOW IT WORKS <i class="fa fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div> 
    <!-- Card body -->
    <div class="accordion_inner" style="display: none;">
      <div class="card-body">
        <form id="form3" class="settingform cmsform light_font_form" action="<?php echo base_url(); ?>admin/Cms_Master/update" method="post">
        <div class="row">
        	<div class="col-sm-12">
              <div class="form_group">
                <label>Title</label>
      	        	<input type="text" name="pagetitle" class="pagetitle input_text" value="<?php echo $allcms[13]->page_title; ?>">
      	        	<input type="hidden" name="howithidden" value="how-it-work">
  	    	    </div>
            </div>
  	      	<div class="col-sm-12">
              <div class="form_group">
                <h6>Register & Create Your Profile</h6>
                  <label>Title</label>
  	        	      <input type="text" name="steptitle1" class="pagetitle input_text" value="<?php echo $allcms[5]->page_title; ?>">
                    <input type="hidden" name="stephidden1" value="step1">
              </div>
  	    	  </div>
    	    	<div class="col-sm-12">
              <div class="form_group">
                <label>Description</label>
    	           	<textarea name="stepcontent1" rows="5" class="input_textarea" ><?php echo $allcms[5]->contain; ?></textarea>
              </div>
    	    	</div>
            <div class="margin_top">
              <div class="col-sm-12">
                <div class="form_group">
                  <h6>Create & Participate in Discussion</h6>
                    <label>Title</label>
                      <input type="text" name="steptitle2" class="pagetitle input_text" value="<?php echo $allcms[6]->page_title; ?>">
                      <input type="hidden" name="stephidden2" value="step2">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form_group">
                  <label>Description</label>
                    <textarea name="stepcontent2" rows="5" class="input_textarea" ><?php echo $allcms[6]->contain; ?></textarea>
                </div>
              </div>
            </div>
            <div class="margin_top">
              <div class="col-sm-12">
                <div class="form_group">
                  <h6>Earn & Build Your Profile</h6>
                    <label>Title</label>
                      <input type="text" name="steptitle3" class="pagetitle input_text" value="<?php echo $allcms[7]->page_title; ?>">
                      <input type="hidden" name="stephidden3" value="step3">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form_group">
                  <label>Description</label>
                    <textarea name="stepcontent3" rows="5" class="input_textarea" ><?php echo $allcms[7]->contain; ?></textarea>
                </div>
              </div>
            </div>
            <div class="margin_top">
              <div class="col-sm-12">
                <div class="form_group">
                  <h6>Get Pay & Earn Points</h6>
                    <label>Title</label>
                      <input type="text" name="steptitle4" class="pagetitle input_text" value="<?php echo $allcms[8]->page_title; ?>">
                      <input type="hidden" name="stephidden4" value="step4">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form_group">
                  <label>Description</label>
                    <textarea name="stepcontent4" rows="5" class="input_textarea" ><?php echo $allcms[8]->contain; ?></textarea>
                </div>
              </div>
            </div>
            <div class="margin_top">
              <div class="col-sm-12">
                <div class="form_group">
                  <h6>As a User</h6>
                    <label>Title</label>
                      <input type="text" name="usertitle" class="pagetitle input_text" value="<?php echo $allcms[9]->page_title; ?>">
                      <input type="hidden" name="userhidden" value="step4">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form_group">
                  <label>Description</label>
                    <textarea name="usercontent" rows="5" class="input_textarea" ><?php echo $allcms[9]->contain; ?></textarea>
                </div>
              </div>
            </div>
            <div class="margin_top">
              <div class="col-sm-12">
                <div class="form_group">
                  <h6>AS a Presenter</h6>
                    <label>Title</label>
                      <input type="text" name="pretitle" class="pagetitle input_text" value="<?php echo $allcms[10]->page_title; ?>">
                      <input type="hidden" name="prehidden" value="step4">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form_group">
                  <label>Description</label>
                    <textarea name="precontent" rows="5" class="input_textarea" ><?php echo $allcms[10]->contain; ?></textarea>
                </div>
              </div>
            </div>
            <div class="margin_top">
              <div class="col-sm-12">
                <div class="form_group">
                  <h6>As a Attendee</h6>
                    <label>Title</label>
                      <input type="text" name="atttitle" class="pagetitle input_text" value="<?php echo $allcms[11]->page_title; ?>">
                      <input type="hidden" name="atthidden" value="step4">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form_group">
                  <label>Description</label>
                    <textarea name="attcontent" rows="5" class="input_textarea" ><?php echo $allcms[11]->contain; ?></textarea>
                </div>
              </div>
            </div>
             <div class="margin_top">
              <div class="col-sm-12">
                <div class="form_group">
                  <h6>Pay</h6>
                    <label>Title</label>
                      <input type="text" name="paytitle" class="pagetitle input_text" value="<?php echo $allcms[12]->page_title; ?>">
                      <input type="hidden" name="payhidden" value="step4">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form_group">
                  <label>Description</label>
                    <textarea name="paycontent" rows="5" class="input_textarea" ><?php echo $allcms[12]->contain; ?></textarea>
                </div>
              </div>
            </div>
    	    	<div class="col-sm-12">
    	        	<input type="submit" value="Update" class="input_submit" name="howitsubmit">
    	    	</div>
        </div>
    	</form>
      </div>
    </div>

  </div>
   <div class="card">

    <!-- Card header -->
    <div class="card-header accordion" role="tab" id="headingThree4">
      <a class="" href="javascript:void(0)">
        <h5 class="mb-0">
          PRIVACY POLICY <i class="fa fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>
    <!-- Card body -->
    <div class="accordion_inner" style="display: none;">
      <div class="card-body">
        <form id="form4" class="settingform cmsform" action="<?php echo base_url(); ?>admin/Cms_Master/update" method="post">
	      	<div class="row">
            <div class="col-sm-12">
              <div class="form_group">
                <label>Title</label>
    	        	<input type="text"  name="pagetitle" class="pagetitle input_text" value="<?php echo $allcms[3]->page_title; ?>" >
    	        	<input type="hidden" name="pageslug" value="privacypolicy">
              </div>
    	    	</div>
    	    	<div class="col-sm-12">
              <div class="form_group">
                <label>Description</label>
    	        	<textarea name="pagecontent" id="privacypolicy" rows="5" class="input_textarea"><?php echo $allcms[3]->contain; ?></textarea>
              </div>
    	    	</div>
    	    	<div class="col-sm-12">
    	        	<input type="submit" value="Update" class="input_submit" name="privacysubmit">
    	    	</div>
          </div>
    	</form>
      </div>
    </div>

  </div>
   <div class="card">

    <!-- Card header -->
    <div class="card-header accordion" role="tab" id="headingThree5">
      <a class="" href="javascript:void(0)">
        <h5 class="mb-0">
          TERMS & conditions <i class="fa fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>
    <!-- Card body -->
    <div class="accordion_inner" style="display: none;">
      <div class="card-body">
        <form id="form5" class="settingform cmsform" action="<?php echo base_url(); ?>admin/Cms_Master/update" method="post">
          <div class="row">
  	      	<div class="col-sm-12">
              <div class="form_group">
                <label>Title</label>
                <input type="text" name="pagetitle" class="pagetitle input_text" value="<?php echo $allcms[4]->page_title; ?>">
                <input type="hidden" name="pageslug" value="terms-condition">
            </div>
    	    	</div>
    	    	<div class="col-sm-12">
              <div class="form_group">
                <label>Description</label>
    	        	<textarea name="pagecontent" id="termscondition" rows="5" class="input_textarea"><?php echo $allcms[4]->contain; ?></textarea>
              </div>
    	    	</div>
    	    	<div class="col-sm-12">
    	        	<input type="submit" value="Update" class="input_submit" name="termssubmit">
    	    	</div>
          </div>
    	</form>
      </div>
    </div>

  </div>
  <!-- Accordion card -->

</div>
</div>
</div>
</div>

<!-- Accordion wrapper -->
<style>
.accordion {
   
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}

.active, {
    background-color: #ccc;
}

.panel {
    padding: 0 18px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
}
.content_opend .panel {
  max-height: initial;
}
</style>


<script>
// var acc = document.getElementsByClassName("accordion");
// var i;

// for (i = 0; i < acc.length; i++) {
//   acc[i].addEventListener("click", function() {
//     this.classList.toggle("active");
//     var panel = this.nextElementSibling;
//     if (panel.style.maxHeight){
//       panel.style.maxHeight = null;
//     } else {
//       panel.style.maxHeight = panel.scrollHeight + "px";
//     } 
//   });
// }
$(document).on('click','.card-header',function (e) {
    // alert($(e.target).parent('div.accorion_inner').attr("class"));
    if ($(this).parent("div").hasClass('content_opend')) {
        $(this).parent("div").removeClass('content_opend');
        $(this).siblings('.accordion_inner').slideUp();
    } else if ($(this).parent("div").siblings("div").hasClass('content_opend')) {
        $(this).parent("div").siblings("div").removeClass('content_opend');
        $(this).parent("div").siblings("div").children('.accordion_inner').slideUp();
        $(this).parent("div").addClass('content_opend');
        $(this).siblings('.accordion_inner').slideDown();
    } else {
        $(this).parent("div").addClass('content_opend');
        $(this).siblings('.accordion_inner').slideDown();
    }
});
jQuery(document).ready(function($) {
    $('.card-header').click(function(){
        var currentId = $(this).attr('id');
        setTimeout(function() {
            $('html, body').animate({
                scrollTop: $('#'+currentId).offset().top - 150
            }, 1000);
        }, 300);
    });
});
</script>

