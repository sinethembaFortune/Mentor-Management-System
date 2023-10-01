<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
	
    $qry = $conn->query("SELECT * from mentor where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=stripslashes($v);
        }
    }
}
?>
<style>
    .cab-img{
        width:15vw;
        height:20vh;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="content py-3">
    <div class="card card-outline rounded-0 card-purple shadow">
        <div class="card-header">
            <h4 class="card-title">Mentor Details</h4>
            <div class="card-tools">
                <a class="btn btn-primary btn-sm btn-flat" href="./?page=mentor/manage_mentor&id=<?= isset($id) ? $id : "" ?>"><i class="fa fa-edit"></i> Edit</a>
                <a class="btn btn-danger btn-sm btn-flat" href="javascript:void(0)>" id="delete_data"><i class="fa fa-trash"></i> Delete</a>
                <a class="btn btn-default border btn-sm btn-flat" href="./?page=mentor"><i class="fa fa-angle-left"></i> Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img src="<?= validate_image(isset($image_path) ? $image_path : "") ?>" alt="cab Image <?= isset($name) ? $name : "" ?>" class="img-thumbnail cab-img">
                    </div>
					
                </div>
				<div class="text-center">
						<?php if(isset($availability)): ?>
							<?php if($availability == 1): ?>
								<span class="badge badge-success px-3 rounded-pill">Available</span>
							<?php else: ?>
								<span class="badge badge-danger px-3 rounded-pill">Unavailable</span>
							<?php endif; ?>
						<?php endif; ?>
                    </div>
                <div class="row">
                    <div class="col-md-6">
                        <small class="mx-2 text-muted">Student Number</small>
                        <div class="pl-4"><?= isset($studentno) ? $studentno : '' ?></div>
                    </div>
                    <div class="col-md-6">
                        <small class="mx-2 text-muted">Stream</small>
                        <div class="pl-4"><?= isset($stream) ? $stream : '' ?></div>
                    </div>
                </div>
                <fieldset>
                    <legend class="h4 text-muted"><b>Mentor's Details</b></legend>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="mx-2 text-muted">First Name</small>
                            <div class="pl-4"><?= isset($firstname) ? $firstname : '' ?></div>
                        </div>
						 <div class="col-md-6">
                            <small class="mx-2 text-muted">middle Name</small>
                            <div class="pl-4"><?= isset($middlename) ? $middlename : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <small class="mx-2 text-muted">Last Name</small>
                            <div class="pl-4"><?= isset($lastname) ? $lastname : '' ?></div>
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
                <div class="row">
                    <div class="col-md-12">
                        <small class="mx-2 text-muted">Status</small>
                        <div class="pl-4">
                            <?php if(isset($status)): ?>
                                <?php if($status == 1): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
		$('#delete_data').click(function(){
			_conf("Are you sure to delete this mentor permanently?","delete_mentor",[])
		})
    })
    function delete_mentor($id = '<?= isset($id) ? $id : "" ?>'){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_mentor",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.href= './?page=mentor';
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>