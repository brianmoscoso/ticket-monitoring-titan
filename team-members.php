<?php
include './header.php';
require_once './src/Database.php';
require_once './src/team.php';

if (!isset($_GET['team-id'])) {
    die("No team selected.");
}

$teamId = $_GET['team-id'];
$team = Team::findById($teamId); // Fetch team details
$members = Team::findMembers($teamId); // Fetch team members


if (!$team) {
    die("Team not found.");
}

?>

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="team.php">Teams</a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($team->name); ?> Members</li>
        </ol>
        <h2><?php echo htmlspecialchars($team->name); ?> Members</h2>
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($members)): ?>
                                <?php foreach ($members as $member): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($member->name ?? 'Unknown'); ?></td>
                                        <td><?php echo htmlspecialchars($member->email ?? 'No Email'); ?></td>
                                        <td><?php echo htmlspecialchars($member->role ?? 'No Role'); ?></td>
                                        <td width="100px">
                                            <form action="delete-team-member.php" method="POST" onsubmit="return confirm('Are you sure?')">
                                                <input type="hidden" name="team_id" value="<?php echo $teamId; ?>">
                                                <input type="hidden" name="member_id" value="<?php echo $member->id ?? ''; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4">No members found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './footer.php'; ?>
