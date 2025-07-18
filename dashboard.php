<?php
include './header.php';
require_once './src/Database.php';

$db = Database::getInstance();

// ✅ Fetch Ticket Counts Grouped by Project & Status
$query = "SELECT project, site_name,
                 CASE 
                     WHEN SUM(CASE WHEN status = 'On-going' THEN 1 ELSE 0 END) > 0 THEN 'On-going'
                     WHEN SUM(CASE WHEN status = 'New' THEN 1 ELSE 0 END) > 0 THEN 'New'
                     WHEN SUM(CASE WHEN status = 'On Hold' THEN 1 ELSE 0 END) > 0 THEN 'On Hold'
                     ELSE 'Completed'
                 END AS overall_status
          FROM ticket
          WHERE project IN ('NBN', 'TELSTRA', 'EJV') 
          GROUP BY project, site_name";
$result = $db->query($query);

// ✅ Default structure for storing ticket statuses per project
$projectStatusCounts = [
    "NBN" => ["New" => 0, "On-going" => 0, "On Hold" => 0, "Completed" => 0],
    "TELSTRA" => ["New" => 0, "On-going" => 0, "On Hold" => 0, "Completed" => 0],
    "EJV" => ["New" => 0, "On-going" => 0, "On Hold" => 0, "Completed" => 0]
];

while ($row = $result->fetch_assoc()) {
    $project = strtoupper(trim($row['project']));  
    $status = trim($row['overall_status']); 

    if (isset($projectStatusCounts[$project][$status])) {
        $projectStatusCounts[$project][$status] += 1;  // Count unique sites, not tickets
    }
}

$projectStatusJSON = json_encode($projectStatusCounts);
?>

<div id="content-wrapper">
<div class="container-fluid">
        <div class="row">
            <?php foreach ($projectStatusCounts as $project => $statuses): ?>
                <div class="col-md-4 d-flex justify-content-center">
                    <div class="chart-container" style="width: 300px; height: 300px;">
                        <h5 class="text-center"><?php echo $project; ?> Ticket Status</h5>
                        <canvas id="<?php echo strtolower($project); ?>PieChart"></canvas>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Ticket Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ticket Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ticketList">
            <div id="ticketTableContainer" class="mt-3"></div>

                <!-- Ticket details will be inserted here via AJAX -->
            </div>
        </div>
    </div>
</div>

    <!-- Sticky Footer -->
    <footer class="sticky-footer">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span></span>
            </div>
        </div>
    </footer>
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal -->
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

<!-- Bootstrap & Chart.js -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/chart.js/Chart.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


<style>
/* 🌟 Modern Light Mode Pie Chart Style */
.chart-container {
    background: rgba(255, 255, 255, 0.8); /* ✅ Slightly higher transparency */
    border-radius: 15px;
    padding: 20px;
    backdrop-filter: blur(12px); /* ✅ More refined blur */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08); /* ✅ Softer shadow */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden; /* ✅ Prevents overflow issues */
    max-width: 320px; /* ✅ Ensures the chart fits inside */
    text-align: center;
}

.chart-container:hover {
    transform: scale(1.03); /* ✅ Slightly reduced scale for elegance */
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); /* ✅ More natural shadow */
}

/* 🎯 Light Mode Theme */
body {
    background: #f8f9fa; /* ✅ Soft gray background */
    color: #333; /* ✅ Dark text for contrast */
    font-family: "Poppins", sans-serif; /* ✅ Modern & clean font */
}

/* 🏷️ Pie Chart Title */
h5 {
    font-size: 18px;
    text-transform: uppercase;
    font-weight: bold;
    color: #333; /* ✅ Dark gray text */
}

/* 🎯 Make Pie Charts Look Sleek */
canvas {
    filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.08)); /* ✅ Soft depth effect */
    transition: transform 0.2s ease-in-out;
}

canvas:hover {
    transform: scale(1.02); /* ✅ Slight zoom effect on hover */
}

/* 🛑 Cool Hover Glow Effect */
canvas:hover {
    filter: drop-shadow(0 0 10px rgba(0, 163, 255, 0.4)); /* ✅ More balanced neon effect */
}

/* 🟢 Doughnut Chart Glow */
.chart-container:hover canvas {
    filter: drop-shadow(0 0 15px rgba(46, 204, 113, 0.7));
}



</style>

