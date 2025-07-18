<?php
    include './header.php';
   
    require_once './src/team.php';

     $teams = Team::findAll();
  
   //print_r($teams);die();

   require_once __DIR__ . '/src/Database.php';




?>
<div id="content-wrapper">

  <div class="container-fluid">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Team</a>
      </li>
      <li class="breadcrumb-item active">Overview</li>
    </ol>
    <a class="btn btn-primary my-3" href="./newteam.php"><i class="fa fa-plus"></i> New Team</a>
    <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        

                            <tr>
                                <th>Name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($teams as $team):?>
                            <tr>
                                <td><?php echo $team->name ?></td>
                                <?php $date = new DateTime($team->created_at)?>
                                <td><?php echo $date->format('d-m-Y H:i:s')?> </td>
                                <td width="100px">
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button"
                                                class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <a class="dropdown-item" href="./add-team-member.php?team-id=<?php echo $team->id ?>">Add Member</a>
                                                <a class="dropdown-item" href="./team-members.php?team-id=<?php echo $team->id ?>">View Members</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Notifications Script -->
<!--<script src="js/notifications.js"></script>-->

<!-- Demo scripts for this page-->
<script src="js/demo/datatables-demo.js"></script>
<script src="js/demo/chart-area-demo.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var teamFilter = document.getElementById("teamFilter");
    $(document).ready(function () {
    $('.dropdown-toggle').dropdown(); // Ensure dropdown initializes
  });
    function loadTeams() {
        fetch("get-teams.php") // Ensure this returns pure JSON
            .then(response => response.json())
            .then(teams => {
                teamFilter.innerHTML = '<option value="">All Teams</option>'; // Reset dropdown
                teams.forEach(team => {
                    let option = document.createElement("option");
                    option.value = team.name;
                    option.textContent = team.name;
                    teamFilter.appendChild(option);
                });
            })
            .catch(error => console.error("Error loading teams:", error));
    }

    loadTeams(); // Call function to populate the dropdown
});



</script>


</body>

</html>