<script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#subscriber').DataTable({
		"searching": false,
            "bLengthChange": false,
            "aaSorting": [],
            "ordering": false,
			"pageLength": 10,
            columnDefs: [{
            orderable: false,
            targets: "no-sort"
            }]
    } );
} );
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
<div class="content-i manage_user_page  manage_subscribe_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box table_container">
            	<h6 class="element-header">Manage Subscribers</h6>
                <!-- <h5 class="form-header add_user">
                	<a href="<?php echo base_url(); ?>admin/User_Master/add_user">+ ADD NEW USER</a>
                </h5> -->
                <div class="table-responsive">
					<table id="subscriber" width="100%" class="table admin_table manage_user_table">
					    <thead>
					        <tr>
					            <th class="t_no">No.</th>
					            <th>Email</th>
					            </tr>
					    </thead>
						<tbody>
    					<?php $i=1;foreach($subscribers as $keyvalue){?>
						<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $keyvalue;?></td>
						</tr>
						<?php $i++;} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>