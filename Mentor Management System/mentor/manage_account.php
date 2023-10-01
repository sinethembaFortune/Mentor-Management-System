<?php 
if($_settings->userdata('id') > 0 && $_settings->userdata('login_type') == 3){
    $qry = $conn->query("SELECT * FROM `mentor` where id = '{$_settings->userdata('id')}'");
    if($qry->num_rows >0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
    }else{
        echo "<script> alert('You are not allowed to access this page. Unknown User ID.'); location.replace('./') </script>";
    }
}else{
    echo "<script> alert('You are not allowed to access this page.'); location.replace('./') </script>";
}
?>
<style>
    #cimg{
        width:15vw;
        height:20vh;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="content py-5 mt-5">
    <div class="container">
        <div class="card card-outline card-purple shadow rounded-0">
            <div class="card-header">
                <h4 class="card-title"><b>Manage Account Details</b></h4>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form id="register-frm" action="" method="post">
			
            <input type="hidden" name="id" value="<?= isset($id) ? $id : "" ?>">
			<div class="form-group">
				<label for="studentno" class="control-label">Student Number</label>
                <input name="studentno" id="studentno" type="text" class="form-control rounded-0" value="<?php echo isset($studentno) ? $studentno : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="firstname" class="control-label">First Name</label>
                <input name="firstname" id="firstname" type="text" class="form-control rounded-0" value="<?php echo isset($firstname) ? $firstname : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="middlename" class="control-label">Middle Name</label>
                <input name="middlename" id="middlename" type="text" class="form-control rounded-0" value="<?php echo isset($middlename) ? $middlename : ''; ?>" required>
			</div>
            <div class="form-group">
				<label for="lastname" class="control-label">Last Name</label>
                <input name="lastname" id="lastname" type="text" class="form-control rounded-0" value="<?php echo isset($lastname) ? $lastname : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="gender" class="control-label">Gender</label>
                <select name="gender" id="gender" class="custom-select selevt">
                <option value="Male" <?php echo isset($gender) && $gender == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?php echo isset($gender) && $gender == 'Female' ? 'selected' : '' ?>>Female</option>
                </select>
			</div>
			<div class="form-group">
				<label for="mobile" class="control-label">Phone Number </label>
                <input name="mobile" id="mobile" type="text" class="form-control rounded-0" value="<?php echo isset($mobile) ? $mobile : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="email" class="control-label">Email </label>
                <input name="email" id="email" type="text" class="form-control rounded-0" value="<?php echo isset($email) ? $email : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="stream" class="control-label">Stream </label>
                <input name="stream" id="stream" type="text" class="form-control rounded-0" value="<?php echo isset($stream) ? $stream : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="offer" class="control-label">Offer</label>
                <textarea name="offer" id="offer" type="text" class="form-control rounded-0" required><?php echo isset($offer) ? $offer : ''; ?></textarea>
			</div>
			<div class="row">
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                <input type="password" name="password" id="password" placeholder="" class="form-control form-control-sm form-control-border">
                                <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                                    <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                                </div>
                                </div>
                                <small class="ml-3">New Password</small>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                <input type="password" id="cpassword" placeholder="" class="form-control form-control-sm form-control-border">
                                <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                                    <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                                </div>
                                </div>
                                <small class="ml-3">Confirm New Password</small>
                            </div>
                            <div class="col-12 mb-3"><small class="text-muted"><em>Fill the password fields above only if you want to update your password.</em></small></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                <input type="password" name="oldpassword" id="oldpassword" placeholder="" class="form-control form-control-sm form-control-border" required>
                                <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                                    <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                                </div>
                                </div>
                                <small class="ml-3">Current Password</small>
                            </div>
                        </div>
			<div class="form-group col-md-6">
				<label for="" class="control-label">Mentor's Image</label>
				<div class="custom-file">
	              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
	              <label class="custom-file-label" for="customFile">Choose file</label>
	            </div>
			</div>
			<div class="form-group col-md-6 d-flex justify-content-center">
				<img src="<?php echo validate_image(isset($image_path) ? $image_path : "") ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
			</div>
			<div class="row align-items-center">
                            <div class="col-8">
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                            <button type="submit" class="btn btn-success btn-sm btn-flat btn-block">Update Details</button>
                            </div>
                            <!-- /.col -->
                        </div>
            
		</form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
     window.displayImg = function(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
            $('#cimg').attr('src', "<?php echo validate_image(isset($image_path) ? $image_path : "") ?>");
            _this.siblings('.custom-file-label').html("Choose file")
        }
	}
    $(function(){
        $('.pass_type').click(function(){
            var type = $(this).attr('data-type')
            if(type == 'password'){
                $(this).attr('data-type','text')
                $(this).closest('.input-group').find('input').attr('type',"text")
                $(this).removeClass("fa-eye-slash")
                $(this).addClass("fa-eye")
            }else{
                $(this).attr('data-type','password')
                $(this).closest('.input-group').find('input').attr('type',"password")
                $(this).removeClass("fa-eye")
                $(this).addClass("fa-eye-slash")
            }
        })
        $('#register-frm').submit(function(e){
            e.preventDefault()
            var _this = $(this)
                    $('.err-msg').remove();
            var el = $('<div>')
                    el.hide()
            if($('#password').val() != $('#cpassword').val()){
                el.addClass('alert alert-danger err-msg').text('Password does not match.');
                _this.prepend(el)
                el.show('slow')
                return false;
            }
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_mentor",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
                    console.log(err)
                    alert_toast("An error occured",'error');
                    end_loader();
                },
                success:function(resp){
                    if(typeof resp =='object' && resp.status == 'success'){
                        location.reload();
                    }else if(resp.status == 'failed' && !!resp.msg){   
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                    }else{
                        alert_toast("An error occured",'error');
                        end_loader();
                        console.log(resp)
                    }
                    end_loader();
                    $('html, body').scrollTop(0)
                }
            })
        })
    })
</script>