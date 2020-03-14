<script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {

$('#submit').on('click', function (){
     $('#attendeddesc').DataTable().ajax.reload()
});
 
var table = $('#attendeddesc').DataTable({
                "searching": false,
                "bLengthChange": false,
                "aaSorting": [],
                "ordering": true,
                "bInfo":false,
                columnDefs: [{
                    orderable: false,
                    targets: "no-sort"
                }],
                "pageLength": 10,
                "processing": true,
                "serverSide": true,
                "language": {
                              "emptyTable": "No Discussions Found."
                          },
                          bAutoWidth: false , 
                aoColumns : [
                { sWidth: '30px' /*'44px'*/ },
                { sWidth: '300px' /*'62px'*/ },
                { sWidth: '100px' /*'176px'*/ },
                { sWidth: '300px' },
                { sWidth: '270px' },
                { sWidth: '150px' },
                { sWidth: '80px' /*'85px'*/ },
                { sWidth: '180px' /*'126px'*/ },
                // { sWidth: '90px' /*'99px'*/ },
                { sWidth: '' },
                ] ,
                "ajax":{
                url :"<?php echo base_url('Discussion/myattended_discajax') ?>",  
                type: "POST",   
                "data":function(data) {
                            data.keyword = $('#keyword').val();
                            data.category = $('#category').val();
                            data.from = $('#datepicker-form').val();
                            data.to = $('#datepicker-to').val();
                            data.join = $('#joinas').val();
                            data.status = $('#status').val();
                        },
                error: function(){ 
                  $("#employee_grid_processing").css("display","none");
                }, 
            },
            "fnDrawCallback": function (oSettings) {
                var record_count = this.fnSettings().fnRecordsTotal();
                $('.totalcount').html(record_count+' Entrie(s) Found.');
             } 
    }); 
      
});
</script> 

<div class="main my_attend_form_sec">
    <div class="bradcume-section">
        <div class="container">
            <div class="row">
                <h2>My Attended Discussions</h2>
            </div>
        </div>
    </div>
    <div class="attended-discssion-top-section mycreate-discssion-top-section">
        <div class="container">
            <div class="">
                <div class="col-md-12 attended-discssion-border">
                    <form action="<?php echo base_url('Discussion/mycreated_discajax'); ?>" method="get">
                <div class="col-sm-4 keyword-div">
                    <div class="label-title">keywords</div>
                    <input type="text" id="keyword" autocomplete="off" name="keyword" placeholder="Search by keyword" class="form-controlcls">
                </div>
                <div class="col-sm-2 category-div">
                    <div class="label-title">category</div>
                    <select class="form-control" id="category" name="category">
                        <option value="">Select</option>
                        <?php
                            foreach ($category as $cat) {
                            ?>
                                <option value="<?php echo $cat->category_ID; ?>"><?php echo $cat->name; ?></option>
                            <?php
                            }
                         ?>
                    </select>
                </div>
                <div class="col-sm-3 date-div">
                    <div class="label-title">date</div>
                    <div class="from-to-main-section">
                        <div class="from-date-section">
                            <input type="text" name="fromdate" value="" autocomplete="off" readonly id="datepicker-form" placeholder="From" class="form-controlcls">
                        </div>
                        <div class="form-to-date-section">
                            <input type="text" name="todate" value="" autocomplete="off" readonly id="datepicker-to" placeholder="To" class="form-controlcls">
                        </div>
                    </div>
                </div>
                <!-- <div class="col-sm-1 joined-div">
                   <div class="label-title">joined as</div>
                   <select class="form-control">
                        <option>select</option>
                        <option>kuala lumpur1</option>
                        <option>kuala lumpur2</option>
                 </select>
               </div> -->
                <div class="col-sm-1 status-div">
                    <div class="label-title">Joined As</div>
                    <select class="form-control" id="joinas" name="joinas" >
                        <option value="">Select</option>
                        <option value="2">Presenter</option>
                        <option value="1">Attendee</option>
                    </select>
                </div>
                <div class="col-sm-1 status-div">
                    <div class="label-title">status</div>
                    <select class="form-control" id="status" name="status" >
                        <option value="">Select</option>
                        <option value="1">Open</option>
                        <option value="2">Close</option>
                        <option value="4">Cancelled</option>
                        <option value="3">Completed</option>
                    </select>
                </div>
                <div class="col-sm-1 btn-div">
                    <div class="label-title">&nbsp;</div>
                    <button type="button" id="submit" class="blue-button">search</button>
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    <div class="attended-discssion-entrie-section">
        <div class="container">
<?php if($this->session->flashdata('success')){ ?>
            <div class="alert-success alert alert-dismissible"><?php echo $this->session->flashdata('success'); ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
            <?php } ?>
            <div class="row">
                <div class="col-md-12 entrie-list-title">
                    <h2 class="totalcount"></h2>
                </div>
            </div>
            <div class="">
            <table id="attendeddesc" class="table trader_front_table bid_table_rep">
                <thead>
                    <tr>
                        <th class="no-sort">No.</th>
                        <th class="no-sort">Title</th>
                        <th class="no-sort">Budget</th>
                        <th class="no-sort">Category</th>
                        <th>Date & Time</th>
                        <th>Joined As</th>
                        <th class="no-sort">Bid</th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
            </table>
            </div>
        </div>
    </div>
</div>
     