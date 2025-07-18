<?php
include './header.php';
require_once './src/Database.php';

if (!isset($_GET['project']) || !isset($_GET['status'])) {
    die("Invalid request. Project and Status are required.");
}

$project = $_GET['project'];
$status = $_GET['status'];

$db = Database::getInstance();
//$query = "SELECT id, site_name, cluster, state, project, vendor, work_type, remarks, team_assigned, schedule_date, status, 
        //priority, created_at FROM ticket WHERE project = ? AND status = ?";
$query = "SELECT * FROM ticket WHERE project = ? AND status = ?";        
$stmt = $db->prepare($query);
$stmt->bind_param("ss", $project, $status);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<style>
    /* Style adjustments */
    .table-container {
    max-width: 100%;
    overflow-x: auto;
    padding: 0 15px; /* Adjust padding for better alignment */
    }

    .table-responsive {
        width: 100%;
        max-width: 100%;
        overflow-x: auto; /* Enables horizontal scrolling */
    }

    .table {
        width: 100%;
        table-layout: fixed; /* Ensures columns do not stretch too much */
        word-wrap: break-word;
        white-space: nowrap; /* Prevents text from wrapping unnecessarily */
    }

    /* Light-colored table */
    .table th {
        background-color: #f8f9fa; /* Light gray */
        color: #343a40; /* Dark text */
        border-bottom: 2px solid #dee2e6;
    }

    /* Full-width table */
    .table {
    width: 100%;
    table-layout: auto; /* Ensures it expands properly */
    }

    .table-responsive {
    overflow-x: auto; /* Allows horizontal scrolling if needed */
    }

    .tree-menu {
        list-style-type: none;
        padding-left: 10px;
        font-size: 14px;
    }

    .tree-menu li {
        padding: 3px;
        display: flex;
        align-items: center;
    }

    .tree-menu input {
        margin-right: 5px;
    }

    #filterSearch {
        width: 100%;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>

