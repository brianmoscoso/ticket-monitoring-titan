<?php
    include './header.php';
    require_once './src/ticket.php';
    require_once './src/requester.php';
    require_once './src/team.php';

    $ticket = new Ticket();

    $allTicket = $ticket::findAll();

    $requester = new Requester();
    $team = new Team();

     // ✅ Fetch all teams properly
     $teams = Team::findAll();

     if (isset($_GET['del'])) {
         $id = $_GET['del'];
         try {
             $ticket->delete($id);
             echo '<script>alert("Ticket deleted successfully");window.location = "./dashboard.php"</script>';
         } catch (Exception $e) {
             echo $e->getMessage();
         }
     }
  
  

?>

<style>
  .fc-event img {
    width: 30px !important;  /* Even smaller */
    height: 30px !important; /* Even smaller */
    vertical-align: middle;
    margin-right: 4px;
}
#legend {
    margin-top: 20px;
    padding: 10px;
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.legend-row {
    display: flex;
    flex-wrap: wrap; /* Allows wrapping if too many items */
    gap: 15px; /* Space between items */
    justify-content: center;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

.legend-item img {
    width: 50px; /* Smaller icons */
    height: 50px;
}



  #calendar-container {
    position: relative;
    width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
  }
  
  #calendar {
    min-width: 600px; /* Ensures horizontal scrolling if needed */
  }
  
  @media (max-width: 768px) {
    .fc-toolbar {
      flex-direction: column;
    }
    .fc-toolbar .fc-left, .fc-toolbar .fc-right {
      display: flex;
      justify-content: center;
      margin-bottom: 5px;
    }
  }
  
</style>

<div id="content-wrapper">

<div class="container-fluid">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Overview</li>
  </ol>

  <a class="btn btn-primary my-3" href="./ticket.php"><i class="fa fa-plus"></i> New Ticket</a>
  
  <div class="row">
    <div class="col-lg-12">
      <div id="legend"></div>
      <div>
        <!-- <label for="teamFilter">Filter by Team:</label>
          <select id="teamFilter">
              <option value="">All Teams</option>
                <?php foreach ($teams as $team): ?>
              <option value="<?php echo htmlspecialchars($team->name); ?>">
                <?php echo htmlspecialchars($team->name); ?>
              </option>
                <?php endforeach; ?>
          </select> -->
      </div>
      
      
      
   
      <!-- Calendar Section -->
      
        
          <h5>Calendar View</h5>
          <div id="calendar"></div> 
        
      


    </div>
  </div>
</div>

  <!-- /.container-fluid -->

  <!-- Sticky Footer -->
  <!-- <footer class="sticky-footer">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span></span>
      </div>
    </div>
  </footer> -->

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


<!-- Bootstrap core JavaScript -->
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Notifications Script -->
<!--<script src="js/notifications.js"></script>-->


