<?php
session_start();
require_once './src/Database.php';
$db = Database::getInstance();

$err = '';

/* --------------------------------------------------------------
   Handle form submit
-------------------------------------------------------------- */
if (isset($_POST['submit'])) {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password']   ?? '';

    /* Basic validation */
    if ($email === '')                  $err = 'Please enter an email address';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
                                        $err = 'Please enter a valid email address';
    elseif ($password === '')           $err = 'Please enter your password';
    else {

        /* One query: user + (optional) team name */
        $stmt = $db->prepare("
            SELECT u.id, u.name, u.email, u.password, u.role, u.team_id,
                   t.name AS team_name
            FROM   users u
            LEFT JOIN team t ON t.id = u.team_id
            WHERE  u.email = ?
            LIMIT  1
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_object();

        if (!$user) {
            $err = "No user found";
        } else {

            /* --------------------------------------------------
               1) Modern bcrypt verify
               2) Legacy MD5 or plaintext verify (if still stored)
            -------------------------------------------------- */
            $storedHash = trim($user->password);      // strip possible padding

            $isValid =
                   password_verify($password, $storedHash)               // new style
                || md5($password) === $storedHash                         // legacy md5
                || $password === $storedHash;                             // legacy plaintext

            if ($isValid) {

                /* If user logged in with a legacy hash/plaintext → upgrade */
                if (!password_verify($password, $storedHash)) {
                    $newHash = password_hash($password, PASSWORD_BCRYPT);
                    $upd = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $upd->bind_param("si", $newHash, $user->id);
                    $upd->execute();
                }

                /* Set session data */
                $_SESSION['logged-in'] = true;
                $_SESSION['user']      = $user;
                $_SESSION['user_id']   = $user->id;
                $_SESSION['role']      = $user->role;
                $_SESSION['team_id']   = $user->team_id ?? null;
                $_SESSION['team_name'] = $user->team_name ?? 'No Team Assigned';

                header('Location: ./dashboard.php');
                exit();

            } else {
                $err = "Wrong email or password";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Titan – Login</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="css/sb-admin.css" rel="stylesheet">
</head>
<body class="bg-dark">

<div class="container">
  <div class="card card-login mx-auto mt-5">
    <div class="card-header text-center">
      <img src="./images/titan4_logo.jpg" alt="Logo" style="width:300px">
      <h4 class="font-weight-bold mt-2">Login</h4>
    </div>

    <div class="card-body">
      <form method="POST" action="">
        <div class="form-group">
          <label>Email address</label>
          <input type="email" name="email" class="form-control" placeholder="Email address" autofocus required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
      </form>

      <?php if ($err): ?>
        <div class="alert alert-danger text-center mt-3"><strong>Failed! </strong><?= $err ?></div>
      <?php endif ?>
    </div>
  </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
