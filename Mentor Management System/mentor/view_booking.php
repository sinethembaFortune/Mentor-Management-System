<?php
require_once('./../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `booking` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
        $qry2 = $conn->query("SELECT m.*,b.* from mentee m, booking b where m.id = b.menteeId");
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
 <div class="row">
        <div class="col-md-6">
            <fieldset class="bor">
                <legend class="h5 text-muted"> Mentee Details</legend>
                <dl>
                    <dt class="">Mentee Name</dt>
                    <dd class="pl-4"><?= isset($firstname) ? $firstname : "" ?></dd>
                    <dt class="">Mentee Surname</dt>
                    <dd class="pl-4"><?= isset($lastname) ? $lastname : "" ?></dd>
                    <dt class="">Email</dt>
                    <dd class="pl-4"><?= isset($email) ? $email : "" ?></dd>
                    <dt class="">Phone No.</dt>
                    <dd class="pl-4"><?= isset($contact) ? $contact : "" ?></dd>
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
                    <dt class="">Creation Date</dt>
                    <dd class="pl-4"><?= isset($creation_date) ? $creation_date : "" ?></dd>
                    <dt class="">Time Slot</dt>
                    <dd class="pl-4"><?= isset($time_request) ? $time_request : "not yet" ?></dd>
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
    
    <!-- <div class="clear-fix my-3"></div> -->
    <div class="text-right">
        <?php if(isset($status) && $status == 0): ?>
        <button class="btn btn-primary btn-flat bg-gradient-primary"  href="javascript:void(0)" type="button" id="confirm_booking">Confirm Booking</button>
        <?php elseif(isset($status) && $status == 1): ?>
        <button class="btn btn-warning btn-flat bg-gradient-warning" type="button" id="pickup_booking">Session Start</button>
        <?php elseif(isset($status) && $status == 2): ?>
        <button class="btn btn-success btn-flat bg-gradient-success" type="button" id="dropoff_booking">Session End</button>
        <?php endif; ?>
        <button class="btn btn-dark btn-flat bg-gradient-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>
<script>
    $(function(){
		
        $('#confirm_booking').click(function(){
            _conf("Are you sure to confirm this booking [Session ID: <b><?= isset($id) ? $id : "" ?></b>]?", "update_booking_status",["<?= isset($id) ? $id : "" ?>",1])
        })
        $('#pickup_booking').click(function(){
            _conf("Mark [Session ID: <b><?= isset($id) ? $id : "" ?></b>] Start session?", "update_booking_status",["<?= isset($id) ? $id : "" ?>",2])
        }) 
        $('#dropoff_booking').click(function(){
            _conf("Mark [Session ID: <b><?= isset($id) ? $id : "" ?></b>] End Session?", "update_booking_status",["<?= isset($id) ? $id : "" ?>",3])
        })
    })
    function update_booking_status($id,$status){
        start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=update_booking_status",
			method:"POST",
			data:{id: $id,status:$status},
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