<!-- FullCalendar Initialization  -->
<script>
        document.addEventListener("DOMContentLoaded", function () {
            var calendarEl = document.getElementById("calendar");

            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: "dayGridMonth",
                    height: "auto",
                    contentHeight: 500,
                    headerToolbar: {
                        left: "prev,next today",
                        center: "title",
                        right: "dayGridMonth,timeGridWeek,timeGridDay"
                    },
                    editable: true,
                    eventStartEditable: true,
                    eventDurationEditable: false,
                    events: [
    <?php foreach ($allTicket as $ticket): ?>
    {
        id: "<?php echo $ticket->id; ?>",
        title: "<?php echo addslashes($ticket->site_name); ?>",
        start: "<?php echo date('Y-m-d', strtotime($ticket->schedule_date)); ?>",
        backgroundColor: "<?php echo !empty($ticket->site_color) ? $ticket->site_color : '#000000'; ?>", // Default to black if empty
        borderColor: "<?php echo !empty($ticket->site_color) ? $ticket->site_color : '#000000'; ?>",
        extendedProps: {
            work_type: "<?php echo addslashes($ticket->work_type); ?>",
            schedule_date_from: "<?php echo date('Y-m-d', strtotime($ticket->schedule_date_from)); ?>",
            schedule_date_to: "<?php echo date('Y-m-d', strtotime($ticket->schedule_date_to)); ?>",
            team: "<?php echo addslashes($ticket->team); ?>",
            status: "<?php echo addslashes($ticket->status); ?>"
        }
    },
    <?php endforeach; ?>
],

                    eventContent: function (arg) {
                          let workTypes = arg.event.extendedProps.work_type.split(","); // Assume work types are comma-separated
                          let imgHtml = "";

                          // Define work type to icon mapping
                          const workTypeImages = {
                              "HOPS": "./icons/HOPS.png",
                              "Link Upgrade": "./icons/TX_link_upgrade.png",
                              "Link Rectification": "./icons/Link_rectification.png",
                              "Comm CL": "./icons/comm_cl.png",
                              "SWR installation": "./icons/swr_installation.png",
                              "RBS Swap": "./icons/rbs_swap.png",
                              "BBS Install": "./icons/bbs_installation.png",
                              "SWEEP testing": "./icons/sweep_testing.png",
                              "AC upgrade": "./icons/ac_upgrade.png"
                          };

                          // Generate icons for each work type
                          workTypes.forEach(type => {
                              type = type.trim(); // Remove any extra spaces
                              if (workTypeImages[type]) {
                                  imgHtml += `<img src="${workTypeImages[type]}" alt="${type}" class="small-icon"> `;
                              }
                          });

                          return { html: imgHtml + " " + arg.event.title };
                      },

                    eventDrop: function (info) {
                        var ticketId = info.event.id;
                        var newStartDate = info.event.startStr;
                        var oldStartDate = info.event.extendedProps ? info.event.extendedProps.schedule_date_from : null;
                        var oldEndDate = info.event.extendedProps ? info.event.extendedProps.schedule_date_to : null;

                        console.log("Dragging ticket ID:", ticketId);
                        console.log("Old Start Date:", oldStartDate);
                        console.log("Old End Date:", oldEndDate);
                        console.log("New Start Date:", newStartDate);

                        if (!ticketId || !newStartDate || !oldStartDate || !oldEndDate) {
                            console.error("❌ Missing old start or end date");
                            alert("Error: Missing old start or end date.");
                            info.revert();
                            return;
                        }

                        var oldStart = new Date(oldStartDate);
                        var oldEnd = new Date(oldEndDate);
                        var newStart = new Date(newStartDate);
                        var daysDifference = Math.round((oldEnd - oldStart) / (1000 * 60 * 60 * 24));

                        var newEndDate = new Date(newStart);
                        newEndDate.setDate(newEndDate.getDate() + daysDifference);
                        var formattedEndDate = newEndDate.toISOString().split("T")[0];

                        console.log("New End Date:", formattedEndDate);

                        fetch("update-ticket-date.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({
                                id: ticketId,
                                new_date_from: newStartDate,
                                new_date_to: formattedEndDate
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Server Response:", data);
                            if (data.success) {
                                alert("✅ Ticket date updated successfully.");
                            } else {
                                alert("⚠️ Failed to update ticket: " + data.error);
                                info.revert();
                            }
                        })
                        .catch(error => {
                            console.error("AJAX Error:", error);
                            alert("❌ An error occurred while updating the ticket.");
                            info.revert();
                        });
                    },

                    eventClick: function (info) {
                        window.location.href = "ticket-details.php?id=" + info.event.id;
                    }
                });

                calendar.render();
            } else {
                console.error("Calendar element not found.");
            }
        });


        document.addEventListener("DOMContentLoaded", function () {
    var workTypeImages = {
        "HOPS": "./icons/HOPS.png",
        "Link Upgrade": "./icons/TX_link_upgrade.png",
        "Link Rectification": "./icons/Link_rectification.png",
        "Comm CL": "./icons/comm_cl.png",
        "SWR installation": "./icons/swr_installation.png",
        "RBS Swap": "./icons/rbs_swap.png",
        "BBS Install": "./icons/bbs_installation.png",
        "SWEEP testing": "./icons/sweep_testing.png",
        "AC upgrade": "./icons/ac_upgrade.png"
    };

    // Generate the legend dynamically
    var legendContainer = document.getElementById("legend");
    if (legendContainer) {
        let legendHtml = "<h3>Work Type Legend</h3><div class='legend-row'>";
        for (let workType in workTypeImages) {
            legendHtml += `
                <div class="legend-item">
                    <img src="${workTypeImages[workType]}" class="small-icon"> 
                    <span>${workType}</span>
                </div>
            `;
        }
        legendHtml += "</div>";
        legendContainer.innerHTML = legendHtml;
    }
});

    </script>


</body>

</html>