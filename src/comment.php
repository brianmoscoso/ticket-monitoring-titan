<?php
require_once __DIR__ . '/Database.php'; // Ensure the correct path

class Comment {
    public $id;
    public $ticket; 
    public $team_member;
    public $body;
    public $created_at;
    public $author; // Ensure author exists
    public $screenshot_path; // ✅ Add screenshot_path property

    private $db;

    public function __construct($data = null) {
        $this->db = Database::getInstance();

        if ($data) {
            $this->ticket = $data['ticket'] ?? null;
            $this->team_member = $data['team_member'] ?? null;
            $this->body = $data['body'] ?? null;
            $this->screenshot_path = $data['screenshot_path'] ?? null; // ✅ Ensure it's initialized
        }
    }

    public static function findById($id) {
        $db = Database::getInstance(); // ✅ Use your Database class
        $sql = "SELECT * FROM comments WHERE id = ?";
        $stmt = $db->prepare($sql);
    
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $db->getError()); // ✅ Debugging
        }
    
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    
        if ($result->num_rows < 1) {
            return null;
        }
    
        $comment = new Comment();
        $comment->populateObject($result->fetch_object());
    
        return $comment;
    }
    public function update(): bool {
        if (!$this->id) {
            throw new Exception("Comment ID is NULL in Update");
        }
    
        $sql = "UPDATE comments SET body = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->db->getError());
        }
    
        $stmt->bind_param("si", $this->body, $this->id);
        $result = $stmt->execute();
        $stmt->close();
    
        return $result;
    }

    public static function deleteById($id): bool {
        $db = Database::getInstance();
        $sql = "DELETE FROM comments WHERE id = ?";
        $stmt = $db->prepare($sql);
    
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $db->getError());
        }
    
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
    
        return $result;
    }

    public static function searchByTicket($ticketId, $query) {
        $db = Database::getInstance();
        $sql = "SELECT c.*, tm.name AS author 
                FROM comments c
                LEFT JOIN team_member tm ON c.team_member = tm.id
                WHERE c.ticket = ? AND c.body LIKE ?";
    
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            return [];
        }
    
        $searchQuery = "%" . $query . "%";
        $stmt->bind_param("is", $ticketId, $searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    
        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $row["screenshot_path"] = $row["screenshot_path"] ?? null; // Ensure it's included
            $comments[] = $row;
        }
    
        return $comments;
    }
    
    
    
    

    public function save(): Comment {
        if (!$this->ticket) {
            throw new Exception("Ticket ID is NULL in Comment: " . json_encode($this));
        }
    
        // ✅ Get team member's name
        $member_name = $this->getTeamMemberName($this->team_member);
    
        $sql = "INSERT INTO comments (ticket, team_member, team_member_name, body, screenshot_path) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("issss", $this->ticket, $this->team_member, $member_name, $this->body, $this->screenshot_path);
        
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
    
        $id = $stmt->insert_id;
        $stmt->close();
    
        return self::find($id);
    }
    
    

    public static function find($id): ?Comment {
        $db = Database::getInstance();
        $sql = "SELECT * FROM comments WHERE id = ?";
        $stmt = $db->prepare($sql);
    
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $db->error);
        }
    
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    
        if ($result->num_rows < 1) {
            return null;
        }
    
        $comment = new Comment();
        $comment->populateObject($result->fetch_object());
    
        return $comment;
    }
    

    public function populateObject($object): void {
        foreach ($object as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function findByTicket($id): array {
        $db = Database::getInstance();
        $sql = "SELECT c.*, tm.name AS author 
            FROM comments c
            LEFT JOIN team_member tm ON c.team_member = tm.id
            WHERE c.ticket = ?";

    
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $db->error);
        }
    
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    
        $comments = [];
        while ($row = $result->fetch_object()) {
            $comment = new Comment();
            $comment->populateObject($row);
            $comment->author = $row->author ?? 'Unknown';
            $comment->screenshot_path = $row->screenshot_path ?? null; // ✅ Ensure screenshot_path is included
            $comments[] = $comment;
        }
    
        return $comments;
    }
    

    private function getTeamMemberName($team_member_id): string {
        $sql = "SELECT name FROM team_member WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $team_member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    
        if ($row = $result->fetch_assoc()) {
            return $row['name'];
        }
        
        return 'Unknown'; // Default value if not found
    }
    
}
