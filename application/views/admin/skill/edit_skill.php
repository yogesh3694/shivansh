<script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>  
<script type="text/javascript">
$(function(){
    $('.skill_nav').addClass('active');
$('#queedit').dataTable({
    "searching": false,
    "pageLength": 20,
    "bLengthChange": false,
    "ordering": false
});
  $('#editfaq').validate({
        rules: {
            skill:"required",
        },
        messages: {
            skill:"Please enter skill.",
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
                <h6 class="element-header">Edit Skill</h6>
                <div class="table-responsive">
                    <form name="editfaq" id="editfaq" class="light_font_form" method="post" action="<?php echo base_url('admin/Skill_Master/edit/'.$skilldata->skill_ID);?>">
                        <input type="hidden" name="id" value="<?php echo $skilldata->skill_ID; ?>">
                        <div class="sequrity_que_spc">                           
                            <div class="form_group">
                                <label>skill</label>
                                <input type="text" name="skill" id="skill" class="input_text" value="<?php echo $skilldata->name; ?>">
                                <?php echo form_error('skill');?>
                            </div>
                            <input type="submit" class="input_submit" name="submit" value="Update skill">
                        </div>
                    </form>             
                    <table id="queedit" class="table manage_faq_table admin_table">
                        <thead> 
                            <tr>
                            <th class="no">No.</th>
                            <th class="ques_ans">Skills</th>
                            <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(count($allskill) > 0){
                                    $i = 1;
                                    foreach($allskill as $f){ ?>
                                        <tr>
                                            <td class="no"><?php echo $i.'.';?></td>
                                            <td>
                                                <div class="ques"><?php echo character_limiter($f->name,50);?></div>
                                            </td>
                                            <td class="row-actions action text-center">
                                                <a href="<?php echo base_url().'admin/edit-skill/'.$f->skill_ID;?>" title="Edit"><i class="icon icon-19"></i></a>
                                                <a href="<?php echo base_url().'admin/Skill_Master/delete/'.$f->skill_ID;?>" onclick="return confirm('Are you sure you want to delete this skill?')" title="Remove"><i class="icon icon-18"></i></a>
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