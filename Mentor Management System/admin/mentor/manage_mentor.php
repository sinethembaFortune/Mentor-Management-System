<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `mentor` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=stripslashes($v);
        }
    }
}
?>
<style>
	#cimg{
		width: 15vw;
		height: 20vh;
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<div class="card card-outline card-purple rounded-0">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Mentor</h3>
	</div>
	<div class="card-body">
		<form action="" id="cab-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
           
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
				<label for="gender" class="control-label">Gender </label>
                <input name="gender" id="gender" type="text" class="form-control rounded-0" value="<?php echo isset($gender) ? $gender : ''; ?>" required>
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
			<label for="offer" class="control-label">OFFER </label>
			<div class="form-group">
				<label for="offer" class="control-label">programming </label>
				<input type="checkbox" name="offer[]" value="programming" id="offer_programming" />
				<label for="offer" class="control-label">math </label>
				<input type="checkbox" name="offer[]" value="math" id="offer_math" />
				<label for="offer" class="control-label">database </label>
				<input type="checkbox" name="offer[]" value="database" id="offer_database" />
				
				<label for="offer" class="control-label">study skills </label>
				<input type="checkbox" name="offer[]" value="study skills" id="offer_study_skills" />
				
				<label for="offer" class="control-label">time management </label>
				<input type="checkbox" name="offer[]" value="time management" id="offer_time_management" />
				
				<label for="offer" class="control-label">time management </label>
				<input type="checkbox" name="offer[]" value="time management" id="offer_time_management" />
                
			</div>
			<div class="form-group">
				<label for="password" class="control-label">mentor's Account Password</label>
				<div class="input-group">
                	<input name="password" id="password" type="password" class="form-control rounded-0" <?php echo !isset($password) ? 'required' : ''; ?>>
					<div class="input-group-append">
						<button class="btn btn-outline-default pass_view" type="button"><i class="fa fa-eye-slash"></i></button>
					</div>
				</div>
				<small class="text-muted"><i>Leave this field blank if you don't wish to update the mentor's account password.</i></small>
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
            <div class="form-group">
				<label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select selevt">
                <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
			</div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-success" form="cab-form">Save</button>
		<a class="btn btn-flat btn-danger" href="?page=cabs">Cancel</a>
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
	$(document).ready(function(){
		$('.select2').select2({
			width:'100%',
			placeholder:"Please Select Here"
		})
		$('.pass_view').click(function(){
			var group = $(this).closest('.input-group');
			var type = group.find('input').attr('type')
			if(type == 'password'){
				group.find('input').attr('type','text').focus()
				$(this).html('<i class="fa fa-eye"></i>')
			}else{
				group.find('input').attr('type','password').focus()
				$(this).html('<i class="fa fa-eye-slash"></i>')
			}
		})
		$('#cab-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
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
						location.href = "./?page=mentor/view_mentor&id="+resp.id;
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
	})
</script>