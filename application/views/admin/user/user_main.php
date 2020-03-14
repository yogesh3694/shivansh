<script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {

    $('#usertable').DataTable({
            "searching": false,
            "bLengthChange": false,
            
            "ordering": false,
           
            "pageLength": 20,
            "processing": true,
            "serverSide": true,
            "language": {
                          "emptyTable": "No Users Found."
                      },
            "ajax":{
            url :"<?php echo base_url('admin/User_Master/userlist_ajax') ?>", // json datasource
            type: "POST",  // type of method  , by default would be get

            }
    });   
});

</script>
<?php 
	if($this->session->flashdata('success') != ''){
?>
	<div class="alert-success alert alert-dismissible">
		<?php echo $this->session->flashdata('success'); ?>
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	</div>
<?php
}
?>
<div class="content-i manage_user_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box table_container">
            	<h6 class="element-header">Manage Users</h6>
                <h5 class="form-header add_user">
                	<a href="<?php echo base_url(); ?>admin/add-user">+ ADD NEW USER</a>
                </h5>
                <div class="table-responsive">
					<table id="usertable" width="100%" class="table admin_table manage_user_table">
					    <thead>
					        <tr>
					            <th class="t_no">No.</th>
					            <th>Name</th>
					            <th>Location</th>
					            <th>Skill Points</th>
					            <th>E-Market Points</th>
					            <!-- <th class="text-center">Status</th> -->
					            <th class="text-center">Action</th>
					        </tr>
					    </thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>