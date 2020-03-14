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
            url :"<?php echo base_url('admin/User_Master/userwithdrow_ajax') ?>", // json datasource
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
            	<h6 class="element-header">Manage Withdrawal Requests</h6>
                <div class="table-responsive">
					<table id="usertable" width="100%" class="table admin_table manage_user_table">
					    <thead>
					        <tr>
					            <th class="t_no">No.</th>
					            <th>User Name</th>
					            <th>Requested Amount</th>
					           
					            <th>Payment Method</th>
					            <th>note</th>
					              <th>Date</th>
					             <th class="text-center">Status</th>
					        </tr>
					    </thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).on("click",".withstatus",function(e){

    var id=e.target.id;
   
    $.ajax({
        type:'POST',
        url:"<?php echo base_url().'admin/User_Master/withdrowrequeststatus' ?>",
        data:{ with_ID:id},
        success:function(html){  
           window.location.href="<?php echo base_url();?>admin/view-withdrow";
        }
    });       
});

</script>