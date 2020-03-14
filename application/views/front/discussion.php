<link rel="stylesheet" href="<?php echo  base_url();?>assets/front/css/jquery.custom-scrollbar.css" />
  <script src="<?php echo  base_url();?>assets/front/js/jquery.custom-scrollbar.js"></script>
<div class="main">
        <div class="bradcume-section">
            <div class="container">
                    <h2>Discussions</h2>
            </div>
        </div>
        <div class="loader" style="display: none;"><img src="<?php echo base_url();?>assets/front/images/loader.svg"></div>
        <section class="latest-discussion-section discussion-page-main-box">
<div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-4 siderbar-discussion">
                        <div class="siderbar-discription">
                            <div class="keyword-section commen-space">
                                <div class="label-title">keywords</div>
                                <div>
                                    <input type="text" placeholder="Search by keyword" class="form-controlcls" id="discussion_dropdown">
                                    <!-- <button type="submit" class="blue-button">Go</button> -->
                                </div>
                            </div>
                            <div class="category-section commen-space">
                                <div class="label-title">category</div>
                                <div id="vertical-scrollbar" class="gray-skin">
                                    <ul>
                                        <?php 
                                        
                                        if($_GET['category']!=''){
                                            $CAT=explode(',', $_GET['category']);    
                                           }
                                        
                                        foreach ($category as $keyvalue) { ?>
                                           
                                        <li>
                                            <label class="customcheckbox">
                                                <input value="<?php echo $keyvalue->category_ID;?>" type="checkbox" name="categorychk[]" class="trader_categorychk" <?php if(in_array($keyvalue->category_ID, $CAT)){?> checked <?php } ?>>
                                                <span class="customcheckbox-inner "></span>
                                                <?php echo $keyvalue->name;?>
                                            </label>
                                        </li>
                                        <?php } ?>
                                       
                                    </ul>

                                </div>
                            </div>
                            <div class="date-section commen-space">
                                <div class="label-title">date</div>
                                <div class="from-to-main-section">
                                    <div class="from-date-section">
                                        <input type="text" value="<?php echo $_GET['fromdate'];?>" id="fromdate" placeholder="From" class="form-controlcls" readonly>
                                    </div>
                                    <div class="form-to-date-section">
                                        <input type="text" value="<?php echo $_GET['todate'];?>" id="todate" placeholder="To" class="form-controlcls" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="amount-section commen-space">
                                <input type="hidden" name="fromamount" id="fromamount" value="<?php echo $_GET['amount'];?>">
                                <div class="label-title">Amount
                                    <div id="slider-range"></div>
                                </div>
                            </div>
                            <div class="age-group-section commen-space">
                                <div class="label-title">Age group</div>
                                <div id="vertical-radiobtn-scrollbar" class="gray-skin">
                                    <ul>
                                        <?php foreach ($trader_age_group as $keyvalue) { ?>
                                        <li>
                                            <label class="customradiobox">
                                                <input value="<?php echo $keyvalue->age_ID;?>" type="radio" name="agegroup" class="agegroup" id="agegroup<?php echo $keyvalue->age_ID;?>" <?php if($_GET['agegroup']==$keyvalue->age_ID){?> checked <?php } ?>>
                                                <span class="customradiobox-inner"></span>
                                                <?php echo $keyvalue->age_range;?> year
                                            </label>
                                        </li>
                                        <?php } ?>
                                    </ul>

                                </div>
                            </div>
                            <a href="#" class="clear-filter-btn" onclick="clear_form_elements('siderbar-discription')">Clear all filters</a>

                        </div>
                    </div>
                    <!-- discussion replace data div -->
                    <div class="ajax_main_div_load_discussion"></div>
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
//-------discussion autocomplete function
 $(function() {
    $("#discussion_dropdown").autocomplete({
        source: "<?php echo base_url()?>discussion/searchdiscussiontitle",
        select: function( event, ui ) {
            event.preventDefault();
            $("#discussion_dropdown").val(ui.item.value);
            window.location.href="<?php echo base_url()?>discussion-details/"+ui.item.id;
        }
    });
});
//--------clear data function------------
function clear_form_elements(class_name) {
jQuery("."+class_name).find(':input').each(function() {
    switch(this.type) {
        case 'password':
        case 'text':
        case 'textarea':
        case 'file':
        case 'select-one':
        case 'select-multiple':
        case 'date':
        case 'number':
        case 'tel':
        case 'email':
            jQuery(this).val('');
            break;
        case 'checkbox':
        case 'radio':
            this.checked = false;
            break;
    }
  });

$("#slider-range").slider('values',0,0); // sets first handle (index 0) to 50
$("#slider-range").slider('values',1,20000); // sets second handle (index 1) to 80
$('.ui-slider-handle:eq(0) .price-range-min').html('$0');
$('.ui-slider-handle:eq(1) .price-range-max').html('$20000');
 jQuery("#fromamount").val('0-20000');
  var category = jQuery("input[name='categorychk[]']:checked")
        .map(function(){return jQuery(this).val();}).get();
        var fromdate = jQuery("#fromdate").val();
        var todate = jQuery("#todate").val();
        
        var amount = '0-20000';
        var agegroup = $("input:radio.agegroup:checked").val();
        var sort_by =jQuery( "#sortby").val();
        var pagenumber = jQuery("#current_page").val();
        discussiondataajax(category,fromdate,todate,amount,agegroup,sort_by,pagenumber);
}
//---get url varible value function
function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
        });
    return vars;
}

