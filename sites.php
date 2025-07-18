<?php
include './header.php';
require_once './src/sites.php';
require_once './src/Database.php';

$sites = Sites::findAll();
?>

<div id="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Site</a>
      </li>
      <li class="breadcrumb-item active">Overview</li>
    </ol>

    <a class="btn btn-primary my-3" href="./newsite.php"><i class="fa fa-plus"></i> New Site</a>

    <div class="card mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Created at</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($sites as $site): ?>
                <tr>
                  <td><?php echo htmlspecialchars($site->site_name); ?></td>
                  <td><?php echo (new DateTime($site->created_at))->format('d-m-Y H:i:s'); ?></td>
                  <td>
                  <a href="site-tickets.php?site=<?php echo urlencode($site->site_name); ?>" class="btn btn-info">
                      View Tickets
                  </a>

                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Ticket Details Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ticketModalLabel">Site Tickets</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="ticketModalBody">
        Loading...
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap & DataTables Scripts -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Notifications Script -->
<script src="js/notifications.js"></script>

<script>
  $(document).ready(function() {
      $("#dataTable").DataTable();

      // Event delegation for dynamic elements
      $(document).on("click", ".view-tickets", function() {
          let siteName = $(this).data("site");

          fetch("get-site-tickets.php?site=" + encodeURIComponent(siteName))
              .then(response => {
                  if (!response.ok) throw new Error("Network error");
                  return response.json();
              })
              .then(data => {
                  let ticketList = `<h5>Tickets for ${siteName}</h5><ul>`;
                  
                  if (data.tickets && data.tickets.length > 0) {
                      data.tickets.forEach(ticket => {
                          ticketList += `<li>
                              <strong>${ticket.project}</strong> - ${ticket.status} 
                              (Assigned: ${ticket.team_assigned}, Priority: ${ticket.priority})
                          </li>`;
                      });
                  } else {
                      ticketList += "<li>No tickets found.</li>";
                  }
                  ticketList += "</ul>";

                  $("#ticketModalBody").html(ticketList);
                  $("#ticketModal").modal("show");
              })
              .catch(error => {
                  console.error("Error fetching tickets:", error);
                  $("#ticketModalBody").html("<p class='text-danger'>Failed to load tickets.</p>");
              });
      });
  });
</script>

</body>
</html>
