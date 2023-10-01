<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-purple rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">List of Sessions</h3>
		<div class="card-tools">
			<button type="button" id="create_new" class="btn btn-flat btn-success btn-sm"><span class="fas fa-plus"></span>  Add New Session</button>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-bordered table-stripped table-hover">
				<colgroup>
					<col width="5%">
					<!-- <col width="20%"> -->
					<col width="8%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
				<tr class="bg-gradient-dark text-light">
						<th>#</th>
						<!-- <th>Date Created</th> -->
						<th>Mentor ID</th>
						<th>Subject</th>
						<th>Type</th>
						<th>Number Of Mentee</th>
						<th>Register</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `session` ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<!-- <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td> -->
							<td><?php echo $row['mentorId'] ?></td>
							<td><p class="m-0 truncate-1"><?php echo $row['subject'] ?></p></td>
							<td><p class="m-0 truncate-1"><?php echo $row['type'] ?></p></td>
							<td><p class="m-0 truncate-1"><?php echo $row['numMentee'] ?></p></td>
							<td class="align-middle"><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row['register']).'" width="150" height="130"/>';?></td>
							<td align="center">
								<button type="button" class="btn btn-flat btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
									Action
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
								<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#create_new').click(function(){
			uni_modal("Add New Session","session/manage_session.php");
		})
		$('.edit_data').click(function(){
			uni_modal("Edit Session","session/manage_session.php?id="+$(this).attr('data-id'));
		})
		$('.view_data').click(function(){
			uni_modal("View Session","session/view_session.php?id="+$(this).attr('data-id'));
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Session permanently?","delete_session",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_session($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_session",
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
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>