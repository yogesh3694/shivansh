<div class="bradcume-section">
<div class="container">
<h2>FAQs</h2>
</div>
</div>
<section class="latest-discussion-section discussion-page-main-box faq-page-area">
<div class="container">
     <section class="panel panel-default">
        <div class="faqtitle">
        <h3>Find Your Question</h3>
        </div>
        <div class="search-box wow flipInX">
        <div class="input-group">
        <input type="text" id="accordion_search_bar" class="form-controlcls" placeholder="Search by keyword">
        
        <!-- <button class="btn btn-default gobtn" type="button">
        GO</button> -->
        <button type="submit" class="blue-button gobtn">Go</button>
        
        </div>
        <!-- /input-group -->
        
        <!-- /.col-lg-6 -->
        </div>
        <div class="accordionmaindiv">
          <h3>Frequently Asked Questions</h3>
        <div class="accordiontab">


<div class="panel-group accordiondiv" id="accordion" role="tablist" aria-multiselectable="true">
<?php $i=0; foreach ($trader_faq as $keyvalue) { 
            $i++; 
            if($i == 1){ $cls='content_opend'; $style=''; }else{ $cls=''; $style='display: none;'; }
  ?>
         
        <div class="accordion_sec panel <?php echo $cls; ?> wow" data-wow-duration="2s" id="collapse<?php echo $keyvalue->faq_ID;?>_Container">
          <div class="card-header">
            <a href="javascript:void(0)" class="">
              <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
              <h5><?php echo $keyvalue->question; ?></h5>
            </a>
          </div>
          <div class="accordion_inner" style="<?php echo $style; ?>">
            <div class="card-body">
              <p><?php echo $keyvalue->answer; ?></p>
            </div>
          </div>
        </div>
<?php } ?>
</div>
        
            <div class="questioncls">
              <h3>Don't find your Question?</h3>
              <p>You are not able to find the answer to your question? No Problem!</p>
        </div>
         
        <a href="<?php echo site_url();?>contact-us" class="blue-button">Contact Us</a>
        </div>
        <!-- Row -->
        </div>
        <!-- Col -->
    <!-- Container -->
 <div class="clear"></div>
</section>
</div>
</section>
  <script type="text/javascript">

(function() {
  var searchTerm, panelContainerId;

  $('.gobtn').on('click', function() {
   searchfaq();
  });
  
 $('#accordion_search_bar').keypress(function(e) {
    searchfaq();

  });

}());
 
  function searchfaq(){

    searchTerm = $("#accordion_search_bar").val();
    $('#accordion > .panel').each(function() {
      panelContainerId = '#' + $(this).attr('id');

      // Makes search to be case insesitive 
      $.extend($.expr[':'], {
        'contains': function(elem, i, match, array) {
         
         
          return (elem.textContent || elem.innerText || '').toLowerCase()
            .indexOf((match[3] || "").toLowerCase()) >= 0;
        }
      });

      // END Makes search to be case insesitive

      // Show and Hide Triggers
      $(panelContainerId + ':not(:contains(' + searchTerm + '))').hide(); //Hide the rows that done contain 
      $(panelContainerId + ':contains(' + searchTerm + ')').show(); //Show the rows that do!
     

    });
  
  }
</script>
<script type="text/javascript">
  $(document).on('click','.card-header',function (e) {
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
        var currentId =this;
        setTimeout(function() {
            $('html, body').animate({
                scrollTop: $(currentId).offset().top - 150
            }, 1000);
        }, 300);
    });
});
</script>