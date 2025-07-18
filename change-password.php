<?php
/* ------------------------------------------------------------------
   BOOTSTRAP & AUTH
------------------------------------------------------------------ */
include './header.php';
require_once './src/user.php';


$loggedId   = $_SESSION['user_id'] ?? 0;
$loggedRole = $_SESSION['role']    ?? '';

if (!$loggedId) {
    header('Location: login.php');
    exit;
}

$isAdmin   = ($loggedRole === 'admin');

/* ------------------------------------------------------------------
   TARGET USER (self or ?uid=## for admins)
------------------------------------------------------------------ */
$targetId = $isAdmin && isset($_GET['uid'])  // admin can manage others
          ? (int)$_GET['uid']
          : $loggedId;                       // non‑admin → always self

$target = User::find($targetId);
if (!$target) die('User not found.');

/* ------------------------------------------------------------------
   HANDLE FORM SUBMIT / ADMIN QUICK‑RESET
------------------------------------------------------------------ */
$ok = false;  $err = '';

/* Admin “quick reset” via  /change-password.php?uid=##&reset=1 */
if ($isAdmin && isset($_GET['reset']) && $_GET['reset'] == 1) {
    if (User::adminReset($targetId)) {
        $ok = true;
    } else {
        $err = 'Reset failed.';
    }
}
/* Normal form post (self or admin custom pw) */
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['old_password']     ?? '';
    $new = $_POST['new_password']     ?? '';
    $rep = $_POST['confirm_password'] ?? '';

    if ($new !== $rep)          $err = 'Passwords do not match.';
    elseif (strlen($new) < 6)   $err = 'Password must be ≥ 6 chars.';
    else {
        if ($isAdmin && $targetId !== $loggedId) {
            /* Admin changing someone else → no old‑pw check */
            $ok = User::updatePassword($targetId, $new);
            if (!$ok) $err = 'Update failed.';
        } else {
            /* Regular self‑service */
            $ok = User::changeOwnPassword($loggedId, $old, $new);
            if (!$ok) $err = 'Current password incorrect.';
        }
    }
}
?>
<!‑‑ ============================ VIEW ============================ ‑‑>
<div class="container mt-4" style="max-width:420px">
  <h3>
    Change Password –
    <?= htmlspecialchars(($targetId === $loggedId) ? 'My Account' : $target->name) ?>
  </h3>

  <?php if ($ok): ?>
      <div class="alert alert-success">
        <?php if (isset($_GET['reset'])): ?>
            Password reset to default <strong>password</strong>.
        <?php else: ?>
            Password updated.
        <?php endif; ?>
      </div>
  <?php elseif ($err): ?>
      <div class="alert alert-danger"><?= $err ?></div>
  <?php endif; ?>

  <!-- Self‑change OR admin custom change form -->
  <form method="post" action="change-password.php?uid=<?= $targetId ?>">
      <?php if (!$isAdmin || $targetId === $loggedId): ?>
          <!-- Regular users (or admin changing own) must supply old pw -->
          <div class="form-group">
              <label>Current Password</label>
              <input type="password" name="old_password" class="form-control" required>
          </div>
      <?php endif; ?>

      <div class="form-group">
          <label>New Password</label>
          <input type="password" name="new_password" class="form-control" required>
      </div>
      <div class="form-group">
          <label>Confirm New Password</label>
          <input type="password" name="confirm_password" class="form-control" required>
      </div>
      <button class="btn btn-primary">Update Password</button>
      <?php if ($isAdmin && $targetId !== $loggedId): ?>
          <a href="change-password.php?uid=<?= $targetId ?>&reset=1"
             class="btn btn-warning ml-2"
             onclick="return confirm('Reset password for <?= htmlspecialchars($target->name) ?> to default &quot;password&quot;?');">
             Reset to “password”
          </a>
      <?php endif; ?>
  </form>
</div>

<?php include './footer.php'; ?>
