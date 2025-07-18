<?php
  include './header.php';


  if(!isset($_GET['team-id']) || strlen($_GET['team-id']) < 1 || !ctype_digit($_GET['team-id'])){
    echo '<script> history.back()</script>';
    exit();
  }

  require_once './src/requester.php';
  require_once './src/user.php';
  require_once './src/team-member.php';

  


  $users = new User();
  $allusers = $users::findAll();



        $err = '';
        $msg = '';
       
        require_once './src/Database.php';

if (isset($_POST['submit'])) {
    $user = $_POST['id'];
    $teamid = $_GET['team-id'];

    if ($user == 'none') {
        $err = "Please select a user.";
    } else {
        // Get the database connection
        $pdo = Database::getInstance();
    
        // Fetch the user's name
        $stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
        $stmt->bind_param("i", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
    
        // Fetch the team name
        $stmt = $pdo->prepare("SELECT name FROM team WHERE id = ?");
        $stmt->bind_param("i", $teamid);
        $stmt->execute();
        $result = $stmt->get_result();
        $teamData = $result->fetch_assoc();
    
        if (!$userData) {
            $err = "User not found!";
        } elseif (!$teamData) {
            $err = "Team not found!";
        } else {
            $userName = $userData['name'];
            $teamName = $teamData['name'];
    
            // Check if the user is already assigned to a team
            $stmt = $pdo->prepare("SELECT users.name FROM team_member 
                                   JOIN users ON users.id = team_member.id 
                                   WHERE team_member.id = ?");
            $stmt->bind_param("i", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            $existingMember = $result->fetch_assoc();
    
            if ($existingMember) {
                $err = "User <strong>" . htmlspecialchars($existingMember['name']) . "</strong> is already assigned to a team!";
            } else {
                try {
                    // Insert user into team_member table
                    $stmt = $pdo->prepare("INSERT INTO team_member (id, name, team, team_name) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("isis", $user, $userName, $teamid, $teamName);
                    $stmt->execute();
                
                    // Update the user's team_id and team_name in users table
                    $stmt = $pdo->prepare("UPDATE users SET team_id = ?, team_name = ? WHERE id = ?");
                    $stmt->bind_param("isi", $teamid, $teamName, $user);
                    $stmt->execute();
                
                    $msg = "Member <strong>" . htmlspecialchars($userName) . "</strong> added to team <strong>" . htmlspecialchars($teamName) . "</strong> successfully!";
                } catch (Exception $e) {
                    $err = "Failed to add member.";
                }
            }
        }
    }
    
    
    
}

        

 
?>
<div id="content-wrapper">

    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Add New Member </li>
        </ol>

        <div class="card mb-3">
            <div class="card-header">
                <h3>Add a new member</h3>
            </div>
            <div class="card-body">
               <?php if(strlen($err) > 1) :?>
                <div class="alert alert-danger text-center my-3" role="alert"> <strong>Failed! </strong> <?php echo $err;?></div>
                <?php endif?>

                <?php if(strlen($msg) > 1) :?>
                <div class="alert alert-success text-center my-3" role="alert"> <strong>Success! </strong> <?php echo $msg;?></div>
                <?php endif?>
               
                <form method="POST" action="">
                   
                  
                    <div class="form-group row col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-sm-12">
                        <label for="name" class="col-sm-12 col-lg-2 col-md-2 col-form-label">User</label>
                        <div class="col-sm-8">
                            <select name="id" id="userSelect" class="form-control">
                                <option value="none">--select--</option>
                                <?php foreach($allusers as $user): ?>
                                    <option value="<?php echo $user->id; ?>"><?php echo htmlspecialchars($user->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-lg btn-primary"> Add</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <!-- Sticky Footer -->
    <!-- <footer class="sticky-footer">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright © Your Website 2019</span>
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

<!-- jQuery (Ensure only one version is included) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('#userSelect').select2({
            placeholder: "Search for an available user",
            allowClear: true,
            width: '100%'
        });
    });
</script>


</body>

</html>