<!-- ✅ Separate Pie Chart Script for Each Project -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    var projectStatusCounts = <?php echo $projectStatusJSON; ?>;

    function createPieChart(canvasId, projectData, projectName) {
    var ctx = document.getElementById(canvasId);
    if (!ctx) {
        console.error("Canvas element '" + canvasId + "' not found!");
        return;
    }

    var labels = Object.keys(projectData);
    var values = labels.map(status => projectData[status]);

    var chart = new Chart(ctx.getContext("2d"), {
        type: "doughnut", // ✅ Modern Doughnut Chart
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: [
                    "#74b9ff", // Soft Blue
                    "#ff7675", // Soft Red
                    "#feca57", // Soft Yellow
                    "#1dd1a1"  // Soft Green
                ],
                hoverBackgroundColor: [
                    "#0984e3", // Darker Blue
                    "#d63031", // Darker Red
                    "#e1b12c", // Darker Yellow
                    "#10ac84"  // Darker Green
                ],
                borderWidth: 3,
                borderColor: "#ffffff",
                hoverOffset: 15, // ✅ Smooth expanding effect on hover
                borderJoinStyle: "round"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: "50%", // ✅ Sleek doughnut style
            plugins: {
                legend: {
                    position: "bottom",
                    labels: {
                        font: { size: 14, weight: "bold" },
                        color: "#333", // Dark text for light mode
                        padding: 12
                    }
                },
                tooltip: {
                    backgroundColor: "rgba(255, 255, 255, 0.9)", // ✅ Glassmorphic tooltip
                    titleFont: { size: 14, weight: "bold", color: "#000" },
                    bodyFont: { size: 14, weight: "bold", color: "#444" },
                    borderColor: "#ddd",
                    borderWidth: 1,
                    cornerRadius: 10,
                    padding: 12,
                    titleColor: "#000",
                    bodyColor: "#333",
                    displayColors: false,
                    shadowBlur: 10,
                    shadowColor: "rgba(0, 0, 0, 0.2)"
                }
            },
            animation: {
                animateRotate: true, // ✅ Smooth rotation on load
                animateScale: true,  // ✅ Subtle bounce effect
                easing: "easeOutElastic",
                duration: 1200
            },
            onHover: function(event, chartElement) {
                event.target.style.cursor = chartElement.length ? "pointer" : "default";
            },
            onClick: function (event, elements) {
                if (!elements || elements.length === 0) {
                    console.error("❌ No section clicked. Check if the chart is properly rendered.");
                    return;
                }

                var clickedElement = elements[0];
                var clickedIndex = clickedElement.index ?? clickedElement._index;

                if (clickedIndex === undefined) {
                    console.error("❌ Invalid clicked index:", clickedIndex);
                    return;
                }

                var chart = clickedElement._chart ?? clickedElement.chart;

                if (!chart) {
                    console.error("❌ Chart instance not found.");
                    return;
                }

                var labels = chart.data.labels;
                var clickedStatus = labels[clickedIndex];

                if (!clickedStatus) {
                    console.error("❌ Clicked status is undefined.");
                    return;
                }

                var projectName = chart.canvas.id.replace("PieChart", "").toUpperCase();

                console.log("✅ Redirecting to tickets page:", projectName, clickedStatus);

                // Redirect to the new page with project and status as parameters
                //window.location.href = `get-tickets.php?project=${encodeURIComponent(projectName)}&status=${encodeURIComponent(clickedStatus)}`;
                window.location.href = `tickets.php?project=${encodeURIComponent(projectName)}&status=${encodeURIComponent(clickedStatus)}`;
            }
        }
    });

    ctx.parentNode.style.width = "400px";
    ctx.parentNode.style.height = "400px";
}






    function fetchTickets(project, status) {
        if (!project || !status) {
            console.error("Missing parameters: Project or Status is undefined.");
            return;
        }

        var url = `fetch_tickets.php?project=${encodeURIComponent(project)}&status=${encodeURIComponent(status)}`;
        
        console.log("Fetching tickets from:", url);

        $.get(url, function (data) {
            console.log("AJAX Success:", data);
            $("#ticketList").html(data); // ✅ Ensure data loads inside modal body
            $("#ticketModal").modal("show"); // ✅ Open modal after data load
        }).fail(function () {
            console.error("Error fetching ticket data.");
        });
    }

    // Generate Pie Charts Dynamically
    Object.keys(projectStatusCounts).forEach(project => {
        createPieChart(project.toLowerCase() + "PieChart", projectStatusCounts[project], project);
    });
});
</script>

</body>
</html>