var sort_by = getUrlVars()["sort_by"];
var pagenumber = getUrlVars()["pagenumber"];
  $(document).ready(function () {
            $("#sortby").selectmenu();

            var dateFormat = "mm/dd/yy",
                from = $("#fromdate")
                    .datepicker({
                        //defaultDate: "+1w",
                        changeMonth: true,
                        numberOfMonths: 1

                    })
                    .on("change", function () {
                        to.datepicker("option", "minDate", getDate(this));

                         var amount = jQuery("#fromamount").val();
                        //var toamount = '';
                        var fromdate = jQuery('#fromdate').val();
                        var todate = jQuery('#todate').val();
                       var agegroup = $("input:radio.agegroup:checked").val();
                        var pagenumber = jQuery("#current_page").val();

                        var category = jQuery("input[name='categorychk[]']:checked")
                        .map(function(){return jQuery(this).val();}).get();
                        var sort_by =jQuery( "#sortby" ).val();

                        if(fromdate!=='' && todate!==''){
                           
                        discussiondataajax(category,fromdate,todate,amount,agegroup,sort_by,pagenumber);
                        }

                    }),
                to = $("#todate").datepicker({
                    //defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1
                })
                    .on("change", function () {
                        from.datepicker("option", "maxDate", getDate(this));
                         var amount = jQuery("#fromamount").val();
                        var toamount = '';
                        var fromdate = jQuery('#fromdate').val();
                        var todate = jQuery('#todate').val();
                        var agegroup = $("input:radio.agegroup:checked").val();

                        var pagenumber = jQuery("#current_page").val();

                        var category = jQuery("input[name='categorychk[]']:checked")
                        .map(function(){return jQuery(this).val();}).get();
                        var sort_by =jQuery( "#sortby" ).val();
                     
                        if(fromdate!=='' && todate!==''){
                           
                        discussiondataajax(category,fromdate,todate,amount,agegroup,sort_by,pagenumber);
                        }
                    });
            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }
});
//-------designer jquery----------------
jQuery(window).bind("resize ready  load", function (e) { $("#vertical-scrollbar,#vertical-radiobtn-scrollbar").customScrollbar(); });
    function collision($div1, $div2) {
    var x1 = $div1.offset().left;
    var w1 = 40;
    var r1 = x1 + w1;
    var x2 = $div2.offset().left;
    var w2 = 40;
    var r2 = x2 + w2;

    if (r1 < x2 || x1 > r2)
        return false;
    return true;
}
// Fetch Url value 
var getQueryString = function (parameter) {
    var href = window.location.href;
    var reg = new RegExp('[?&]' + parameter + '=([^&#]*)', 'i');
    var string = reg.exec(href);
    return string ? string[1] : null;
};

//--------------window load data-----------

jQuery(window).bind("load", function() {
    var amount = jQuery("#fromamount").val();
    //var toamount = '';
    var fromdate = jQuery('#fromdate').val();
    var todate = jQuery('#todate').val();
    var agegroup = $("input:radio.agegroup:checked").val();
    var pagenumber = jQuery("#current_page").val();

    var category = jQuery("input[name='categorychk[]']:checked")
    .map(function(){return jQuery(this).val();}).get();
    var sort_by =jQuery( "#sortby" ).val();
  discussiondataajax(category,fromdate,todate,amount,agegroup,sort_by,pagenumber);

}); 