<div class="container-fluid mt-4 table-container">
    <h3><?php echo htmlspecialchars($project); ?> - <?php echo htmlspecialchars($status); ?> Tickets</h3>

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
                    <?php foreach($result as $ticket): ?>
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
    

    <!-- Data Table -->
    <!-- <div class="card mb-3">
       
        <div class="table-responsive">
        <div id="columnFilterDropdown" class="dropdown-content" style="display:none; position:absolute; background:white; border:1px solid #ddd; padding:10px; z-index:1000; width: 200px;">
            <input type="text" id="filterSearch" class="form-control form-control-sm mb-2" placeholder="Search...">
            <ul id="filterOptions" class="tree-menu" style="list-style: none; padding-left: 10px; max-height: 200px; overflow-y: auto;"></ul>
            <button id="applyFilter" class="btn btn-primary btn-sm mt-2 w-100">Apply</button>
        </div>
            <table class="table table-bordered table-striped" id="ticketsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Site Name</th>
                        <th>Cluster</th>
                        <th>State</th>
                        <th>Project</th>
                        <th>Vendor <br> <input type="text" class="column-filter" data-column="5" readonly></th>
                        <th>Work Type <br> <input type="text" class="column-filter" data-column="6" readonly></th>
                        <th>Remarks</th>
                        <th>Team Assigned <br> <input type="text" class="column-filter" data-column="8" readonly></th>
                        <th>Schedule Date</th>
                        <th>Status <br> <input type="text" class="column-filter" data-column="10" readonly></th>
                        <th>Priority <br> <input type="text" class="column-filter" data-column="11" readonly></th>
                        <th>Date Created</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $result->data_seek(0); // Reset pointer for table data
                    while ($row = $result->fetch_assoc()) : 
                    ?>
                        <tr>
                            <td>
                                <a href="ticket-details.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                                    <?php echo htmlspecialchars($row['id']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($row['site_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['cluster']); ?></td>
                            <td><?php echo htmlspecialchars($row['state']); ?></td>
                            <td><?php echo htmlspecialchars($row['project']); ?></td>
                            <td><?php echo htmlspecialchars($row['vendor']); ?></td>
                            <td><?php echo htmlspecialchars($row['work_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['remarks']); ?></td>
                            <td><?php echo htmlspecialchars($row['team_assigned']); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($row['schedule_date'])); ?></td>
                            <td><span class="badge badge-<?php echo ($row['status'] == 'Completed') ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                            <td><?php echo htmlspecialchars($row['priority']); ?></td>
                            <td><?php echo date('d-m-Y H:i:s', strtotime($row['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>     -->

    <a href="dashboard.php" class="btn btn-primary mt-3">Back</a>
</div>
                    



<!-- Include DataTables JS -->

<!-- Initialize DataTables -->
<script>
    $(document).ready(function () {
        var table = $('#ticketsTable').DataTable();
        var selectedColumn = null;
        var selectedFilters = {}; // Store selected filters

        // When clicking the filter icon/input
        $('.column-filter').on('click', function (event) {
            event.stopPropagation();
            selectedColumn = $(this).data('column');

            // Get unique values from the selected column
            var columnData = table
                .column(selectedColumn)
                .data()
                .toArray()
                .filter((value, index, self) => value && self.indexOf(value) === index); // Remove duplicates

            // Build the checkbox list
            var filterOptionsHtml = `<li>
                <label><input type="checkbox" id="selectAll"> <b>(Select All)</b></label>
            </li>`;
            filterOptionsHtml += columnData.map(value => 
                `<li>
                    <label>
                        <input type="checkbox" class="filter-checkbox" value="${value}"> ${value}
                    </label>
                </li>`
            ).join('');

            $('#filterOptions').html(filterOptionsHtml);

            // Restore previous selections
            if (selectedFilters[selectedColumn]) {
                $('.filter-checkbox').each(function () {
                    if (selectedFilters[selectedColumn].includes($(this).val())) {
                        $(this).prop('checked', true);
                    }
                });
            }

            // Set "Select All" based on individual selections
            updateSelectAllCheckbox();

            // Show dropdown near the clicked filter
            var inputOffset = $(this).offset();
            $('#columnFilterDropdown').css({ top: inputOffset.top + 30, left: inputOffset.left }).show();
        });

        // Search filter inside the dropdown
        $('#filterSearch').on('keyup', function () {
            var searchText = $(this).val().toLowerCase();
            $('#filterOptions li').each(function () {
                var label = $(this).text().toLowerCase();
                $(this).toggle(label.includes(searchText));
            });
        });

        // Handle "Select All" checkbox
        $(document).on('change', '#selectAll', function () {
            $('.filter-checkbox').prop('checked', this.checked);
        });

        // Update "Select All" state when individual checkboxes change
        $(document).on('change', '.filter-checkbox', function () {
            updateSelectAllCheckbox();
        });

        function updateSelectAllCheckbox() {
            var allChecked = $('.filter-checkbox').length === $('.filter-checkbox:checked').length;
            $('#selectAll').prop('checked', allChecked);
        }

        // Apply filter and store selected checkboxes
        $('#applyFilter').on('click', function () {
            var selectedValues = $('.filter-checkbox:checked').map(function () {
                return $(this).val();
            }).get();

            // Save selected filters
            selectedFilters[selectedColumn] = selectedValues;

            table.draw(); // Redraw table with new filters
            $('#columnFilterDropdown').hide(); // Hide dropdown
        });

        // Custom filtering logic
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            for (var column in selectedFilters) {
                alert(selectedFilters[column].length);
                if (selectedFilters[column].length === 0) continue;

                var cellValue = data[column] || "";
                if (!selectedFilters[column].includes(cellValue)) return false;
            }
            return true;
        });

        // Hide dropdown when clicking outside
        $(document).on('click', function () {
            $('#columnFilterDropdown').hide();
        });

        $('#columnFilterDropdown').on('click', function (event) {
            event.stopPropagation();
        });
    });
</script>

<?php include './footer.php'; ?>

