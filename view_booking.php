<?php
require_once('./config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `booking` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
        $qry2 = $conn->query("SELECT m.*,b.* from mentor m, booking b where m.id = b.mentorId");
        if($qry2->num_rows > 0){
            foreach($qry2->fetch_assoc() as $k => $v){
                if(!isset($$k))
                $$k=$v;
            }
        }
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none
    }
</style>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-6">
            <fieldset class="bor">
                <legend class="h5 text-muted"> Mentor Details</legend>
                <dl>
                    <dt class="">Mentor Name</dt>
                    <dd class="pl-4"><?= isset($firstname) ? $firstname : "" ?></dd>
                    <dt class="">Mentor Surname</dt>
                    <dd class="pl-4"><?= isset($lastname) ? $lastname : "" ?></dd>
                    <dt class="">Email</dt>
                    <dd class="pl-4"><?= isset($email) ? $email : "" ?></dd>
                    <dt class="">Phone No.</dt>
                    <dd class="pl-4"><?= isset($mobile) ? $mobile : "" ?></dd>
                    <dt class="">Gender</dt>
                    <dd class="pl-4"><?= isset($gender) ? $gender : "" ?></dd>
                    <dt class="">Stream</dt>
                    <dd class="pl-4"><?= isset($stream) ? $stream : "" ?></dd>
                </dl>
            </fieldset>
        
            
        </div>

        <div class="col-md-6">
            <fieldset class="bor">
                <legend class="h5 text-muted"> Booking Details</legend>
                <dl>
                    <dt class="">Ref. Code</dt>
                    <dd class="pl-4"><?= isset($c) ? $ref_code : "" ?></dd>
                    <dt class="">Creation Date</dt>
                    <dd class="pl-4"><?= isset($creation_date) ? $creation_date : "" ?></dd>
                    <dt class="">Request Time</dt>
                    <dd class="pl-4"><?= isset($time_request) ? $time_request : "" ?></dd>
                    <dt class="">Status</dt>
                    <dd class="pl-4">
                        <?php 
                            switch($status){
                                case 0:
                                    echo "<span class='badge badge-secondary bg-gradient-secondary px-3 rounded-pill'>Pending</span>";
                                    break;
                                case 1:
                                    echo "<span class='badge badge-primary bg-gradient-primary px-3 rounded-pill'>Request Accepted</span>";
                                    break;
                                case 2:
                                    echo "<span class='badge badge-warning bg-gradient-warning px-3 rounded-pill'>Session Started</span>";
                                    break;
                                case 3:
                                    echo "<span class='badge badge-success bg-gradient-success px-3 rounded-pill'>Session Ended</span>";
                                    break;
                                case 4:
                                    echo "<span class='badge badge-danger bg-gradient-danger px-3 rounded-pill'>Cancelled</span>";
                                    break;
                            }
                        ?>
                    </dd>
                </dl>
            </fieldset>
        </div>
    </div>
    <!-- <div class="clear-fix my-2"></div> -->
    
    
    <div class="text-right">
        
        <?php if(isset($status) && $status == 0): ?>
        <button class="btn btn-danger btn-flat bg-gradient-danger" type="button" id="cancel_booking">Cancel Bookings</button>
        <?php endif; ?>
        <button class="btn btn-dark btn-flat bg-gradient-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>
<script>
    $(function(){
        $('#cancel_booking').click(function(){
            _conf("Are you sure to cancel your booking with  [Name : <b><?= isset($firstname) ? $firstname : "" ?></b>]?", "cancel_booking",["<?= isset($id) ? $id : "" ?>"])
        })
    })
    function cancel_booking($id){
        start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=update_booking_status",
			method:"POST",
			data:{id: $id,status:4},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
    }
</script>