<script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>  
<script type="text/javascript">
$(function(){
    $('.field_nav').addClass('active');
$('#fieldedit').dataTable({
    "searching": false,
    "pageLength": 20,
    "bLengthChange": false,
    "ordering": false
});
  $('#editfieldform').validate({
        rules: {
            field:"required",
        },
        messages: {
            field:"Please enter field.",
        },
        submitHandler: function(form) {
            form.submit();
        }
    }); 
}); 
</script>
<div class="content-i security_que_page edit_faq_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box table_container">
                <h6 class="element-header">Edit Field</h6>
                <div class="table-responsive">
                    <form name="editfieldform" id="editfieldform" class="light_font_form" method="post" action="<?php echo base_url('admin/Expertfield_Master/edit/'.$fielddata->field_ID);?>">
                        <input type="hidden" name="id" value="<?php echo $fielddata->field_ID; ?>">
                        <div class="sequrity_que_spc">                           
                            <div class="form_group">
                                <label>Field</label>
                                <input type="text" name="field" id="field" class="input_text" value="<?php echo $fielddata->name; ?>">
                                <?php echo form_error('field');?>
                            </div>
                            <input type="submit" class="input_submit" name="submit" value="Update field">
                        </div>
                    </form>             
                    <table id="fieldedit" class="table manage_faq_table admin_table">
                        <thead> 
                            <tr>
                            <th class="no">No.</th>
                            <th class="ques_ans">Fields</th>
                            <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(count($allfield) > 0){
                                    $i = 1;
                                    foreach($allfield as $f){ ?>
                                        <tr>
                                            <td class="no"><?php echo $i.'.';?></td>
                                            <td>
                                                <div class="ques"><?php echo character_limiter($f->name,50);?></div>
                                            </td>
                                            <td class="row-actions action text-center">
                                                <a href="<?php echo base_url().'admin/edit-field/'.$f->field_ID;?>" title="Edit"><i class="icon icon-19"></i></a>
                                                <a href="<?php echo base_url().'admin/Expertfield_Master/delete/'.$f->field_ID;?>" onclick="return confirm('Are you sure you want to delete this field?')" title="Remove"><i class="icon icon-18"></i></a>
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