//------category on change function--------------
 jQuery(document).on("change",".trader_categorychk",function(){
  
     var category = jQuery("input[name='categorychk[]']:checked")
        .map(function(){return jQuery(this).val();}).get();
        var fromdate = jQuery("#fromdate").val();
        var todate = jQuery("#todate").val();
        var amount = jQuery("#fromamount").val();
       // var toamount = jQuery("#toamount").val();
        var agegroup = $("input:radio.agegroup:checked").val();
        var sort_by =jQuery( "#sortby").val();
        var pagenumber = jQuery("#current_page").val();
       
        

    var category = jQuery("input[name='categorychk[]']:checked")
    .map(function(){return jQuery(this).val();}).get();
    var sort_by =jQuery( "#sortby" ).val();
   
    discussiondataajax(category,fromdate,todate,amount,agegroup,sort_by,pagenumber);
  
  });

var maxamount="<?php echo ($fetchmaxamountmax[0]->base_price!='' && $fetchmaxamountmax[0]->base_price!=0)?$fetchmaxamountmax[0]->base_price:'10000';?>";
//-----discussion amount function-------------
$('#slider-range').slider({
    range: true,
    min: 0,
    max: maxamount,
    step: 1,
    values: [getQueryString('minval') ? getQueryString('minval') : 0, getQueryString('maxval') ? getQueryString('maxval') : maxamount],

    slide: function (event, ui) {

        $('.ui-slider-handle:eq(0) .price-range-min').html('$' + ui.values[ 0 ]);
        $('.ui-slider-handle:eq(1) .price-range-max').html('$' + ui.values[ 1 ]);
        $('.price-range-both').html('<i>$' + ui.values[ 0 ] + ' - </i>$' + ui.values[ 1 ]);

        // get values of min and max
        $("#minval").val(ui.values[0]);
        $("#maxval").val(ui.values[1]);
       
    
    },
    stop: function( event, ui ) {
   
            var frmamount=ui.values[0]+'-'+ui.values[1];
            jQuery("#fromamount").val(frmamount);
        if (ui.values[0] == ui.values[1]) {
            $('.price-range-both i').css('display', 'none');
        } else {
            $('.price-range-both i').css('display', 'inline');
        }

        if (collision($('.price-range-min'), $('.price-range-max')) == true) {
            $('.price-range-min, .price-range-max').css('opacity', '0');
            $('.price-range-both').css('display', 'block');
        } else {
            $('.price-range-min, .price-range-max').css('opacity', '1');
            $('.price-range-both').css('display', 'none');
        }


         var category = jQuery("input[name='categorychk[]']:checked")
        .map(function(){return jQuery(this).val();}).get();
        var fromdate = jQuery("#fromdate").val();
        var todate = jQuery("#todate").val();
        
        var amount = frmamount;
        //var toamount = jQuery("#toamount").val();
        var agegroup = $("input:radio.agegroup:checked").val();
        var sort_by =jQuery( "#sortby").val();
        var pagenumber = jQuery("#current_page").val();
        discussiondataajax(category,fromdate,todate,amount,agegroup,sort_by,pagenumber);

    }
});

$('.ui-slider-range').append('<span class="price-range-both value"><i>$' + $('#slider-range').slider('values', 0) + ' - </i>' + $('#slider').slider('values', 1) + '</span>');

$('.ui-slider-handle:eq(0)').append('<span class="price-range-min value">$' + $('#slider-range').slider('values', 0) + '</span>');

$('.ui-slider-handle:eq(1)').append('<span class="price-range-max value">$' + $('#slider-range').slider('values', 1) + '</span>');

