<?php
include './header.php';
require_once './src/team.php';
require_once './src/ticket.php';
require_once './src/ticket-event.php';
require_once './src/team-member.php';
require_once './src/comment.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = $_SESSION['role'] === 'admin';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    echo '<script> history.back();</script>';
    exit();
}

$ticket_id = $_GET['id'];
$ticket = Ticket::find($ticket_id);

if (!$ticket) {
    echo '<script>alert("Ticket not found!"); history.back();</script>';
    exit();
}

$ticketId = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

if ($ticketId <= 0) {
    die("Error: Invalid Ticket ID.");
}

$teams = Team::findAll();
$events = Event::findByTicket($ticket->id);
$comments = Comment::findByTicket($ticket->id);

// Get all sites
$site_sql = "SELECT id, site_name FROM sites ORDER BY site_name ASC";
$site_res = $db->query($site_sql);
$sites = $site_res->fetch_all(MYSQLI_ASSOC);

$selected_work_types = explode(',', $ticket->work_type ?? '');

$err = '';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team = $_POST["team_assigned"];
    $status = $_POST["status"];
    $work_type = isset($_POST['work_type']) ? implode(',', $_POST['work_type']) : '';

    if ($isAdmin) {
        $ticket->site_name = $_POST["site_name"];
        $ticket->cluster = $_POST["cluster"];
        $ticket->state = $_POST["state"];
        $ticket->project = $_POST["project"];
        $ticket->vendor = $_POST["vendor"];
        $remarks = $_POST['remarks'] ?? null;
        $ticket->schedule_date = $_POST["schedule_date_from"];
        $ticket->schedule_date_from = $_POST["schedule_date_from"];
        $ticket->schedule_date_to = $_POST["schedule_date_to"];
        $ticket->priority = $_POST["priority"];
    }

    try {
        $ticket->work_type = $work_type;
        $ticket->team_assigned = $team;
        $ticket->status = $status;
        $ticket->last_user_modified = $_SESSION['user'];

        if ($ticket->update($ticket->id)) {
            echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "?id=" . $ticket->id . "';</script>";
            exit();
        } else {
            $err = "Database update failed!";
        }
    } catch (Exception $e) {
        $err = "Exception: " . $e->getMessage();
    }
}
?>

<style>
    .worknotes-container {
        max-height: 400px;
        overflow-y: auto;
        border-radius: 10px;
        padding: 15px;
        background: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #worknotes-scroll {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 10px;
    }

    #worknotes-list li {
        background: #f8f9fa;
        border-left: 5px solid #007bff;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 12px;
        transition: all 0.3s ease-in-out;
    }

    #worknotes-list li:hover {
        background: #e9ecef;
        transform: translateY(-3px);
    }

    .worknote-img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-top: 8px;
        transition: transform 0.3s ease-in-out;
    }

    .worknote-img:hover {
        transform: scale(1.05);
    }

    #add-worknote {
        background: #007bff;
        color: white;
        border-radius: 8px;
        transition: 0.3s;
    }

    #add-worknote:hover {
        background: #0056b3;
        transform: scale(1.05);
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .card-header {
        border-radius: 12px 12px 0 0;
        font-weight: bold;
    }

    .card-body {
        padding: 20px;
    }

    .ticket-info {
        font-size: 12px;
        padding: 10px;
    }

    .ticket-info label {
        font-size: 11px;
        margin-bottom: 2px;
    }

    .ticket-info .form-control {
        font-size: 11px;
        padding: 3px 6px;
        height: 26px;
    }

    .ticket-info h4 {
        font-size: 14px;
    }

    .ticket-info button {
        font-size: 12px;
        padding: 6px 10px;
    }
</style>

