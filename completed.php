<?php
    include './header.php';
    require_once './src/ticket.php';
    require_once './src/requester.php';
    require_once './src/team.php';
    require_once './src/user.php';

    // Remove session_start() since it's already in header.php


    // Check if user is logged in
    if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || !isset($_SESSION['team_name'])) {
        die("Unauthorized access. Please log in.");
    }
    

    $user_id = $_SESSION['user'];
    $user_role = $_SESSION['role'];
    $user_team_id = $_SESSION['team_name'];

    // Ensure database connection
    if (!isset($db)) {
        die("Database connection is missing.");
    }

    $ticket = new Ticket();

    // Fetch tickets based on user role
if ($user_role === 'admin') {
  $allTicket = $ticket::findByStatus('completed');
  $sql = "SELECT * FROM ticket ORDER BY id DESC";
  $stmt = $db->prepare($sql);
} else {
  $allTicket = $ticket::findByStatusAndTeam('completed', $user_team_id);
  $sql = "SELECT * FROM ticket WHERE team_assigned = ? ORDER BY id DESC";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("s", $user_team_id);
}

$stmt->execute();
$res = $stmt->get_result();
if (!$res) {
  die("Error fetching tickets: " . $db->error);
}

$tickets = $res->fetch_all(MYSQLI_ASSOC);

// Fetch ongoing tickets only for the user's team


?>

<div id="content-wrapper">

  <div class="container-fluid">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Overview</li>
    </ol>
    <div class="card mb-3">
            <div class="card-body">
            <div id="filter-container">
                  <input type="text" id="search-filter" placeholder="Search">
                  <div id="tree-filter"></div>
                  <br>
              </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>TicketCode</th>
                            <th>Site Name</th>
                            <th>Cluster</th>
                            <th>State</th>
                            <th>Project</th>
                            <th>Vendor</th>
                            <th>Activity</th>
                            <th>Remarks</th>
                            <th>Team Assigned</th>
                            <th>Schedule Date</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($allTicket as $ticket): ?>
                            <?php $ticket = (object) $ticket; ?> <!-- Convert array to object -->
                            <tr>
                                <td><a href="./ticket-details.php?id=<?php echo $ticket->id?>"><?php echo $ticket->id?><?php echo $ticket->title?></a></td>
                                <td><?php echo $ticket->site_name ?></td>
                                <td><?php echo $ticket->cluster ?></td>
                                <td><?php echo $ticket->state ?></td>
                                <td><?php echo $ticket->project ?></td>
                                <td><?php echo $ticket->vendor ?></td>
                                <td><?php echo $ticket->work_type ?></td>
                                <td><?php echo $ticket->remarks ?></td>
                                <td><?php echo $ticket->team_assigned ?></td>
                                <td><?php echo date('d-m-Y', strtotime($ticket->schedule_date)) ?></td>
                                <td><button class="btn btn-danger"><?php echo $ticket->status ?></button></td>
                                <td><?php echo $ticket->priority ?></td>
                                <?php $date = new DateTime($ticket->created_at)?>
                                <td><?php echo $date->format('d-m-Y H:i:s')?> </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>

  </div>
  <!-- /.container-fluid -->

  <!-- Sticky Footer -->
  <footer class="sticky-footer">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright © Your Website 2019</span>
      </div>
    </div>
  </footer>

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

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin.min.js"></script>

<!-- Demo scripts for this page-->
<script src="js/demo/datatables-demo.js"></script>
<script src="js/demo/chart-area-demo.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>





