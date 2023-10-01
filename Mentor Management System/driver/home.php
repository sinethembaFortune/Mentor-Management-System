<?php
$qry2 = $conn->query("SELECT * from mentor where id = '{$_settings->userdata('id')}'");
        if($qry2->num_rows > 0){
            foreach($qry2->fetch_assoc() as $k => $v){
                if(!isset($$k))
                $$k=$v;
            }
        }
?>

<div class="content py-5 mt-5">
    <div class="container">
        <div class="card card-outline card-purple shadow rounded-0">
		<div class="text-center">
        <?php if(isset($availability) && $availability == 1): ?>
		<label for="studentno" class="control-label">You are Available!! Click button if you are Unavailable</label>
        <button class="btn btn-primary btn-flat bg-gradient-warning"  href="javascript:void(0)" type="button" id="unavain">Unavailable</button>
        <?php elseif(isset($availability) && $availability == 0): ?>
		<label for="studentno" class="control-label">You are Unavailable!! Click button if you are Available</label>
        <button class="btn btn-warning btn-flat bg-gradient-success" type="button" id="avain">Available</button>
        <?php endif; ?>
    </div>
		
            <div class="card-header">
                <h4 class="card-title">My Session Booking List</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="15%">
                        <col width="30%">
                        <col width="10%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th class="text-center">#</th>
                            <th class="text-center">Date Booked</th>
                            <th class="text-center">Choosen Date</th>
                            <th class="text-center">Problem</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                            $qry = $conn->query("SELECT * FROM `booking` where mentorId = '{$_settings->userdata('id')}' order by unix_timestamp(creation_date) desc");
                            while($row = $qry->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= date("Y-m-d H:i", strtotime($row['creation_date'])) ?></td>
							<td><?= date("Y-m-d H:i", strtotime($row['time_request'])) ?></td>
                            <td><?= $row['message'] ?></td>
                            <td class="text-center">
                                <?php 
                                    switch($row['status']){
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
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-flat btn-info border btn-sm view_data" data-id="<?= $row['id'] ?>">View Details</button>
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
    $(function(){
        $('table th, table td').addClass('px-2 py-1 align-middle')
        $('table').dataTable();

        $('.view_data').click(function(){
            uni_modal("Booking Details","view_booking.php?id="+$(this).attr('data-id'))
        })
    })
    $(function(){
		
        $('#unavain').click(function(){
            _conf("Are you sure to make yourself Unavailable?", "update_availability_status",["<?= isset($id) ? $id : "" ?>",0])
        })
        $('#avain').click(function(){
            _conf("Note that mentee we see you are available, Are you sure to make yourself Available??", "update_availability_status",["<?= isset($id) ? $id : "" ?>",1])
        }) 
    })
    function update_availability_status($id,$availability){
        start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=update_availability_status",
			method:"POST",
			data:{id: $id,availability:$availability},
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