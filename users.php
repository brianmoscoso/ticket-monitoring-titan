<?php
include './header.php';
require_once './src/user.php';

/* ------------------------------------------------------------------
   1.  Who’s logged‑in and are they an admin?
------------------------------------------------------------------ */
$currentUserId = $_SESSION['user_id'] ?? 0;
$isAdmin       = ($_SESSION['role'] ?? '') === 'admin';

/* ------------------------------------------------------------------
   2.  Get all users for the table
------------------------------------------------------------------ */
$users = User::findAll();
?>

<div id="content-wrapper">
  <div class="container-fluid">

    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Users</a></li>
      <li class="breadcrumb-item active">Overview</li>
    </ol>

    <?php if ($isAdmin): ?>
      <a class="btn btn-primary my-3" href="newuser.php">
        <i class="fa fa-plus"></i> Create New User
      </a>
    <?php endif; ?>

    <div class="card mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Team</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created at</th>
                <th width="160">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
              <tr>
                <td><?= htmlspecialchars($u->name) ?></td>
                <td><?= htmlspecialchars($u->role) ?></td>
                <td><?= htmlspecialchars($u->team_name ?? '—') ?></td>
                <td><?= htmlspecialchars($u->email) ?></td>
                <td><?= htmlspecialchars($u->phone) ?></td>
                <td><?= (new DateTime($u->created_at))->format('d-m-Y H:i:s') ?></td>

                <!-- ========== ACTION COLUMN ========== -->
                <td>
                  <?php if ($u->id == $currentUserId): ?>
                      <!-- Logged‑in user can change own password -->
                      <a href="change-password.php" class="btn btn-sm btn-secondary">
                          Change My PW
                      </a>
                  <?php elseif ($isAdmin): ?>
                      <!-- Admin sees a Reset button for *other* accounts -->
                      <a href="reset-password.php?uid=<?= $u->id ?>"
                         class="btn btn-sm btn-warning"
                         onclick="return confirm('Reset password for <?= htmlspecialchars($u->name) ?> to &quot;Titan2025!&quot;?');">
                         Reset PW
                      </a>
                  <?php else: ?>
                      <!-- Non‑admin, not self → no action -->
                      —
                  <?php endif; ?>
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

<?php include './footer.php'; ?>
