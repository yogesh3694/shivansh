<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/admin/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript"> 

$( document ).ready(function() {

    $('#dismain').DataTable({
            "searching": false,
            "bLengthChange": false,
            "aaSorting": [],
            "ordering": true,
            columnDefs: [{
            orderable: false,
            targets: "no-sort"
            }],
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "language": {
                          "emptyTable": "Withdrow Request Not Found."
                      },
            "ajax":{
            url :"<?php echo base_url('admin/Discussion_Master/disc_ajax') ?>", // json datasource
            type: "POST",  // type of method  , by default would be get
            error: function(){  // error handling code
              $("#employee_grid_processing").css("display","none");
            }

            }
    });   
});

$(function(){ 
$(".selectcls").select2({
  tags: true
});


$('#discussion').validate({
    rules: {
        category:"required",
        //subcategory:"required",
    },
    messages: {
        category:"Please enter category",
        //subcategory:"Please enter sub category",
    },
    submitHandler: function(form) {
        form.submit();
    }
});
});

</script>
 <?php 
    if($this->session->flashdata('success') != ''){ ?>
    <div class="alert-success alert alert-dismissible">
        <?php echo $this->session->flashdata('success'); ?>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
<?php
}
?>
<div class="content-i manage_discussion_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box table_container"> 
                <h6 class="element-header">Manage Discussions</h6>
                <div class="table-responsive"> <?php //print_r($disdata); exit; ?>
                    <table id="dismain" class="table admin_table display">
                        <thead> 
                            <tr>
                            <th class="no-sort">No.</th>
                            <th class="no-sort">Title</th>
                            <th class="no-sort">Budget</th>
                            <th class="no-sort">Category</th>
                            <th class="">Date & Time</th>
                            <th class="no-sort">Status</th>
                            <th class="no-sort action">Action</th>
                            </tr>
                        </thead>
                        <!-- <tbody></tbody> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).on("click",".catstatus",function(e){

    var id=e.target.id;
    var status=$('#custatus_'+id).val();
    $("#"+id).replaceWith('<select name="change_status'+id+'" class="catstatusselect" id="'+id+'"><option value="1">open</option><option value="2">close</option><option value="4">Cancell</option><option value="3">Completed</option></select>');

   $('#'+id).val(status);
});


jQuery(document).on("change",".catstatusselect",function(e){
     var discussion_ID=e.target.id;
     var status=$(this).val();
    $.ajax({
        type:'POST',
        url:"<?php echo base_url().'admin/Discussion_Master/admin_dicsussion_status' ?>",
        data:{ discussion_ID:discussion_ID,status: status},
        success:function(html){  
           window.location.href="<?php echo base_url();?>/admin/discussions";
        }
    });                
});

</script>