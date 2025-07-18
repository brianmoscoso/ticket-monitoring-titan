<?php
class Sites{
    
    public $id = null;
    
    public $site_name = '';

    public $color = '';


    public function __construct($data = null) 
    {
        $this->site_name = isset($data['site_name']) ? $data['site_name'] : null;
        $this->color = isset($data['color']) ? $data['color'] : null; 

        $this->db = Database::getInstance();
        
        if (!$this->db) {
            throw new Exception("Database connection failed");
        }
    }

    public function save(): ?Sites 
    {
        $sql = "INSERT INTO sites (site_name,color) VALUES (?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $this->site_name, $this->color);

        if (!$stmt->execute()) {
            throw new Exception("Error inserting site: " . $stmt->error);
        }

        $id = $this->db->getInsertId();
        return self::find($id);
    }

    public static function find($id) : Sites
    {
        $sql ="SELECT * FROM sites WHERE id = '$id'";
        $self = new static;
        $res = $self->db->query($sql);
        if($res->num_rows < 1) return false;
        $self->populateObject($res->fetch_object());
        return $self;
    }

    public static function findAll() : array
    {
        $sql = "SELECT * FROM sites ORDER BY id DESC";
        $sites = [];
        $self = new static;
        $res = $self->db->query($sql);
        
        if ($res->num_rows < 1) return []; // Fix: Return an empty array instead of new static

        while ($row = $res->fetch_object()) {
            $site = new static;
            $site->populateObject($row);
            $sites[] = $site;
        }

        return $sites;
    }

    public static function delete($id) : bool 
    {
        $sql = "DELETE FROM sites WHERE id = '$id'";
        $self = new static;
        return $self->db->query($sql);
    }

    public function populateObject($object) : void 
    {

        foreach($object as $key => $property){
            $this->$key = $property;
        }
    }



    
}