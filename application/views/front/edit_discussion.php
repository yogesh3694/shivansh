<?php //echo "<pre>"; print_r($userbid); exit; ?> 
<script type="text/javascript" src="<?php echo base_url();?>assets/front/filejs/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/front/filejs/moxie.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/front/filejs/plupload.dev.js"></script> 
<div class="main">
        <div class="bradcume-section">
            <div class="container">
                    <h2>Edit Discussion</h2>
            </div>
        </div>
        <section class="myprofile-main-section post-discussion-main-section">
            <div class="container">
               <!--  <form name="" id="" action="" method=""> -->
                <?php if($this->session->flashdata('success')){ ?>
            <div class="alert-success alert alert-dismissible"><?php echo $this->session->flashdata('success'); ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
            <?php } ?>
            <?php if($this->session->flashdata('fail')){ ?>
            <div class="alert-danger alert alert-dismissible"><?php echo $this->session->flashdata('fail'); ?><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
            <?php } ?>
                 <form id="post_discussion_form" method="POST" enctype="multipart/form-data">
                    <div class="panel panel-default profile-pd01">
                        <div class="panel-body">
                            <div class="form01">
                                <div class="row custom-row-padding custom-row-padding01">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="main-label-title">Discussion Title</div>
                                        <input name="discussion_title" class="form-controlcls" type="text" maxlength="40" value="<?php echo $disdata->discussion_title; ?>">
                                         <?php echo form_error('discussion_title');?>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <div class="main-label-title">Category</div>
                                        <select class="form-control" id="trader_category" name="category_ID">
                                            <option value="">Category</option>
                                            <?php foreach ($category as $category_val) { ?>
                                            <option value="<?php echo $category_val->category_ID; ?>"<?php if($category_val->category_ID == $disdata->category_ID){ echo "selected"; } ?>><?php echo $category_val->name;?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('category_ID');?>

                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <div class="main-label-title">Sub Category</div>
                                        <select class="form-control" id="trader_sub_category" name="sub_category">
                                            <option value="">Sub Category</option>
                                        <?php foreach ($subcat as $subc) {
                                            ?>
                                                <option value="<?php echo $subc->sub_category_ID; ?>"
                                            <?php if($subc->sub_category_ID == $disdata->sub_category){
                                                    echo "selected";
                                                     } ?>
                                                     ><?php echo $subc->name; ?></option>    
                                            <?php
                                            } ?>
                                           </select>
                                           <?php echo form_error('sub_category');?>
                                    </div>
                                </div>
                                <div class="row custom-row-padding custom-row-padding02">
                                    <div class="col-md-2 col-sm-2">
                                        <div class="main-label-title">Base Price</div>
                                        <div class="quantity">
                                            <input type="number" name="base_price" class="form-controlcls" id="base_price" min="0" max="100000" pattern="[0-9]" step="1" value="<?php echo $disdata->base_price; ?>" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                        <?php echo form_error('base_price');?>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <div class="main-label-title">Age Group</div>
                                        <select class="form-control" name="age_group">
                                             <option value="">Age Group</option>
                                            <?php foreach ($trader_age_group as $trader_age_group_val) { ?>
                                            <option value="<?php echo $trader_age_group_val->age_ID;?>"<?php if($trader_age_group_val->age_ID == $disdata->age_group){echo "selected"; } ?>><?php echo $trader_age_group_val->age_range;?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('age_group');?>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="main-label-title">Discussion Start Date & Time</div>
                                        <div class="from-to-main-section">
                                            <div class="from-date-section">
                                                <input type="text" id="basic_example_3" placeholder="Discussion Start Date & Time" class="form-controlcls" name="discussion_start_datetime" value="<?php echo date('m/d/Y h:i a',strtotime($disdata->discussion_start_datetime)); ?>" readonly>
                                                    <?php echo form_error('discussion_start_datetime');?>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="main-label-title">Bid Closing Date</div>
                                        <div class="from-to-main-section">
                                            <div class="form-to-date-section">
                                                <input type="text" id="datepicker-to" placeholder="Bid Closing Date" class="form-controlcls" name="closing_date" value="<?php echo date('m/d/Y',strtotime($disdata->closing_date)); ?>" readonly>
                                                <?php echo form_error('closing_date');?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row custom-row-padding custom-row-padding03">
                                    <div class="col-md-2 col-sm-3 col-md-width">
                                        <div class="main-label-title">Required Presenter</div>
                                <select class="form-control" name="require_presenter" id="require_presenter">
                                            <option value="">Presenter</option>
                                            <?php for($i=1;$i<11;$i++){ ?>
                                            <option value="<?php echo $i;?>" <?php if($i == $disdata->require_presenter){echo "selected"; } ?>><?php echo $i;?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('require_presenter');?>
                                    </div>
                                    <div class="col-md-2 col-sm-3 col-md-width">
                                        <div class="main-label-title">Required Attendee</div>
                                        <select class="form-control" name="require_attendee">
                                             <option value=""> Attendee</option>
                                            <?php for($i=1;$i<11;$i++){ ?>
                                            <option value="<?php echo $i;?>"<?php if($i == $disdata->require_attendee){echo "selected"; } ?>><?php echo $i;?></option>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('require_attendee');?>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-md-width01">
                                        <div class="main-label-title">Mark Yourself Presenter</div>
                                        <div class="flex-div">
                                            <label class="customcheckbox">
                                                <input value="1" <?php if($disdata->isPresenter == '1'){ echo "checked"; } ?> type="checkbox" name="isPresenter" id="isPresenter">
                                                <span class="customcheckbox-inner"></span>
                                                Join As Presenter?
                                            </label>
                                            <div class="bid_error_div">
                                                
                                            <input name="bid" class="form-controlcls input-width-cls" type="number"   min="0" placeholder="Enter Your Bid" id="bid" value="<?php echo $userbid; ?>"  onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row custom-row-padding04">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="main-label-title">Detail Requirment</div>
                                        <textarea class="form-control" name="requirment_detail"><?php echo $disdata->requirment_detail; ?></textarea>
                                        <?php echo form_error('requirment_detail');?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="panel panel-default profile-pd02">

                        <div class="panel-body">
                            <div class="form02">
                                <div class="row custom-row-padding">
                                    <div class="col-md-12">
                                        <label class="main-label-title">Skills Required For The Discussion <small>(Max.
                                                5) (Optional)</small></label>
                                        <select class="form-control select02" multiple="multiple" name="skill_required_discussion[]" id="drp">
                                            <?php $skill = explode('|',$disdata->skill_required_discussion);  ?>
                                          <?php foreach ($trader_skill as $trader_skill_value) { ?>
                                            <option value="<?php echo $trader_skill_value->skill_ID ;?>"<?php if(in_array($trader_skill_value->skill_ID,$skill)){echo "selected"; } ?>><?php echo $trader_skill_value->name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                          
                                <div class="row custom-row-attachment">
                                    <div class="col-md-12">
                                <label class="main-label-title">Attachement <small>(Optional)</small></label>
                               
                                <div id="fileuploads">
                                    <table role="presentation"><tbody class="files">
                                    <div id="filelist">
                                        <?php
                                      
                                        if($disdata->attachement != ''){
                                            
                                            $files=explode('|',$disdata->attachement);
                                            ?>
                                            <input type="hidden" name="totaledtfiels" id="totaledtfiels" value="<?php echo count($files);?>">
                                            <?php
                                            foreach ($files as $key=>$values) {
                                            ?>
                 
                                        <div id="<?php echo 'divatt_'.$key;?>"><input type="hidden" name="attachment[]" value="<?php echo $values; ?>" id="<?php echo $key;?>del"><?php echo $values; ?><span id="deletfiles" onclick=deletfiles("1","divatt_<?php echo $key;?>");><i class="fa fa-times" aria-hidden="true"></i><span id="deletefile"></span> <b></b></div>
                                            <?php    
                                            }
                                        } ?>

                                    </div>
                                    </tbody></table>
                                    <div class="fileupload-buttonbar">
                                    <div class="fileupload-buttons">
                                    <span class="fileinput-button custom-file-label-buton">
                                    <div id="container">
                                    <span id="pickfiles" href="javascript:;">Upload File</span>
                                 
                                    </div>
                                    </span>
                                    <h5 class="max_err_cls">(Upload maximum 5 files with extensions including png,jpg,pdf,xls and doc format)</h5>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                </div>
                             </div>
                        </div>
                    </div>

                    <button type="submit" name="submit" class="blue-button"  id="uploadfiles">Update discussion</button>
                </form>

            </div>
        </section>
    </div>


<script type="text/javascript">

//----------------------
$('#isPresenter').on("change", function () {

    var baseprice=$('#base_price').val();
    var require_presenter=$('#require_presenter').val();
    var bidprice=Math.round(baseprice/require_presenter);

    if($(this).prop("checked") == true){

        $('#bid').rules('add', {
            required: true,
            max: bidprice, //kishan set rules
        messages:{
            required:"Please enter your bid.",
            max : "Please enter bid less then or equal to $"+bidprice+".",
            }
        });
        $('#bid').focus();

        $('#bid').val(<?php echo $userbid; ?>);//kishan set old bid value if checkbox is checked
    }else{

        $("#bid-error").remove();
        $('#bid').rules('remove', 'required');
        $('#bid').rules('remove', 'max');
        $('#bid').val('');//kishan bid value remove if checkbox is unchecked
    }
});

var d = new Date();
var randfilename = d.getTime();
var imagemaxarr=[]; 
var imagemaxarrname=[]; 
var totalfilesupd=$('#totaledtfiels').val();

if(totalfilesupd!='' || totalfilesupd!=0){

    for($d=0;$d<totalfilesupd;$d++){
imagemaxarr.push($d);
    }
}

var uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
    browse_button : 'pickfiles', // you can pass an id...
    container: document.getElementById('container'), // ... or DOM Element itself
   unique_names: true,
     rename: true,
    url : '<?php echo base_url(); ?>/fileupload',
   
    flash_swf_url : '../js/Moxie.swf',
    silverlight_xap_url : '../js/Moxie.xap',
    
    filters : {
        max_file_size : '10mb',
        mime_types: [
            {title : "Image files", extensions : "jpg,jpeg,png,doc,pdf,xls,xlsx"},
            //{title : "Zip files", extensions : "zip"}
        ]
    },

    init: {
        PostInit: function() {
            //document.getElementById('filelist').innerHTML = '';

            document.getElementById('uploadfiles').onclick = function() {
            
            };
        },

        FilesAdded: function(up, files,response) {
                 var maxfiles = 4;
                 //-file exists or not
                 $(".file_error").remove();
                 $('.loader').show();
            plupload.each(files, function(file) {
                     $.ajax({
                    url:'upload/discussion/'+file.name,
                    type:'HEAD',
                    error: function()
                    {
                    //file not exists
                     
                    var fln = imagemaxarrname.includes(file.name);

                    if(fln==true){
                         $(".fileupload-buttons").after('<div class="file_error">' + file.name + ' file  is already exists.</div>'); 

                         return false;
                    }
                    if(imagemaxarr.length > maxfiles )
                     {
                         $(".file_error").remove();
                        $(".fileupload-buttons").after('<div class="file_error">You can upload maximum 5 files.</div>');
                        setTimeout(function(){ $('.loader').hide(); }, 500);
                        
                     }else{
                       
                        imagemaxarr.push(1);
                        imagemaxarrname.push(file.name);
                        
                    document.getElementById('filelist').innerHTML += '<div id="' + file.id + '"><input type="hidden" name="attachment[]" value="" id="' + file.id + 'del">' + file.name + '<span id="deletfiles" onclick=deletfiles("1","' + file.id + '");><i class="fa fa-times" aria-hidden="true"></i><span id="deletefile"></span> <b></b></div>';
               
                 uploader.start();
                    }
                    },
                    success: function()
                    {
                    //file exists
                   var fln = imagemaxarrname.includes(file.name);

                    if(fln==true){
                       //  $(".file_error").remove();
                         $(".fileupload-buttons").after('<div class="file_error">'+file.name +' file  is already exists.</div>'); 
                          setTimeout(function(){ $('.loader').hide(); }, 500);

                         return false;
                    }
                    if(imagemaxarr.length > maxfiles )
                     {
                       $(".file_error").remove();
                        $(".fileupload-buttons").after('<div class="file_error">You can upload maximum 5 files.</div>');
                         setTimeout(function(){ $('.loader').hide(); }, 500);
                        
                     }else{
                         imagemaxarr.push(1);
                         imagemaxarrname.push(file.name);
                        $('.loader').show();


                    document.getElementById('filelist').innerHTML += '<div id="' + file.id + '"><input type="hidden" name="attachment[]" value="" id="' + file.id + 'del">' + file.name + '<span id="deletfiles" onclick=deletfiles("1","' + file.id + '");><i class="fa fa-times" aria-hidden="true"></i><span id="deletefile"></span> <b></b></div>';
                    //$(".file_error").remove();
                    // $(".fileupload-buttons").after('<div class="file_error">'+file.name +' file  is already exists.</div>'); 

                     uploader.start();
                    setTimeout(function(){ $('.loader').hide(); }, 500);
                    }

                    }
                    });
               

            });
             
        },

FileUploaded: function(up, file, response) {
           $('#'+file.id+'del').val(response.response);
           $('.loader').hide();
           
        },
        Error: function(up, err) {
            $(".file_error").remove();
            if(err.code=='-600'){
                 $(".fileupload-buttons").after("<div class='file_error'>File must be less than 10mb.</div>"); 
                 $('.loader').hide();
            }else{

            document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
        }
        }
    }
});

uploader.init();
// Custom example logic
function deletfiles(t,id){
  $(".file_error").remove();
  $('.loader').show();
    var flname=$('#'+id+'del').val();
    imagemaxarr.pop(); 

    var index = imagemaxarrname.includes(flname);

    if (index == true) {
    imagemaxarrname.splice(index, 1);
    }
    var flname=$('#'+id+'del').val();
        $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>/Discussion/discussionfiledelete",
        data: {file:flname},
      }).done(function( msg ) {
       $('#'+id).remove();
       $('.loader').hide();
      });
     
}
</script>
<script>

 

$(document).ready(function () {


var tomaxdate=$('#basic_example_3').val();
    
    var d1 = new Date(tomaxdate);
    var year = d1.getFullYear();
    var month = d1.getMonth()+1;
    var day = d1.getDate();
     
    if(d1.getMonth()==0){
        var month1 = d1.getMonth();
        var month = d1.getMonth()+1;
        var todates=new Date(year, month1, day-6);
        var todatesnew=new Date(year, month1, day-1);
    }else{
      
        var month = d1.getMonth();
        var month1 = d1.getMonth();
        var todates=new Date(year, month, day-6);
        var todatesnew=new Date(year, month1, day-1);
    }

    var frdates=new Date(year, month, day);
    var ttdates=new Date(year, month, day-6);

    jQuery('#datepicker-to').datepicker({
            minDate: new Date(ttdates),
            maxDate: new Date(frdates),
            //dateFormat: 'DD, MM, d, yy',
            constrainInput: true 
        });
          
          
           
           /*
        $("#datepicker-to").focusout();
        $( "#datepicker-to" ).datepicker( "option", "minDate", todates );
        $( "#datepicker-to" ).datepicker( "option", "maxDate", todatesnew );
       
       
        var d2 = new Date(todates);
            var year1 = d2.getFullYear();
            var month1 = d2.getMonth();
            var day1 = d2.getDate();
      
            if(d2.getMonth()==0){
               
                var month1 = d2.getMonth()+1;
                
                $("#datepicker-to").val(month1+'/'+(day1)+'/'+year1);
            }else{
                if(d2.getMonth()==1){
                   
                    var month1 = d2.getMonth()+1;
                }else{
                var month1 = d2.getMonth();
                }
                $("#datepicker-to").val(month1+'/'+(day1)+'/'+year1);
            }
*/







  /*--------------------------------------------------------------------------------------*/

    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDate();
   
    var dateFormat = "mm/dd/yy",
    from = $("#datepicker-form")
    .datepicker({
    defaultDate: "+1w",
    changeMonth: true,

    numberOfMonths: 1,
     minDate: 0

    })
    //for bid input-----------
    $( "#base_price" ).focusout(function() {
         var baseprice=$('#base_price').val();
         if(baseprice!=''){
             $('.error_bid').remove();
         }
    });

$("#require_presenter").change(function () {

        var baseprice=$('#base_price').val();
        var require_presenter=$('#require_presenter').val();
        var bidprice=Math.round(baseprice/require_presenter);
 
    if($("#require_presenter").val()!='' ){
        $('.error_bid').remove();
        $('#bid').rules('add', {
        //required: true,
         max: bidprice,

        messages:{
        //required:"Please enadter your bid.",
        max : "Please enter bid less then or equal to $"+bidprice+".",
        }
        });

     }else{
          //$('#bid').rules('remove', 'required');
            $('#bid').rules('remove', 'max');
     }
});  

    $("#isPresenter").click(function () {
        
        if($('#isPresenter').prop("checked") == true){
             
        $('.error_bid').remove();
        }else{
            $('#bid').rules('remove', 'required');
            $('#bid').rules('remove', 'max');
           // $('.error_bid').remove();
        }
         
    });

 
$( "#bid" ).focusout(function() {

   var baseprice=$('#base_price').val();
   var require_presenter=$('#require_presenter').val();
   var basepricebid=$( "#bid" ).val();

    $('.error_bid').remove();

    if($('#isPresenter').prop("checked") == false && basepricebid!=''){
    $('#bid').after('<label class="error_bid error" id="error_bid">Please tick join as presenter first.</label>');
    $( "#bid" ).val('');
             /*$('#bid').rules('add', {
                required: true,
                // max: bidprice,
                messages:{
                required:"Please tick join as presenter first.",
                //max : "Please enter bid less then or equal to $"+bidprice+".",
                }
            });*/
    return false;
   }else if(baseprice=='' && basepricebid!==''){
  
    $('#bid').after('<label class="error_bid error" id="error_bid">Please enter base price first.</label>');
    $('#bid').val('');
    return false;
   }else  if(require_presenter=='' && basepricebid!=''){

     $('#bid').after('<label class="error_bid error" id="error_bid">Please select presenter first.</label>');
         $('#bid').val('');

            return false;
    }else{
        var bidprice=Math.round(baseprice/require_presenter);
        if($('#isPresenter').prop("checked") == true){
            $('#bid').valid();
            $('#bid').rules('add', {
                required: true,
                // max: bidprice,
                messages:{
                required:"Please enter your bid.",
                //max : "Please enter bid less then or equal to $"+bidprice+".",
                }
            });
        }
    }
   
  })
    //-----------------------
    .on("change", function () {
    to.datepicker("option", "minDate", getDate(this));
    }),

    to = $("#datepicker-to").datepicker({
    defaultDate: "+1w",
    changeMonth: true,

    numberOfMonths: 1,
     minDate: 0,
    // maxDate: new Date(year + 1, month, day),
      
    })
    .on("change", function () {
    from.datepicker("option", "maxDate", getDate(this));
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
    $('#date').combodate({ customClass: 'form-control' });
    $(".js-example-tokenizer").select2({

    tags: true,
    tokenSeparators: [',', ' ']
    })

    $('#basic_example_3').datetimepicker({
        timeFormat: "hh:mm tt",
         minDate: 0,
         changeYear: false,
         maxDate: new Date(year + 1, month, day),
         onClose: function( selectedDate ) {
            var tomaxdate=$('#basic_example_3').val();
           //   alert(tomaxdate);
            var d1 = new Date(tomaxdate);
            var year = d1.getFullYear();
            var month = d1.getMonth()+1;
            var day = d1.getDate();
            
           
           
            if(d1.getMonth()==0){
                var month1 = d1.getMonth();
                var month = d1.getMonth()+1;
                var todates=new Date(year, month1, day-6);
                var todatesnew=new Date(year, month1, day-1);
            }else{
              
                var month = d1.getMonth();
                var month1 = d1.getMonth();
                var todates=new Date(year, month, day-6);
                var todatesnew=new Date(year, month1, day-1);
            }
          
           
          //alert(d2.getMonth());
       // $("#datepicker-to").val(month+'/'+(day-5)+'/'+year);
        $("#datepicker-to").focusout();
        $( "#datepicker-to" ).datepicker( "option", "minDate", todates );
        $( "#datepicker-to" ).datepicker( "option", "maxDate", todatesnew );
       
       
        var d2 = new Date(todates);
            var year1 = d2.getFullYear();
            var month1 = d2.getMonth();
            var day1 = d2.getDate();
      
            if(d2.getMonth()==0){
               
                var month1 = d2.getMonth()+1;
                
                $("#datepicker-to").val(month1+'/'+(day1)+'/'+year1);
            }else{
                if(d2.getMonth()==1){
                   
                    var month1 = d2.getMonth()+1;
                }else{
                var month1 = d2.getMonth();
                }
                $("#datepicker-to").val(month1+'/'+(day1)+'/'+year1);
            }
       
       

      },
    });
    });

    $("#drp").select2({maximumSelectionLength: 5  });
    //--------for category
    $("#trader_category").click(function () {
    var  category=this.value;
    $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>/Discussion/getsubcategory",
    data: {id:category},
    beforeSend: function(data) {
        //jQuery("#trader_sub_category").prop("disabled", true);
        jQuery("#trader_sub_category").html("<option>Please wait..</option>");
    },
    }).done(function( msg ) {
    $('#trader_sub_category option').remove();
    $("#trader_sub_category").append(msg);

    });


    });

    </script>

    <script type="text/javascript">
    $(function(){
       /*  $.validator.addMethod("nowhitespace", function(value, element) {
        return this.optional(element) || /^S+$/i.test(value);
      }, "No white space please");
*/
    $('#post_discussion_form').validate({
        rules: {
            user_email:{
                required:true,
                email:true
            },
            discussion_title:{required:true},
            category_ID:"required",
            sub_category:"required",
             base_price:{
                required:true,
                number:true,
                max: 100000
            },
            age_group:"required",
            discussion_start_datetime:"required",
            closing_date:"required",
            require_presenter:"required",
            require_attendee:"required",
            requirment_detail:"required",
        },
        messages: {
            user_email:{
                required:"Please enter email.",
                email:"Your entered email is not valid."
                },
            discussion_title:"Please enter discussion title.",
            category_ID:"Please select category.",
            sub_category:"Please select sub category.",
             base_price:{
                required:"Please enter base price.",
                number:"Please enter valid price.",
                max:"Please enter less then or equal to $100000 base price.",
                },
            
            age_group:"Please select age group.",
            discussion_start_datetime:"Please select discussion start datetime.",
            closing_date:"Please select closing date.",
            require_presenter:"Please select number of presenter.",
            require_attendee:"Please select number of attendee.",
            requirment_detail:"Please enter requirment detail.",
        },

        submitHandler: function(form) {
            $('.error_bid').remove();
            form.submit();
        }

    });



        var baseprice=$('#base_price').val();
        var require_presenter=$('#require_presenter').val();
        var bidprice=Math.round(baseprice/require_presenter);
 //alert(bidprice);

        if($("#require_presenter").val()!=''){

            if($('#isPresenter').prop("checked") == true){

                $('.error_bid').remove();
 
                $('#bid').rules('add', {
                    //required: true,
                    max: bidprice,

                    messages:{
                    //required:"Please enadter your bid.",
                    max : "Please enter bid less then or equal to $"+bidprice+".",
                    }
                });
            }
         }
         else{
              //$('#bid').rules('remove', 'required');
                $('#bid').rules('remove', 'max');
         }

  /*       $('#isPresenter').change(function(){
            if($('#isPresenter').prop("checked") == true){
                $('#bid').rules('add', {
                    //required: true,
                    max: bidprice,

                    messages:{
                    //required:"Please enadter your bid.",
                    max : "Please enter bid less then or equal eeeeeeeeeee to $"+bidprice+".",
                    }
                });
            }
            else{
                $('.error_bid').remove();
            }            
         })*/
});
    </script>
    <script type="text/javascript">
            jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
            jQuery('.quantity').each(function() {
              var spinner = jQuery(this),
                input = spinner.find('input[type="number"]'),
                btnUp = spinner.find('.quantity-up'),
                btnDown = spinner.find('.quantity-down'),
                min = input.attr('min'),
                max = input.attr('max');

              btnUp.click(function() {
                var oldValue = parseFloat(input.val());
                if (oldValue >= max) {
                  var newVal = oldValue;
                } else {
                  var newVal = oldValue + 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
              });

              btnDown.click(function() {
                var oldValue = parseFloat(input.val());
                if (oldValue <= min) {
                  var newVal = oldValue;
                } else {
                  var newVal = oldValue - 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
              });

            });
    </script>