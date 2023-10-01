<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-purple">
	<div class="card-header">
		<h3 class="card-title">List of Mentors</h3>
		<div class="card-tools">
			<a href="?page=mentor/manage_mentor" class="btn btn-flat btn-success btn-sm"><span class="fas fa-plus"></span>  Add New Mentor</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped table-hover">
				<colgroup>
					<col width="5%">
					<!-- <col width="15%"> -->
					<col width="15%">
					<col width="10%">
					<col width="15%">
					<col width="20%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
				<tr class="bg-gradient-dark text-light">
						<th>#</th>
						<!-- <th>Date Created</th> -->
						<th>Student Number</th>
						<th>Full Names</th>
						<th>Stream</th>
						<th>Contact Details</th>
						<th>Status</th>
						<th>Availability</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * FROM `mentor`");
						while($row = $qry->fetch_assoc()):
							foreach($row as $k=> $v){
								$row[$k] = trim(stripslashes($v));
							}
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<!-- <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td> -->
							<td><?php echo ucwords($row['studentno']) ?></td>
							<td><?php echo ucwords($row['firstname']) ?></td>
							<td><?php echo ucwords($row['stream'])?></td>
							<td>
								<div>
									<p class="m-0 truncate-1"><b>Phone No:</b> <?= $row['mobile'] ?></p>
									<p class="m-0 truncate-1"><small><b>Email:</b> <?= $row['email'] ?></small></p>
								</div>
							</td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                <?php endif; ?>
                            </td>
							<td class="text-center">
                                <?php if($row['availability'] == 1): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Available</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Unavailable</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="?page=mentor/view_mentor&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item" href="?page=mentor/manage_mentor&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
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
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Mentor permanently?","delete_mentor",[$(this).attr('data-id')])
		})
        $('.table th, .table td').addClass("align-middle px-2 py-1")
		$('.table').dataTable();
		$('.table').dataTable();
	})
	function delete_mentor($id){
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
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>