<?php
require_once('./config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `booking` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="booking-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="mentorId" id="mentorId" value="<?= isset($_GET['cid']) ? $_GET['cid'] : (isset($mentorId) ? $mentorId : "") ?>">
        <div class="form-group">
            <label for="time_request" class="control-label">Time and Date</label>
            <input type= "datetime-local" name="time_request" id="time_request" rows="2" class="form-control form-control-sm rounded-0" required></input>
        </div>
		<div class="form-group">
            <label for="message" class="control-label">Request Message</label>
            <textarea name="message" id="message" rows="4" class="form-control form-control-sm rounded-0" required></textarea>
        </div>

        
    </form>
</div>

<script>
	$(document).ready(function(){
		$('#booking-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_booking",
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
						location.href = './?p=booking_list';
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