$( document ).ready(function() {
var amountval = jQuery('#fromamount').val();

  if(amountval!=''){
  var amountval = amountval.replace("[","").replace("]","").split('-');

    $("#slider-range").slider('values',0,amountval[0]); // sets first handle (index 0) to 50
    $("#slider-range").slider('values',1,amountval[1]); // sets second handle (index 1) to 80
    $('.ui-slider-handle:eq(0) .price-range-min').html('$'+amountval[0]);
    $('.ui-slider-handle:eq(1) .price-range-max').html('$'+amountval[1]);
   }
});
//--------sorting function----------------------
 jQuery(document).on("change",".sort_by",function(){

        var category = jQuery("input[name='categorychk[]']:checked")
        .map(function(){return jQuery(this).val();}).get();
        var fromdate = jQuery("#fromdate").val();
        var todate = jQuery("#todate").val();
        
        var amount = jQuery("#fromamount").val();
        //var toamount = jQuery("#toamount").val();
        var agegroup = $("input:radio.agegroup:checked").val();
        var sort_by =jQuery( "#sortby").val();
        var pagenumber = 1; 
       

        discussiondataajax(category,fromdate,todate,amount,agegroup,sort_by,pagenumber)
});

//-----pagination function------------------------------
   jQuery(document).on("click",".pagination_my",function(){
        var category = jQuery("input[name='categorychk[]']:checked")
        .map(function(){return jQuery(this).val();}).get();
        var fromdate = jQuery("#fromdate").val();
        var todate = jQuery("#todate").val();
        var amount = jQuery("#fromamount").val();
        //var toamount = jQuery("#toamount").val();
        var agegroup = $("input:radio.agegroup:checked").val();
        var sort_by =jQuery( "#sortby").val();
        var pagenumber = jQuery("#current_page").val();
       
        
        var checkpageno = jQuery(this).attr('data-info');
        if(jQuery.isNumeric( checkpageno ))
        {
        jQuery("#current_page").val(checkpageno);
        var pagenumber = jQuery("#current_page").val();

        }else {

            if(checkpageno == "next"){
            var lastpage = jQuery("#current_page").val();
            var next_page = parseInt(lastpage) + parseInt(1);
            jQuery("#current_page").val(next_page);

            }else if(checkpageno == "prev"){

            var lastpage = jQuery("#current_page").val();
            var next_page = lastpage - 1;
            jQuery("#current_page").val(next_page);

            }

        pagenumber = jQuery("#current_page").val();

        }
     discussiondataajax(category,fromdate,todate,amount,agegroup,sort_by,pagenumber);
    

  });

//-------onclick age grup funxtion
  jQuery(document).on("click",".agegroup",function(){
        var category = jQuery("input[name='categorychk[]']:checked")
        .map(function(){return jQuery(this).val();}).get();
        var fromdate = jQuery("#fromdate").val();
        var todate = jQuery("#todate").val();
        var amount = jQuery("#fromamount").val();
        //var toamount = jQuery("#toamount").val();
        var agegroup = $("input:radio.agegroup:checked").val();
        var sort_by =jQuery( "#sortby").val();
        var pagenumber = jQuery("#current_page").val();
      
        
     discussiondataajax(category,fromdate,todate,amount,agegroup,sort_by,pagenumber);
  });


/*main ajax function*/
function discussiondataajax(category,fromdate,todate,amount,agegroup,sort_by,pagenumber){

 category? category=category : category='';
 fromdate? fromdate=fromdate : fromdate='';
 todate? todate=todate : todate='';
 amount? amount=amount : amount='';
 agegroup? agegroup=agegroup : agegroup='';
 sort_by? sort_by=sort_by : sort_by='';
 pagenumber? pagenumber=pagenumber : pagenumber='1';

jQuery('.loader').css('display','block');
//------convert string to array---------
    if(!Array.isArray(category) && category!==''){
    var  categorys = [];
    categorys.push(category);
    category =categorys;
    }
    history.pushState(null, null, '?category='+category+'&fromdate='+fromdate+'&todate='+todate+'&amount='+amount+'&agegroup='+agegroup+'&sort_by='+sort_by+'&pagenumber='+pagenumber);
        jQuery.ajax({
        type : "post",
        url : "<?php echo base_url()?>/discussion/searchdiscussiondata",
        data : {
        category:category,fromdate:fromdate,todate:todate,amount:amount,agegroup:agegroup,sort_by:sort_by,pagenumber:pagenumber},
        success: function(response) {

        jQuery( "div.ajax_main_div_load_discussion" ).replaceWith(response);
      //new WOW().init();
      $("html, body").animate({  scrollTop: 0 }, 1000); 
        jQuery('.loader').css('display','none');
        }
 });
}

</script>