<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a PDF file was selected
    if ($_FILES["pdf"]["name"]) {
        // Define the directory to store uploaded PDFs
        $uploadDirectory = "uploads/";

        $pdfFileName = $_FILES["pdf"]["name"];
        $pdfTmpName = $_FILES["pdf"]["tmp_name"];

        // Check if the file is a PDF
        $fileType = strtolower(pathinfo($pdfFileName, PATHINFO_EXTENSION));
        if ($fileType == "pdf") {
            // Generate a unique filename
            $uniqueFileName = uniqid() . ".pdf";
            $destination = $uploadDirectory . $uniqueFileName;

            // Move the file to the destination directory
            if (move_uploaded_file($pdfTmpName, $destination)) {
                // File upload successful
                echo "PDF paper uploaded successfully!";
                
                // You can store information about the uploaded paper in a database here.
                // For example, the filename, user information, upload date, etc.
            } else {
                echo "Error uploading PDF paper.";
            }
        } else {
            echo "Please upload a PDF file.";
        }
    } else {
        echo "No PDF file selected.";
    }
}
?>
<div class="content py-5 mt-5">
<div class="container">
	<form action="" id="category-form" enctype="multipart/form-data">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		
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
				<label for="pdf">Select PDF Register:</label>
                        <input type="file" name="pdf" id="pdf" accept=".pdf" required><br><br>
                <input type="submit" value="Submit">
		</div>
	</form>
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