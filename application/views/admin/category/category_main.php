<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/admin/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript"> 
$( document ).ready(function() {

    $('#catmain').DataTable({
            "searching": false,
            "bLengthChange": false,
            "pageLength": 20,
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "language": {
                          "emptyTable": "No Category Found."
                      },
            "ajax":{
            url :"<?php echo base_url('admin/Category_Master/categorylist_ajaxnew') ?>", // json datasource
            type: "POST",  // type of method  , by default would be get

            }
    });   
});    
$(function(){ 
$(".selectcls").select2({
  tags: true
});
 
$('#category').validate({
    rules: {
        category:"required",
        //subcategory:"required",
    },
    messages: {
        category:"Please enter category.",
        //subcategory:"Please enter sub category",
    },
    errorPlacement: function(error, element) {
            if(element.attr('name') == "category"){
                element.parent('div').append(error);
            }else {
                error.insertAfter(element);
            }
        },     
    submitHandler: function(form) {
        form.submit();
    }
});
});
$(document).on('click', '.catstatus', function() {
        var sid = $(this).attr('subdata-id');  
        var mainid = $(this).attr('maindata-id');  
        var cid = $(this).next().val();  
     
        $.ajax({
            type:"POST",
            dataType:'json',
            url:"<?php echo base_url('admin/Category_Master/statusajax'); ?>",
            data: {
                subcatid : sid, catid : cid 
            },
            success:function(data){  
                if(data.status == 'actived'){ 
                    if(data.subcat==1){
                        // var new=$("a[subdata-id|").val();
                        // alert(new);

                        $("a[subdata-id|="+sid+"]").removeClass('badge-danger-inverted');
                        $("a[subdata-id|="+sid+"]").addClass('badge-success-inverted');
                        $("a[subdata-id|="+sid+"]").text('Active');
                    }else{

                        $("a[data-id|="+catid+"]").removeClass('badge-danger-inverted');
                        $("a[data-id|="+catid+"]").addClass('badge-success-inverted');
                        $("a[data-id|="+catid+"]").text('Active');

                         $("a[maindata-id|="+catid+"]").prev('a').removeClass('badge-success-inverted');
                    $("a[maindata-id|="+catid+"]").prev('a').addClass('badge-danger-inverted');
                    $("a[maindata-id|="+catid+"]").prev('a').text('Deactive');  
                    }
                 
                } else  if(data.status == 'deactived'){ 
                    if(data.subcat==1){
                 
                       $("input[value="+sid+"]").prev('a').removeClass('badge-success-inverted');
                    $("input[value="+sid+"]").prev('a').addClass('badge-danger-inverted');
                    $("input[value="+sid+"]").prev('a').text('Deactive');  
                    }else{
                       
                         $("input[value="+cid+"]").prev('a').removeClass('badge-success-inverted');
                    $("input[value="+cid+"]").prev('a').addClass('badge-danger-inverted');
                    $("input[value="+cid+"]").prev('a').text('Deactive');  
                    }
                 
                }
                else if(data.catstatus == 'catactived'){ 

                    $("input[value="+cid+"]").prev('a').removeClass('badge-danger-inverted')
                    $("input[value="+cid+"]").prev('a').addClass('badge-success-inverted')
                    $("input[value="+cid+"]").prev('a').text('Active'); 

                    // $("a[data-id|="+sid+"]").removeClass('badge-danger-inverted');
                    // $("a[data-id|="+sid+"]").addClass('badge-success-inverted');
                    // $("a[data-id|="+sid+"]").text('Active');
                }
                else if(data.catstatus == 'catdeactived'){
                    if(data.subcat==1){
                 
                       $("input[value="+sid+"]").prev('a').removeClass('badge-success-inverted');
                    $("input[value="+sid+"]").prev('a').addClass('badge-danger-inverted');
                    $("input[value="+sid+"]").prev('a').text('Deactive');  
                    }else{
                      

                         $("input[value="+cid+"]").prev('a').removeClass('badge-success-inverted');
                    $("input[value="+cid+"]").prev('a').addClass('badge-danger-inverted');
                    $("input[value="+cid+"]").prev('a').text('Deactive');  

                    $("a[maindata-id|="+cid+"]").removeClass('badge-success-inverted');
                    $("a[maindata-id|="+cid+"]").addClass('badge-danger-inverted');
                    $("a[maindata-id|="+cid+"]").text('Deactive');  

                    }

                    // $("input[value="+cid+"]").prev('a').removeClass('badge-success-inverted');
                    // $("input[value="+cid+"]").prev('a').addClass('badge-danger-inverted');
                    // $("input[value="+cid+"]").prev('a').text('Deactive');  

                    // $("a[data-id|="+sid+"]").removeClass('badge-success-inverted');
                    // $("a[data-id|="+sid+"]").addClass('badge-danger-inverted');
                    // $("a[data-id|="+sid+"]").text('Deactive');
                }
                else{

                    $("a[data-id|="+sid+"]").removeClass('badge-success-inverted');
                    $("a[data-id|="+sid+"]").addClass('badge-danger-inverted');
                    $("a[data-id|="+sid+"]").text('Deactive');
                }
            },
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
<div class="content-i category_management_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box table_container"> 
                <h6 class="element-header">category Management</h6>
                <div class="table-responsive">
                    <form name="category" id="category" method="post" action="<?php echo base_url('admin/Category_Master/add_category');?>">
                        <div class="form-div">
                            <div class="row">
                                    <div class="col-md-5">
                                        <div class="form_group custom_select">
                                            <label>Add New Category</label>
                                            <!-- <input type="text" name="category" id="category" class="form-control" value="<?php echo set_value('categoryen');?>"> -->
   
                                            <select name="category" class="form-control selectcls">
                                              <option value="">Select Category</option>
                                              <?php
                                                foreach ($catoption as $category) {
                                                ?>
                                                    <option value="<?php echo $category->cat_id; ?>" ><?php echo $category->cat; ?></option>
                                                <?php
                                                }
                                               ?>
                                            </select>

                                            <?php echo form_error('category');?>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form_group">
                                            <label>Add New Sub Category</label>
                                            <input type="text" name="subcategory" rows="5" class="input_text" id="subcategory"> 
                                             <?php echo form_error('subcategory');?> 
                                        </div>                                
                                    </div>  
                                <div class="col-md-2">
                                    <input type="submit" class="input_submit" name="catsubmit" value="Submit">
                                </div>
                            </div>
                        </div>    
                    </form>  
                    <table id="catmain" class="table admin_table cate_manage_table">
                        <thead> 
                            <tr>
                            <th>No.</th>
                            <th>Categories</th>
                            <th>Sub Categories</th>
                            <th>Status</th>
                            <th class="action">Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>