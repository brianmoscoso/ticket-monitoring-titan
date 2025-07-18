<?php 
session_start();

// Redirect if not logged in
if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] == false) {
    header('Location: ./index.php');
    exit();
}

$user = $_SESSION['user'];
require_once './src/Database.php';
$db = Database::getInstance();

// Fetch unread notifications for the logged-in user's team
$logged_in_team_id = $_SESSION['team_id'] ?? 0;

$sql = "SELECT * FROM notifications WHERE team_id = ? AND is_read = 0 ORDER BY created_at DESC";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $logged_in_team_id);
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Titan - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

  <!-- FullCalendar CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">

<!-- jQuery (Ensure jQuery is loaded before FullCalendar) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

<style>
  #calendar {
    max-width: 80%;
    max-height: 500px;
    margin: 20px auto;
    padding: 10px;
  }

  .fc-event {
    cursor: pointer;
  }

  /* Ticket status colors */
  .open-event { background-color: #28a745 !important; } /* Green */
  .pending-event { background-color: #ffc107 !important; } /* Yellow */
  .closed-event { background-color: #dc3545 !important; } /* Red */
</style>



</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="dashboard.php">Titan</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="hidden" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <!--<button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>-->
        </div>
      </div>
    </form>

    <!-- Navbar -->

    

    <ul class="navbar-nav ml-auto ml-md-0">
      
      
      <li class="nav-item dropdown">
        <a class="nav-link" href="#" id="notificationsToggle" data-toggle="dropdown">
            Notifications <span class="badge badge-danger" id="notificationCount">
                <?= count($notifications) > 0 ? count($notifications) : '' ?>
                
            </span>

            <i id="notifArrow" class="fas fa-chevron-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" id="notificationsDropdown">
            <?php if (!empty($notifications)): ?>
                <?php foreach ($notifications as $notification): ?>
                    <?php 
                        $ticket_id = isset($notification['ticket_id']) ? $notification['ticket_id'] : null; 
                        $ticket_url = $ticket_id ? "ticket-details.php?id=$ticket_id" : "#"; // Use "#" if no ticket_id
                    ?>
                    <a href="<?= $ticket_url ?>" 
                      class="dropdown-item notification-item" 
                      data-id="<?= $notification['id'] ?>" 
                      <?php if ($ticket_id): ?> data-ticket-id="<?= $ticket_id ?>" <?php endif; ?>>
                        <?= htmlspecialchars($notification['message']) ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <a class="dropdown-item text-muted">No new notifications</a>
            <?php endif; ?>
        </div>
      </li>

      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i> <?php echo $user->name?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="change-password.php">Change Password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="./logout.php" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>

      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="./dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span> Dashboard</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./calendar.php">
          <i class="fas fa-fw fa-calendar-alt"></i>
          <span> Calendar</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./tickets.php?status=new">
          <i class="fas fa-fw fa-lock-open"></i>
          <span> New</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./tickets.php?status=ongoing">
          <i class="fa fa-fw fa-times-circle"></i>
          <span> On Going</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./tickets.php?status=onhold">
          <i class="fa fa-fw fa-adjust"></i>
          <span> On Hold</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./tickets.php?status=completed">
          <i class="fa fa-fw fa-anchor"></i>
          <span> Completed</span>
        </a>
      </li>
      <!-- <li class="nav-item active">
        <a class="nav-link" href="./new.php">
          <i class="fas fa-fw fa-lock-open"></i>
          <span> New</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./on-going.php">
          <i class="fa fa-fw fa-times-circle"></i>
          <span> On Going</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./on-hold.php">
          <i class="fa fa-fw fa-adjust"></i>
          <span> On Hold</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./completed.php">
          <i class="fa fa-fw fa-anchor"></i>
          <span> Completed</span>
        </a>
      </li> -->
      <!--<li class="nav-item active">
        <a class="nav-link" href="./mytickets.php">
          <i class="fa fa-fw fa-award"></i>
          <span> My tickets</span>
        </a>
      </li>-->
      <?php if($user->role == 'admin'): ?>
      <li class="nav-item active">
        <a class="nav-link" href="./sites.php">
          <i class="fa fa-fw fa-award"></i>
          <span> Sites</span>
        </a>
      </li>
      
      <li class="nav-item active">
        <a class="nav-link" href="./team.php">
          <i class="fa fa-fw fa-users"></i>
          <span> Teams</span>
        </a>
      </li>
      
      <li class="nav-item active">
        <a class="nav-link" href="./users.php">
          <i class="fa fa-fw fa-users"></i>
          <span> Users</span>
        </a>
      </li>
   <?php endif; ?>  
    </ul>
    
    <!-- jQuery (Required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap -->
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap 4 or 5 (Use the correct version based on your project) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


<!-- FullCalendar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Close the dropdown when clicking outside
    document.addEventListener("click", function (event) {
      var dropdown = document.getElementById("userDropdown");
      if (!dropdown.contains(event.target)) {
        $(".dropdown-menu").removeClass("show"); // Force close
      }
    });

    // Ensure dropdown toggles correctly
    $("#userDropdown").on("click", function (event) {
      event.stopPropagation(); // Prevent closing when clicking the dropdown
      $(this).next(".dropdown-menu").toggleClass("show");
    });
  });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Notifications Script -->
<script src="js/notifications.js"></script>
