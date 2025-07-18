<?php
// Include necessary files
require_once './src/ticket.php';

// Check if the required POST data is present
if (isset($_POST['id']) && isset($_POST['status'])) {
    $ticketId = $_POST['id'];
    $status = $_POST['status'];

    try {
        // Find the ticket by its ID
        $ticket = Ticket::find($ticketId);

        // Check if the ticket exists
        if ($ticket) {
            // Update the ticket status
            $ticket->status = $status;

            // Update the ticket in the database
            $ticket->update($ticketId, ['status' => $status]);

            // Return a success response as JSON
            echo json_encode([
                'status' => 200,
                'msg' => 'Ticket status updated successfully'
            ]);
        } else {
            // Return an error response if the ticket doesn't exist
            echo json_encode([
                'status' => 400,
                'msg' => 'Ticket not found'
            ]);
        }
    } catch (Exception $e) {
        // Handle any errors during the update process
        echo json_encode([
            'status' => 500,
            'msg' => 'An error occurred: ' . $e->getMessage()
        ]);
    }
} else {
    // Return an error if the required parameters are not sent
    echo json_encode([
        'status' => 400,
        'msg' => 'Invalid data'
    ]);
}
?>
