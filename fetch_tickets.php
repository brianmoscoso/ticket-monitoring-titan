<?php
require_once './src/Database.php';

error_log("GET Parameters: " . print_r($_GET, true));

if (isset($_GET['project']) && isset($_GET['status'])) {
    $db = Database::getInstance();
    
    $project = $db->real_escape_string(trim($_GET['project']));
    $status = $db->real_escape_string(trim($_GET['status']));

    error_log("Fetching tickets for Project: $project, Status: $status");

    $query = "SELECT id, site_name, work_type, status FROM ticket 
              WHERE project = '$project' AND status = '$status'";

    error_log("Executing Query: $query");

    $result = $db->query($query);

    if ($result && $result->num_rows > 0) {
        echo "<h5 class='text-center'>Tickets for $project - $status</h5>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Ticket ID</th><th>Site</th><th>Work Type</th><th>Status</th></tr></thead><tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['site_name']}</td>
                    <td>{$row['work_type']}</td>
                    <td>{$row['status']}</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        error_log("No tickets found for this category.");
        echo "<p class='text-center text-danger'>No tickets found for this category.</p>";
    }
} else {
    error_log("Invalid parameters received.");
    echo "<p class='text-center text-danger'>Invalid parameters received.</p>";
}
?>
