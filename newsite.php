<?php
include './header.php';
require_once './src/sites.php';
require './src/helper-functions.php';
require_once './src/Database.php';

$err = '';
$msg = '';

function getAllUsedColors() {
    $db = Database::getInstance();
    $colors = [];
    $sql = "SELECT color FROM sites";
    $res = $db->query($sql);

    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $colors[] = strtoupper($row['color']);
        }
    }
    return $colors;
}

function generateUniqueColor($usedColors) {
    do {
        $newColor = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
    } while (in_array(strtoupper($newColor), $usedColors));
    return $newColor;
}

// ✅ Notify all users (ignore teams)
function notifyAllUsers($message, $siteName) {
    $db = Database::getInstance();
    $result = $db->query("SELECT id FROM users");

    if ($result && $result->num_rows > 0) {
        $stmt = $db->prepare("INSERT INTO notifications (user_id, message, site_name, is_read, created_at) VALUES (?, ?, ?, ?, NOW())");

        while ($row = $result->fetch_assoc()) {
            $userId = $row['id'];

            // Mark as read only for the user who created the site
            $isRead = ($userId == ($_SESSION['user_id'] ?? 0)) ? 1 : 0;

            $stmt->bind_param("issi", $userId, $message, $siteName, $isRead);
            $stmt->execute();
        }

        $stmt->close();
    }
}

if (isset($_POST['submit'])) {
    $site_name = $_POST['site_name'];

    if (strlen($site_name) < 1) {
        $err = "Please enter site name";
    } else {
        try {
            $usedColors = getAllUsedColors();
            $site_color = generateUniqueColor($usedColors);

            $site = new Sites([
                'site_name' => $site_name,
                'color' => $site_color
            ]);
            $site->save();

            // ✅ Notify all users
            notifyAllUsers("📍 A new site has been created: $site_name", $site_name);

            $msg = "Site created successfully with color: $site_color";
        } catch (Exception $e) {
            $err = "Failed to create site: " . $e->getMessage();
        }
    }
}
?>

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="sites.php">Sites</a></li>
            <li class="breadcrumb-item active">New Site</li>
        </ol>

        <div class="card mb-3">
            <div class="card-header">
                <h3>Create a new site</h3>
            </div>
            <div class="card-body">
                <?php if(strlen($err) > 1): ?>
                    <div class="alert alert-danger text-center my-3" role="alert">
                        <strong>Failed! </strong> <?= $err ?>
                    </div>
                <?php endif ?>

                <?php if(strlen($msg) > 1): ?>
                    <div class="alert alert-success text-center my-3" role="alert">
                        <strong>Success! </strong> <?= $msg ?>
                    </div>
                <?php endif ?>

                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <div class="form-group row col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-sm-12">
                        <label for="name" class="col-sm-12 col-lg-2 col-md-2 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="site_name" class="form-control" placeholder="Enter name">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-lg btn-primary"> Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

<!-- JS Libraries -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.js"></script>
<script src="js/sb-admin.min.js"></script>
<script src="js/demo/datatables-demo.js"></script>
<script src="js/demo/chart-area-demo.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Notifications Logic -->
<!--<script src="js/notifications.js"></script>-->

</body>
</html>
