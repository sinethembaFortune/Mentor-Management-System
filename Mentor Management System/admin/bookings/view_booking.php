<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `booking` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
        $qry2 = $conn->query("SELECT m.*,b.*,concat(s.lastname,', ', s.firstname,' ',s.middlename) as mentor from mentee m, booking b ,mentor s where m.id = b.menteeId and s.id = b.mentorId");
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
					<dt class="">Requested Mentor</dt>
                    <dd class="pl-4"><?= isset($mentor) ? $mentor : "Not Available" ?></dd>
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
    <div class="clear-fix my-3"></div>
    <div class="text-right">
        <button class="btn btn-danger btn-flat bg-gradient-red" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>
