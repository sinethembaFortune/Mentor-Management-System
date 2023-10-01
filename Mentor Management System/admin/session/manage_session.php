<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `session` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
	<form action="" id="category-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="mentorId" class="control-label"> Mentor ID</label>
			<input name="mentorId" id="mentorId" class="form-control rounded-0 form no-resize" value="<?php echo isset($mentorId) ? $mentorId : ''; ?>" required>
		</div>
		<div class="form-group">
			<label for="subject" class="control-label">Subject</label>
			<textarea name="subject" id="" rows="3" class="form-control rounded-0 form no-resize"><?php echo isset($subject) ? $subject : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="type" class="control-label">Type</label>
			<select name="type" id="type" class="custom-select rounded-0">
			<option value="" <?php echo isset($type) && $type == '' ? 'selected' : '' ?>></option>
				<option value="Online" <?php echo isset($type) && $type == 'Online' ? 'selected' : '' ?>>Online</option>
				<option value="Face-To-Face" <?php echo isset($type) && $type == 'Face-To-Face' ? 'selected' : '' ?>>Face-To-Face</option>
			</select>
		</div>
		<div class="form-group">
			<label for="numMentee" class="control-label">Number of Mentee</label>
			<input name="numMentee" id="numMentee" class="form-control rounded-0 form no-resize" value="<?php echo isset($numMentee) ? $numMentee : ''; ?>" required>
		</div>
		<div class="form-group col-md-6">
				<label for="" class="control-label">Register</label>
				<div class="custom-file">
	              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
	              <label class="custom-file-label" for="customFile">Choose file</label>
	            </div>
			</div>
	</form>
	<div class="card-footer" hidden>
		<button class="btn btn-flat btn-success" form="category-form">Save</button>
		<a class="btn btn-flat btn-danger" href="?page=category">Cancel</a>
	</div>
</div>
<script>
  
	$(document).ready(function(){
		$('#category-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_session",
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
	})
</script>