<div id="content-wrapper" class="container-fluid mt-4">
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item"><a href="calendar.php">Calendar</a></li>
        <li class="breadcrumb-item active">Ticket Details</li>
    </ol>

    <div class="row">
        <!-- Left Column: Work Notes -->
        <div class="col-md-8">
            <div id="work-notes-container" class="card shadow-lg border-0 rounded-lg bg-light h-100">
                <div class="card-header bg-secondary text-white">
                    <h4>Work Notes</h4>
                </div>
                <div class="card-body">
                    <div class="worknotes">
                        <input type="text" id="search-worknotes" placeholder="Search worknotes..." class="form-control">
                        <input type="hidden" id="ticket-id" value="<?php echo htmlspecialchars($_GET['id']); ?>">

                        <div id="worknotes-container">
                            <div id="worknotes-scroll" class="worknotes-container">
                                <ul id="worknotes-list">
                                    <?php
                                    $worknotes = array_reverse(Comment::findByTicket($ticket->id));
                                    foreach ($worknotes as $note) {
                                        $imagePath = !empty($note->screenshot_path) ? "src/src/uploads/" . basename(htmlspecialchars($note->screenshot_path)) : "";

                                        echo "<li id='worknote-{$note->id}'>
                                                <strong>{$note->author}</strong> ({$note->created_at}): 
                                                <span class='worknote-text'>{$note->body}</span>";

                                        if ($imagePath) {
                                            echo "<br>
                                                <a href='{$imagePath}' target='_blank'>
                                                    <img src='{$imagePath}' class='worknote-img img-fluid' alt='Screenshot'>
                                                </a>";
                                        }

                                        echo "<div class='mt-2'>
                                                <button class='btn btn-sm btn-primary edit-worknote' data-id='{$note->id}'>Edit</button>
                                                <button class='btn btn-sm btn-danger delete-worknote' data-id='{$note->id}'>Delete</button>
                                            </div>";

                                        echo "</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <textarea id="new-remark" name="new_remark" class="form-control" placeholder="Add a new worknote..."></textarea>
                    <input type="file" id="screenshot" name="screenshot" class="form-control mt-2">
                    <button type="button" id="add-worknote" class="btn btn-info mt-2">Add Worknote</button>
                </div>
            </div>
        </div>

        <!-- Right Column: Ticket Update -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 rounded-lg bg-light h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <?php echo $ticket->displayStatusBadge() ?>
                        <small class="ml-2">
                            <?php echo $ticket->title ?>
                            <span class="text-light">
                                <?php $date = !empty($ticket->created_at) ? new DateTime($ticket->created_at) : null; ?>
                                <?php echo $date ? $date->format('d-m-Y H:i:s') : 'N/A'; ?>
                            </span>
                        </small>
                    </div>
                </div>

                <div class="card-body ticket-info">
                    <form method="post">
                        <?php if (strlen($err) > 1): ?>
                            <div class="alert alert-danger text-center my-3" role="alert">
                                <strong>Failed! </strong> <?php echo $err; ?>
                            </div>
                        <?php endif ?>

                        <?php if (strlen($msg) > 1): ?>
                            <div class="alert alert-success text-center my-3" role="alert">
                                <strong>Success! </strong> <?php echo $msg; ?>
                            </div>
                        <?php endif ?>

                        <div class="row">
                            <div class="col-12">
                                <h4 class="mb-3 text-primary">Additional Ticket Information</h4>

                                <!-- Site Name (Combo Box) -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Site Name:</strong></label>
                                    <div class="col-8">
                                        <!-- Add this into the Site Name field -->
                                        <select name="site_name" class="form-control" <?php echo !$isAdmin ? 'disabled' : ''; ?>>
                                            <?php foreach ($sites as $site) : ?>
                                                <option value="<?php echo htmlspecialchars($site['site_name']); ?>" 
                                                    <?php echo ($ticket->site_name == $site['site_name']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($site['site_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Cluster -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Cluster:</strong></label>
                                    <div class="col-8">
                                        <input type="text" name="cluster" class="form-control" value="<?php echo htmlspecialchars($ticket->cluster ?? ''); ?>" <?php echo !$isAdmin ? 'readonly' : ''; ?> required>
                                    </div>
                                </div>

                                <!-- State -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>State:</strong></label>
                                    <div class="col-8">
                                        <input type="text" name="state" class="form-control" value="<?php echo htmlspecialchars($ticket->state ?? ''); ?>" <?php echo !$isAdmin ? 'readonly' : ''; ?> required>
                                    </div>
                                </div>

                                <!-- Project (Combo Box) -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Project:</strong></label>
                                    <div class="col-8">
                                        <select name="project" class="form-control" <?php echo !$isAdmin ? 'disabled' : ''; ?> required>
                                            <option value="">-- Select Project --</option>
                                            <option value="NBN" <?php echo $ticket->project == 'NBN' ? 'selected' : ''; ?>>NBN</option>
                                            <option value="TELSTRA" <?php echo $ticket->project == 'TELSTRA' ? 'selected' : ''; ?>>TELSTRA</option>
                                            <option value="EJV" <?php echo $ticket->project == 'EJV' ? 'selected' : ''; ?>>EJV</option>
                                            <option value="Optus" <?php echo $ticket->project == 'Optus' ? 'selected' : ''; ?>>Optus</option>
                                            <option value="Starlink" <?php echo $ticket->project == 'Starlink' ? 'selected' : ''; ?>>Starlink</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Vendor -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Vendor:</strong></label>
                                    <div class="col-8">
                                        <input type="text" name="vendor" class="form-control" value="<?php echo htmlspecialchars($ticket->vendor ?? ''); ?>" <?php echo !$isAdmin ? 'readonly' : ''; ?> required>
                                    </div>
                                </div>

                                <!-- Activity -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Activity:</strong></label>
                                    <div class="col-8">
                                        <select id="work_type" name="work_type[]" class="form-control" multiple>
                                            <?php foreach (["site survey","scope checking","plant hire","team submission","material checking","RF prep works","RF Build","RF migration","TX prep works","TX link upgrade","Comm CL","RBS swap","BBS install","AC upgrade","SWR installation","HOPS","LSP","Alarm Testing","Rubbish Disposal","Decom material return","Call Testing"] as $type) {
                                                $selected = in_array($type, $selected_work_types) ? 'selected' : '';
                                                echo "<option value='$type' $selected>$type</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Assigned Team -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Assigned Team:</strong></label>
                                    <div class="col-8">
                                        <select name="team_assigned" class="form-control" <?php echo !$isAdmin ? 'disabled' : ''; ?>>
                                            <?php foreach ($teams as $team) : ?>
                                                <option value="<?php echo $team->name; ?>" <?php echo $ticket->team_assigned == $team->name ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($team->name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Schedule Date From -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Schedule Date From:</strong></label>
                                    <div class="col-8">
                                        <input type="date" name="schedule_date_from" class="form-control" value="<?php echo htmlspecialchars($ticket->schedule_date_from ?? ''); ?>" <?php echo !$isAdmin ? 'readonly' : ''; ?> required>
                                    </div>
                                </div>

                                <!-- Schedule Date To -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Schedule Date To:</strong></label>
                                    <div class="col-8">
                                        <input type="date" name="schedule_date_to" class="form-control" value="<?php echo htmlspecialchars($ticket->schedule_date_to ?? ''); ?>" <?php echo !$isAdmin ? 'readonly' : ''; ?> required>
                                    </div>
                                </div>

                                <!-- Priority -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Priority:</strong></label>
                                    <div class="col-8">
                                        <select name="priority" class="form-control" <?php echo !$isAdmin ? 'disabled' : ''; ?>>
                                            <option value="Low" <?php echo $ticket->priority == 'Low' ? 'selected' : ''; ?>>Low</option>
                                            <option value="Medium" <?php echo $ticket->priority == 'Medium' ? 'selected' : ''; ?>>Medium</option>
                                            <option value="High" <?php echo $ticket->priority == 'High' ? 'selected' : ''; ?>>High</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Status:</strong></label>
                                    <div class="col-8">
                                        <select name="status" class="form-control rounded shadow-sm">
                                            <option value="New" <?php echo $ticket->status == 'New' ? 'selected' : ''; ?>>New</option>
                                            <option value="On-going" <?php echo $ticket->status == 'On-going' ? 'selected' : ''; ?>>On-going</option>
                                            <option value="On Hold" <?php echo $ticket->status == 'On Hold' ? 'selected' : ''; ?>>On Hold</option>
                                            <option value="Completed" <?php echo $ticket->status == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Last Modified -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Last Modified:</strong></label>
                                    <div class="col-8">
                                        <?php echo !empty($ticket->date_modified) ? (new DateTime($ticket->date_modified))->format('d-m-Y H:i:s') : 'N/A'; ?>
                                    </div>
                                </div>

                                <!-- Last Modified By -->
                                <div class="row align-items-center mb-2">
                                    <label class="col-4"><strong>Last Modified By:</strong></label>
                                    <div class="col-8">
                                        <?php echo htmlspecialchars($ticket->last_user_modified ?? 'N/A'); ?>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-4 text-center">
                                    <button type="submit" class="btn btn-success shadow-sm px-4 py-2">Update Ticket</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './footer.php'; ?>

<!-- Bootstrap Multiselect -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/css/bootstrap-multiselect.css">

<!-- Ticket-specific JS -->
<script src="js/ticket.js"></script>

<script>
$(document).ready(function () {
    // Initialise multiselect (same settings as ticket.php)
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
});
</script>
