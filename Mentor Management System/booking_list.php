<div class="content py-5 mt-5">
    <div class="container">
        <div class="card card-outline card-purple shadow rounded-0">
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
                            $qry = $conn->query("SELECT * FROM `booking` where menteeId = '{$_settings->userdata('id')}' order by unix_timestamp(creation_date) desc");
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
</script>