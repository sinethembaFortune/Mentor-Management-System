<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT m.firstname as name, m.lastname as surname,m.studentno studentno ,m.email as email,m.mobile as mobile, m.gender as gender, m.offer as offer,s.subject as subject,s.type as type,s.creation_date as date ,s.numMentee as num , s.register as register from mentor m, session s where mentorId = m.id and s.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none;
    }
	
    .session-img{
        width:15vw;
        height:20vh;
        object-fit:scale-down;
        object-position:center center;
    }

</style>
<div class="content py-3">
    <div class="card card-outline rounded-0 card-purple shadow">
        <div class="card-header">
            <h4 class="card-title">Session Details</h4>
            <div class="card-tools">
			 <div class="text-right">
        <button class="btn btn-dark bg-gradient-dark btn-flat" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">

                        <img src="<?= validate_image(isset($register) ? $register : "") ?>" alt="cab Image <?= isset($register) ? $register : "" ?>" class="img-thumbnail session-img">
                    </div>
                </div>
				<fieldset>
                    <legend class="h4 text-muted"><b>Session's Details</b></legend>
                <div class="row">
                    <div class="col-md-6">
                        <small class="mx-2 text-muted">Type</small>
                        <div class="pl-4"><?= isset($type) ? $type : '' ?></div>
                    </div>
					<div class="col-md-6">
                        <small class="mx-2 text-muted">Date</small>
                        <div class="pl-4"><?= isset($date) ? $date : '' ?></div>
                    </div>
                    <div class="col-md-6">
                        <small class="mx-2 text-muted">Offer</small>
                        <div class="pl-4"><?= isset($offer) ? $offer : '' ?></div>
						
                    </div>
					<div class="col-md-6">
                        <small class="mx-2 text-muted">Number Of Mentees</small>
                        <div class="pl-4"><?= isset($num) ? $num : '' ?></div>
                    </div>
                </div>
				 </fieldset>
                <fieldset>
                    <legend class="h4 text-muted"><b>Mentor's Details</b></legend>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="mx-2 text-muted">First Name</small>
                            <div class="pl-4"><?= isset($name) ? $name : '' ?></div>
                        </div>
						 
                        <div class="col-md-6">
                            <small class="mx-2 text-muted">Surname</small>
                            <div class="pl-4"><?= isset($surname) ? $surname : '' ?></div>
                        </div>
						<div class="col-md-6">
                            <small class="mx-2 text-muted">Student Number</small>
                            <div class="pl-4"><?= isset($studentno) ? $studentno : '' ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="mx-2 text-muted">Gender</small>
                            <div class="pl-4"><?= isset($gender) ? $gender : '' ?></div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend class="h4 text-muted"><b>Contact Details</b></legend>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="mx-2 text-muted">Phone Number</small>
                            <div class="pl-4"><?= isset($mobile) ? $mobile : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <small class="mx-2 text-muted">Student Email</small>
                            <div class="pl-4"><?= isset($email) ? $email : '' ?></div>
                        </div>
                    </div>
                    
                </fieldset>
                
            </div>
        </div>
		<div class="clear-fix mb-3"></div>
    <div class="text-right">
        <button class="btn btn-dark bg-gradient-dark btn-flat" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
    </div>
</div>