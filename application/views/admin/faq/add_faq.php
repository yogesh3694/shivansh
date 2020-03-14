

<div class="content-i">
    <div class="content-box">
        <div class="element-wrapper">
            <h6 class="element-header">Add FAQ</h6>
            <div class="element-box">
                <div class="table-responsive">
                    <form name="faq" id="faq" method="post" action="<?php echo base_url('admin/Faq_Master/add_faq');?>">
                        <div class="form-div">
                            <div class="row">
                                <!-- <div class="halfdiv"> -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Question</label>
                                            <input type="text" name="question" id="question" class="form-control" value="<?php echo set_value('questionen');?>">
                                            <?php echo form_error('question');?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Answer</label>
                                            <textarea name="answer" rows="5" class="form-control" id="answer"></textarea>
                                             <?php echo form_error('answer');?> 
                                        </div>                                
                                    </div>  
                                    <div class="clear"></div>                          
                                <!-- </div> -->
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Add Faq">
                                </div>
                            </div>
                        </div>    
                    </form>                                 
                </div>
            </div>
        </div>
    </div>
</div>

 