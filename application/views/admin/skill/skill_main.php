 <script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js"></script>
 <script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>  
<script type="text/javascript"> 
$(function(){
$('#skillmain').dataTable({
    "searching": false,
    "pageLength": 20,
    "bLengthChange": false,
    "ordering": false
});
  $('#sec').validate({
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
 <?php 
    if($this->session->flashdata('success') != ''){ ?>
    <div class="alert-success alert alert-dismissible">
        <?php echo $this->session->flashdata('success'); ?>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>

<?php
}
?>
<div class="content-i security_que_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box table_container">
                <h6 class="element-header">Manage Skills</h6>
                <!-- <h5 class="form-header">
                    <a href="<?php echo base_url(); ?>admin/Faq_Master/add_faq">+ ADD NEW FAQ</a>
                </h5> -->
               <!--  <div class="form-desc">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table.. <a href="https://www.datatables.net/" target="_blank">Learn More about DataTables</a></div> -->
                <div class="table-responsive">
                    <form name="sec" id="sec" class="light_font_form" method="post" action="<?php echo base_url('admin/Skill_Master/add_skill');?>">
                        <div class="sequrity_que_spc">                           
                            <div class="form_group">
                                <label>Skill</label>
                                <input type="text" name="skill" id="skill" class="input_text" value="<?php echo set_value('skill');?>">
                                <?php echo form_error('skill');?>
                            </div>
                                <!-- <div class="form_group">
                                    <label>Answer</label>
                                    <textarea name="answer" rows="5" class="input_textarea" id="answer"></textarea>
                                     <?php echo form_error('answer');?> 
                                </div> -->
                            <input type="submit" class="input_submit" name="submit" value="Add Skill">
                        </div>    
                    </form>  
                    <table id="skillmain" class="table manage_faq_table admin_table">
                        <thead> 
                            <tr>
                            <th class="no">No.</th>
                            <th class="ques_ans">Skills</th>
                            <th class="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(count($skilldata) > 0){
                                    $i = 1;
                                    foreach($skilldata as $f){ ?>
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