<?php
include './header.php';
require_once './src/requester.php';
require_once './src/ticket.php';
require_once './src/ticket-event.php';
require './src/helper-functions.php';

$err = '';
$msg = '';
$project = ''; // Initialize the variable to avoid the undefined warning
$site_name = '';

// Fetching teams
$sql = "SELECT id, name FROM team ORDER BY name ASC";
$res = $db->query($sql);
$teams = $res->fetch_all(MYSQLI_ASSOC);

// Fetching site names from the database
$site_sql = "SELECT id, site_name FROM sites ORDER BY site_name ASC";
$site_res = $db->query($site_sql);
$sites = $site_res->fetch_all(MYSQLI_ASSOC);

$selected_team = $_POST['team'] ?? '';
// Initialize variables
$work_type = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $work_type = $_POST['work_type'] ?? [];
    
    $site_name = trim($_POST['site_name'] ?? '');
    $cluster = trim($_POST['cluster'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $project = trim($_POST['project'] ?? '');
    $vendor = trim($_POST['vendor'] ?? '');
    $remarks = "Ticket initially created."; // Default remarks value
    $team = $_POST['team'] ?? '';
    $schedule_date = $_POST['schedule_date_from'] ?? '';
    $schedule_date_from = $_POST['schedule_date_from'] ?? '';
    $schedule_date_to = $_POST['schedule_date_to'] ?? '';

    $status = $_POST['status'] ?? '';
    $priority = $_POST['priority'] ?? '';

    if (empty($site_name) || empty($cluster) || empty($state) || empty($project) || empty($vendor) || empty($team) || empty($schedule_date_from) || empty($schedule_date_to) || empty($status) || empty($priority)) {
        $err = "Please fill in all required fields.";
    } elseif (empty($work_type)) {
        $err = "Please select at least one Activity.";
    } elseif (strtotime($schedule_date_from) > strtotime($schedule_date_to)) {
        $err = "The 'From' date cannot be later than the 'To' date.";
    } else {
        try {
            $ticket = new Ticket([
                'site_name' => $site_name,
                'cluster' => $cluster,
                'state' => $state,
                'project' => $project,
                'vendor' => $vendor,
                'remarks' => $remarks,
                'team' => $team,
                'schedule_date' => $schedule_date_from,
                'schedule_date_from' => $schedule_date_from,
                'schedule_date_to' => $schedule_date_to,
                'status' => $status,
                'priority' => $priority,
                'work_type' => implode(',', $work_type)
            ]);
            
            if ($ticket->save()) {
                $msg = "Ticket generated successfully.";
            }
        } catch (Exception $e) {
            $err = "Failed to generate ticket: " . $e->getMessage();
        }
    }
}


?>
<style>
    .multiselect-container {
        max-height: 300px !important; /* adjust height as needed */
        overflow-y: auto;
    }
</style>
<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="calendar.php">calendar</a>
            </li>
            <li class="breadcrumb-item active">New ticket</li>
        </ol>

        <div class="card mb-3">
            <div class="card-header">
                <h3>Create a new ticket</h3>
            </div>
            <div class="card-body">
                <?php if(strlen($err) > 1) :?>
                <div class="alert alert-danger text-center my-3" role="alert"> <strong>Failed! </strong> <?php echo $err;?></div>
                <?php endif?>

                <?php if(strlen($msg) > 1) :?>
                <div class="alert alert-success text-center my-3" role="alert"> <strong>Success! </strong> <?php echo $msg;?></div>
                <?php endif?>

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">

                    <div class="form-group row col-lg-8 offset-lg-2">
                        <label for="site_name" class="col-lg-2 col-form-label">Site Name</label>
                        <div class="col-sm-8">
                            <select id="site_name" name="site_name" class="form-control">
                                <option value="">-- Select Site Name --</option>
                                <?php foreach ($sites as $site): ?>
                                    <option value="<?php echo $site['site_name']; ?>" <?php echo ($site_name == $site['site_name']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($site['site_name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row col-lg-8 offset-lg-2">
                        <label for="cluster" class="col-lg-2 col-form-label">Cluster</label>
                        <div class="col-sm-8">
                            <input type="text" id="cluster" name="cluster" class="form-control" placeholder="Enter Cluster"
                                value="<?php echo isset($cluster) ? $cluster : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group row col-lg-8 offset-lg-2">
                        <label for="state" class="col-lg-2 col-form-label">State</label>
                        <div class="col-sm-8">
                            <input type="text" name="state" class="form-control" placeholder="Enter State" value="<?php echo isset($state) ? $state : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group row col-lg-8 offset-lg-2">
                        <label for="project" class="col-lg-2 col-form-label">Project</label>
                        <div class="col-sm-8">
                            <select name="project" class="form-control">
                                <option value="">-- Select Project --</option>
                                <option value="NBN" <?php echo ($project == 'NBN') ? 'selected' : ''; ?>>NBN</option>
                                <option value="TELSTRA" <?php echo ($project == 'TELSTRA') ? 'selected' : ''; ?>>TELSTRA</option>
                                <option value="EJV" <?php echo ($project == 'EJV') ? 'selected' : ''; ?>>EJV</option>
                                <option value="Optus" <?php echo ($project == 'Optus') ? 'selected' : ''; ?>>Optus</option>
                                <option value="Starlink" <?php echo ($project == 'Starlink') ? 'selected' : ''; ?>>Starlink</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row col-lg-8 offset-lg-2">
                        <label for="vendor" class="col-lg-2 col-form-label">Vendor</label>
                        <div class="col-sm-8">
                            <input type="text" name="vendor" class="form-control" placeholder="Enter Vendor Name" value="<?php echo isset($vendor) ? $vendor : ''; ?>">
                        </div>
                    </div>

                    <!-- Fix for Work Type -->
                    
                        <div class="form-group row col-lg-8 offset-lg-2">
                            <label for="work_type" class="col-lg-2 col-form-label">Activity</label>
                            <div class="col-sm-8">
                            <select id="work_type" name="work_type[]" class="form-control" multiple>
                                <option value="site survey">site survey</option>
                                <option value="scope checking">scope checking</option>
                                <option value="plant hire">plant hire</option>
                                <option value="team submission">team submission</option>
                                <option value="material checking">material checking</option>
                                <option value="RF prep works">RF prep works</option>
                                <option value="RF Build">RF Build</option>
                                <option value="RF migration">RF migration</option>
                                <option value="TX prep works">TX prep works</option>
                                <option value="TX link upgrade">TX link upgrade</option>
                                <option value="Comm CL">Comm CL</option>
                                <option value="RBS swap">RBS swap</option>
                                <option value="BBS install">BBS install</option>
                                <option value="AC upgrade">AC upgrade</option>
                                <option value="SWR installation">SWR installation</option>
                                <option value="HOPS">HOPS</option>
                                <option value="LSP">LSP</option>
                                <option value="Alarm Testing">Alarm Testing</option>
                                <option value="Rubbish Disposal">Rubbish Disposal</option>
                                <option value="Decom material return">Decom material return</option>
                                <option value="Call Testing">Call Testing</option>
                            </select>

                            </div>
                        </div>
                    



                    <!--<div class="form-group row col-lg-8 offset-lg-2">
                        <label for="remarks" class="col-lg-2 col-form-label">Remarks</label>
                        <div class="col-sm-8">
                            <textarea name="remarks" class="form-control" placeholder="Enter Remarks"><?php echo isset($remarks) ? $remarks : ''; ?></textarea>
                        </div>
                    </div>-->

                    <div class="form-group row col-lg-8 offset-lg-2">
                        <label for="team" class="col-lg-2 col-form-label">Team</label>
                        <div class="col-sm-8">
                            <select name="team" class="form-control">
                                <option value="">-- Select Team --</option>

                                
                                <?php foreach($teams as $team): ?>
                                <option value="<?php echo $team['id']; ?>" <?php echo ($team['id'] == $selected_team) ? 'selected' : ''; ?>>
                                    <?php echo $team['name']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row col-lg-8 offset-lg-2">
                        <label for="schedule_date_from" class="col-lg-2 col-form-label">Schedule From</label>
                        <div class="col-sm-4">
                            <input type="date" name="schedule_date_from" class="form-control" value="<?php echo isset($schedule_date_from) ? $schedule_date_from : ''; ?>">
                        </div>
                        <label for="schedule_date_to" class="col-lg-2 col-form-label">Schedule To</label>
                        <div class="col-sm-4">
                            <input type="date" name="schedule_date_to" class="form-control" value="<?php echo isset($schedule_date_to) ? $schedule_date_to : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group row col-lg-8 offset-lg-2">
                        <label for="status" class="col-lg-2 col-form-label">Status</label>
                        <div class="col-sm-8">
                            <select name="status" class="form-control">
                                <option value="New">New</option>
                                <option value="On-going">On-going</option>
                                <option value="On Hold">On Hold</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row col-lg-8 offset-lg-2">
                        <label for="priority" class="col-lg-2 col-form-label">Priority</label>
                        <div class="col-sm-8">
                            <select name="priority" class="form-control">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-lg btn-primary">Create Ticket</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

</div>

</form>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    

</div>
<!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="./index.php">Logout</a>
            </div>
        </div>
    </div>
</div>







<!-- jQuery (MUST be loaded first) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (Required for Bootstrap) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Multiselect (Load AFTER Bootstrap) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/css/bootstrap-multiselect.css">



    


<script>
    $(document).ready(function () {
    $('#work_type').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '100%',
        nonSelectedText: 'Select Activity',
        allSelectedText: 'All Selected',
        selectAllText: 'Select All'
    });

    $('#work_type').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true,
    buttonWidth: '100%',
    nonSelectedText: 'Select Activity',
    allSelectedText: 'All Selected',
    selectAllText: 'Select All',
    onInitialized: function(select, container) {
        container.find('.multiselect-container').css({
            'max-height': '250px',
            'overflow-y': 'auto'
        });
    }
});
    

    // Toggle dropdown on button click
    $('.multiselect').on('click', function (event) {
        event.stopPropagation(); // Prevent click from closing immediately

        var dropdown = $(this).closest('.btn-group').find('.multiselect-container');

        // Toggle visibility
        if (dropdown.is(':visible')) {
            dropdown.hide();
        } else {
            $('.multiselect-container').hide(); // Hide other dropdowns
            dropdown.show();
        }
    });

    // Hide dropdown when clicking outside
    $(document).on('click', function () {
        $('.multiselect-container').hide();
    });

    // Hide dropdown when clicking the 'X' in the search box
    $(document).on('click', '.multiselect-clear-filter', function (event) {
        event.stopPropagation(); // Prevent triggering the outside click event
        $(this).closest('.multiselect-container').hide();
    });

    // Ensure dropdown remains visible when interacting inside it
    $(document).on('click', '.multiselect-container', function (event) {
        event.stopPropagation();
    });
});

</script>

</body>

</html>