<script>
document.addEventListener("DOMContentLoaded", function () {
    let table = document.querySelector("#dataTable");
    let activeFilters = JSON.parse(localStorage.getItem("activeFilters")) || {};
    let searchInput = document.querySelector("#search-filter");

    function collectUniqueValues(columnIndex) {
        let values = new Set();
        table.querySelectorAll("tbody tr").forEach(row => {
            let cellValue = row.cells[columnIndex].textContent.trim();
            if (cellValue) {
                values.add(cellValue);
            }
        });
        return Array.from(values);
    }

    function applyFilters() {
        let searchText = searchInput.value.toLowerCase();
        table.querySelectorAll("tbody tr").forEach(row => {
            let showRow = true;
            let rowText = row.textContent.toLowerCase();
            if (searchText && !rowText.includes(searchText)) {
                showRow = false;
            }
            Object.keys(activeFilters).forEach(columnIndex => {
                let cellValue = row.cells[columnIndex].textContent.trim();
                if (activeFilters[columnIndex].length > 0 && !activeFilters[columnIndex].includes(cellValue)) {
                    showRow = false;
                }
            });
            row.style.display = showRow ? "" : "none";
        });
        localStorage.setItem("activeFilters", JSON.stringify(activeFilters));
    }

    function createFilterTree(columnIndex, columnName, columnHeader) {
        let values = collectUniqueValues(columnIndex);
        let filterContainer = document.createElement("div");
        filterContainer.classList.add("tree-filter-container");
        filterContainer.innerHTML = `<strong>${columnName}</strong><br>
                                     <input type="text" class="filter-search" placeholder="Search"/><br>
                                     <div id="tree-filter-${columnIndex}"></div>`;
        document.body.appendChild(filterContainer);

        let filterData = [{ 
            "id": `all-${columnIndex}`, "text": "(Select All)", "state": { "opened": true, "selected": false }, 
            "children": values.map(value => ({ 
                "id": `${columnIndex}-${value}`,  // Fixed ID formatting
                "text": value, 
                "state": { "selected": activeFilters[columnIndex] && activeFilters[columnIndex].includes(value) } 
            }))
        }];

        if ($(`#tree-filter-${columnIndex}`).jstree(true)) {
            $(`#tree-filter-${columnIndex}`).jstree("destroy").empty();
        }

        $(`#tree-filter-${columnIndex}`).jstree({
            "plugins": ["checkbox", "search"],
            "core": {
                "data": filterData
            }
        });

        // Search functionality for filter tree
        filterContainer.querySelector(".filter-search").addEventListener("keyup", function () {
            let searchText = this.value;
            $(`#tree-filter-${columnIndex}`).jstree(true).search(searchText);
        });

        // Apply filter logic
        $(`#tree-filter-${columnIndex}`).on("changed.jstree", function (e, data) {
            activeFilters[columnIndex] = data.selected.map(id => id.replace(`${columnIndex}-`, ""));  // Fixed replace syntax
            if (activeFilters[columnIndex].includes(`all-${columnIndex}`)) {
                activeFilters[columnIndex] = [];
            }
            applyFilters();
        });

        // Position the filter popup near the column header
        let rect = columnHeader.getBoundingClientRect();
        filterContainer.style.position = "absolute";
        filterContainer.style.top = `${rect.bottom}px`;
        filterContainer.style.left = `${rect.left}px`;
        filterContainer.style.background = "white";
        filterContainer.style.border = "1px solid #ccc";
        filterContainer.style.padding = "10px";
        filterContainer.style.zIndex = "1000";

        document.addEventListener("click", function (event) {
            if (!filterContainer.contains(event.target) && event.target !== columnHeader) {
                filterContainer.remove();
            }
        });
    }

    // Add click event to column headers for filter popup
    document.querySelectorAll("#dataTable thead th").forEach((columnHeader, index) => {
        columnHeader.style.cursor = "pointer";
        columnHeader.addEventListener("click", function (event) {
            event.stopPropagation();
            document.querySelectorAll(".tree-filter-container").forEach(el => el.remove()); // Close any existing filters
            createFilterTree(index, columnHeader.textContent, columnHeader);
        });
    });

    // Apply filters on load if any were stored
    applyFilters();

    // Add event listener for search input
    searchInput.addEventListener("keyup", applyFilters);

    window.addEventListener("beforeunload", function () {
        localStorage.removeItem("activeFilters");
    });
});




</script>
</body>

</html>