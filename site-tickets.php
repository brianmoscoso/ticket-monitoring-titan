<?php
include './header.php';
require_once './src/Database.php';

if (!isset($_GET['site']) || empty($_GET['site'])) {
    die("Invalid request. Site name is required.");
}

$site = $_GET['site'];

$db = Database::getInstance();
$query = "SELECT id, project, status, team_assigned, work_type, priority, schedule_date_from, schedule_date_to FROM ticket WHERE site_name = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $site);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container-fluid mt-4">
    <h3 class="text-center">Tickets for <?php echo htmlspecialchars($site); ?></h3>

    <input type="text" id="search-filter" class="form-control mb-3" placeholder="Search tickets...">

    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="ticketsTable">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Project</th>
                    <th>Status</th>
                    <th>Team Assigned</th>
                    <th>Activity</th>
                    <th>Priority</th>
                    <th>Schedule Range</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td>
                            <a href="ticket-details.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                                <?php echo htmlspecialchars($row['id']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($row['project']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['team_assigned']); ?></td>
                        <td><?php echo htmlspecialchars($row['work_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['priority']); ?></td>
                        <td><?php echo htmlspecialchars($row['schedule_date_from'] . ' to ' . $row['schedule_date_to']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <a href="sites.php" class="btn btn-secondary mt-3">Back</a>

<?php
// Re‑execute the same query to rebuild the dataset for the Gantt chart
$stmt->execute();
$result = $stmt->get_result();
$result->data_seek(0);

$categories = [
    'Pre-build' => ["site survey", "scope checking", "plant hire", "team submission", "material checking"],
    'Build' => [
        "RF prep works", "RF Build", "RF migration", "TX prep works",
        "TX link upgrade", "Comm CL", "RBS swap", "BBS install",
        "AC upgrade", "SWR installation"
    ],
    'Post-build' => ["HOPS", "LSP", "Alarm Testing", "Rubbish Disposal", "Decom material return","Call Testing"]
];

function getCategory($activity, $categories) {
    foreach ($categories as $category => $items) {
        if (in_array(strtolower($activity), array_map('strtolower', $items))) {
            return $category;
        }
    }
    return 'Uncategorized';
}

$categorizedTickets = [
    'Pre-build'   => [],
    'Build'       => [],
    'Post-build'  => [],
    'Uncategorized' => []
];

$uniqueRanges = [];

while ($row = $result->fetch_assoc()) {
    $category  = getCategory($row['work_type'], $categories);
    $start     = strtotime($row['schedule_date_from']);
    $end       = strtotime($row['schedule_date_to']);
    $rangeKey  = date('Y-m-d', $start) . '|' . date('Y-m-d', $end);

    $categorizedTickets[$category][] = [
        'activity'  => $row['work_type'],
        'start'     => $start,
        'end'       => $end,
        'rangeKey'  => $rangeKey
    ];

    if (!in_array($rangeKey, $uniqueRanges)) {
        $uniqueRanges[] = $rangeKey;
    }
}

// Sort the unique date‑range headers chronologically (by start date)
usort($uniqueRanges, function ($a, $b) {
    [$aStart] = explode('|', $a);
    [$bStart] = explode('|', $b);
    return strtotime($aStart) <=> strtotime($bStart);
});

// Sort each category's tickets chronologically (by start date)
foreach ($categorizedTickets as &$ticketGroup) {
    usort($ticketGroup, function ($a, $b) {
        return $a['start'] <=> $b['start'];
    });
}
unset($ticketGroup); // break the reference

?>

<style>
.gantt-wrapper {
    overflow-x: auto;
    overflow-y: auto;
    max-height: 60vh;
    border: 1px solid #ccc;
    margin-top: 20px;
}
.gantt-chart {
    display: grid;
    grid-template-columns: minmax(150px, 150px) repeat(<?= count($uniqueRanges) ?>, 1fr);
    width: fit-content;
    min-width: 100%;
    font-family: sans-serif;
}
.gantt-header, .gantt-label, .gantt-cell, .gantt-category {
    border: 1px solid #ccc;
    padding: 5px;
    text-align: center;
    white-space: nowrap;
}
.gantt-header {
    background: #003366;
    color: white;
    font-weight: bold;
    font-size: 0.75rem;
}
.gantt-label {
    background: #e9ecef;
    font-weight: bold;
    text-align: left;
    padding-left: 10px;
}
.gantt-cell {
    background-color: #f8f9fa;
    position: relative;
}
.gantt-bar {
    position: relative;
    height: 30px;
    background-color: #3498db;
    border-radius: 4px;
    width: 100%;
}
.gantt-category {
    background: #dee2e6;
    font-weight: bold;
    grid-column: span <?= count($uniqueRanges) + 1 ?>;
    text-align: left;
    padding-left: 10px;
}
</style>

<div class="gantt-wrapper">
    <h4 class="text-center">Gantt Chart by Activity for Site: <?= htmlspecialchars($site) ?></h4>
    <div class="gantt-chart">
        <!-- Header row -->
        <div class="gantt-header">Activity</div>
        <?php foreach ($uniqueRanges as $rangeKey): ?>
            <?php
                [$startStr, $endStr] = explode('|', $rangeKey);
                $label = date('M d', strtotime($startStr)) . (strtotime($startStr) != strtotime($endStr) ? ' – ' . date('M d', strtotime($endStr)) : '');
            ?>
            <div class="gantt-header"><?= $label ?></div>
        <?php endforeach; ?>

        <!-- Data rows, sorted by start date within each category -->
        <?php foreach (['Pre-build', 'Build', 'Post-build', 'Uncategorized'] as $category): ?>
            <?php if (!empty($categorizedTickets[$category])): ?>
                <div class="gantt-category">Category: <?= htmlspecialchars($category) ?></div>
                <?php foreach ($categorizedTickets[$category] as $ticket): ?>
                    <div class="gantt-label"><?= htmlspecialchars($ticket['activity']) ?></div>
                    <?php foreach ($uniqueRanges as $rangeKey): ?>
                        <div class="gantt-cell">
                            <?php if ($rangeKey === $ticket['rangeKey']): ?>
                                <div class="gantt-bar"></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
</div>

<?php include './footer.php'; ?>
