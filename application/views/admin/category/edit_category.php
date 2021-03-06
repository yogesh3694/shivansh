<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/admin/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript"> 
$(function(){ 
 $( document ).ready(function() {

    $('#edtcategory').DataTable({
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
 // $('.category_nav').addClass('active');
 //    $(".selectcls").select2({
 //        tags: true
 //    });
 //    $('#edtcategory').dataTable({
 //         "searching": false,
 //         "bLengthChange": false,
 //         "pageLength": 20,
 //         "ordering": false
 //    });
    
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
                element.next().next().append(error);
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
    var sid = $(this).attr('data-id');  
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

                $("a[data-id|="+sid+"]").removeClass('badge-danger-inverted');
                $("a[data-id|="+sid+"]").addClass('badge-success-inverted');
                $("a[data-id|="+sid+"]").text('Active');
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

                $("input[value="+cid+"]").prev('a').removeClass('badge-success-inverted');
                $("input[value="+cid+"]").prev('a').addClass('badge-danger-inverted');
                $("input[value="+cid+"]").prev('a').text('Deactive');  

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
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php
}
?>
<div class="content-i category_management_page edit_category_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box table_container"> 
                <h6 class="element-header">category Management</h6>
                <div class="table-responsive">
                    <form name="category" id="category" method="post" >
                        <div class="form-div">
                            <div class="row">
                                    <div class="col-md-5">
                                        <div class="form_group custom_select">
                                            <label>Edit Category</label>
                                            <?php if(!empty($subcatrow)){ ?>
                                            <select name="category" class="form-control selectcls">
                                              <option value="">Select Category</option>
                                              <?php
                                                foreach ($catoption as $category) {
                                                ?>
                                                    <option value="<?php echo $category->cat_id; ?>"
                                                      <?php if(isset($catrow)){ if($catrow->category_ID == $category->cat_id){ echo "selected"; }} ?>  >
                                                      <?php echo $category->cat; ?></option>
                                                <?php
                                                }
                                               ?>
                                            </select>
                                            <?php echo form_error('category');?>
                                            <?php 
                                            } 
                                            else{
                                            ?>
                                                <input type="text" class="input_text" name="category" value="<?php echo $catrow->name; ?>">
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form_group">
                                            <label>Edit Sub Category</label> <?php //print_r($subcatrow); exit; ?>
                                            <input type="text" name="subcategory" rows="5" class="input_text" id="subcategory" value="<?php if(isset($subcatrow)){ echo $subcatrow->name; } ?>"> 
                                             <?php echo form_error('subcategory');?> 
                                        </div>                                
                                    </div>  
                                <div class="col-md-2">
                                    <input type="submit" class="input_submit" name="catsubmit" value="Update">
                                </div>
                            </div>
                        </div>    
                    </form>  
                    <table id="edtcategory" class="table admin_table cate_manage_table">
                        <thead> 
                            <tr>
                            <th>No.</th>
                            <th>Categories</th>
                            <th>Sub Categories</th>
                            <th>Status</th>
                            <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if(count($categories) > 0){
                                $i = 1;
                            foreach($categories as $cat){ ?>
                                <tr>
                                    <td><?php echo $i.'.';?></td>
                                    <td><?php echo character_limiter($cat->cat,130);?></td>
                                    <td><?php if($cat->subcat != ''){echo $cat->subcat; }else{ echo '-'; } ?></td>
                                    <td>
                                        <?php 
                                        if($cat->subcat_id == '' ){ 
                                            $statusid = $cat->cat_id; 
                                        }
                                        else{
                                            $statusid = ''; 
                                        }
                                        if($cat->status == '' && $cat->cstatus == '1'){
                                            echo "<a href='javascript:void(0)' class='badge badge-success-inverted catstatus' data-id='".$cat->subcat_id."'>Active</a>"; 
                                        }
                                        else if ($cat->status == '' && $cat->cstatus == '0') {
                                            echo "<a href='javascript:void(0)' class='badge badge-danger-inverted catstatus' data-id='".$cat->subcat_id."'>Deactive</a>";
                                        }
                                        else if($cat->status == '1'){ 
                                            echo "<a href='javascript:void(0)' class='badge badge-success-inverted catstatus' data-id='".$cat->subcat_id."'>Active</a>"; 
                                        }
                                        else{
                                            echo "<a href='javascript:void(0)' class='badge badge-danger-inverted catstatus' data-id='".$cat->subcat_id."'>Deactive</a>";
                                        }
                                     ?>
                                    <input type="hidden" class="cathidden" name="cathidden" value="<?php echo $statusid; ?>">
                                     </td>
                                    <td> 
                                        <a href="<?php echo base_url().'admin/Category_Master/edit_category/'.$cat->cat_id.'/'.$cat->subcat_id; ?>"><i class="icon icon-19"></i></a>
                                        <a href="<?php echo base_url().'admin/Category_Master/delete_category/'.$cat->cat_id.'/'.$cat->subcat_id;?>" onclick="return confirm('Are you sure delete this recorde?')"><i class="icon icon-18"></i></a>
                                    </td>
                                </tr>
                            <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>