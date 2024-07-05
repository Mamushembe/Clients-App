<?php
class Client {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($clientName, $clientCode) {
        $stmt = $this->db->prepare("INSERT INTO clients (name, client_code) VALUES (?, ?)");
        if (!$stmt) {
            echo "Prepare failed: (" . $this->db->errno . ") " . $this->db->error;
            return false;
        }
        $stmt->bind_param("ss", $clientName, $clientCode);
        $result = $stmt->execute();
        if (!$result) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
        $stmt->close();
        return true;
    }
public function getNextClientCodeNumber($alphaPart) {
    $maxCode = null; // Initialize $maxCode to null

    $stmt = $this->db->prepare("SELECT MAX(client_code) AS max_code FROM clients WHERE client_code LIKE ?");
    $likePattern = $alphaPart . '%';
    $stmt->bind_param("s", $likePattern);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $maxCode = $row['max_code'];
    }

    $stmt->close();

    if ($maxCode !== null) {
        $numericPart = (int) substr($maxCode, 3);
        return $numericPart + 1;
    }
    return 1;
}


    public function linkContact($clientName, $contactName, $contactEmail, $actionLink) {
        $stmt = $this->db->prepare("INSERT INTO contacts (client_name, contact_name, contact_email, action_link) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            echo "Prepare failed: (" . $this->db->errno . ") " . $this->db->error;
            return false;
        }
        $stmt->bind_param("ssss", $clientName, $contactName, $contactEmail, $actionLink);
        $result = $stmt->execute();
        if (!$result) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
        $stmt->close();
        return true;
    }

    public function getClientById($clientId) {
        $stmt = $this->db->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        $result = $stmt->get_result();
        $client = $result->fetch_assoc();
        $stmt->close();
        return $client;
    }

    public function getLinkedContacts($clientId) {
        $query = "SELECT contacts.id, contacts.contact_name FROM contacts 
                  JOIN client_contacts ON contacts.id = client_contacts.contact_id 
                  WHERE client_contacts.client_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        $result = $stmt->get_result();

        $contacts = [];
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
        return $contacts;
    }

    public function getAllClients() {
        $query = "SELECT c.id, c.name, c.client_code, COUNT(ct.id) as linked_contacts 
                  FROM clients c
                  LEFT JOIN client_contacts cc ON c.id = cc.client_id
                  GROUP BY c.id, c.name, c.client_code
                  ORDER BY c.name ASC";
        $result = $this->db->query($query);

        $clients = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $clients[] = $row;
            }
        }
        return $clients;
    }

    public function createContact($contactName, $contactEmail) {
        $stmt = $this->db->prepare("INSERT INTO contacts (contact_name, contact_email) VALUES (?, ?)");
        if (!$stmt) {
            echo "Prepare failed: (" . $this->db->errno . ") " . $this->db->error;
            return false;
        }
        $stmt->bind_param("ss", $contactName, $contactEmail);
        $result = $stmt->execute();
        if (!$result) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
        $stmt->close();
        return $this->db->insert_id;
    }

    public function linkContactToClient($clientId, $contactId) {
        $stmt = $this->db->prepare("INSERT INTO client_contacts (client_id, contact_id) VALUES (?, ?)");
        if (!$stmt) {
            echo "Prepare failed: (" . $this->db->errno . ") " . $this->db->error;
            return false;
        }
        $stmt->bind_param("ii", $clientId, $contactId);
        $result = $stmt->execute();
        if (!$result) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
        $stmt->close();
        return true;
    }

    public function unlinkContactFromClient($clientId, $contactId) {
        $stmt = $this->db->prepare("DELETE FROM client_contacts WHERE client_id = ? AND contact_id = ?");
        if (!$stmt) {
            echo "Prepare failed: (" . $this->db->errno . ") " . $this->db->error;
            return false;
        }
        $stmt->bind_param("ii", $clientId, $contactId);
        $result = $stmt->execute();
        if (!$result) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
        $stmt->close();
        return true;
    }

    public function updateClientName($id, $name) {
        $query = "UPDATE clients SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $name, $id);
        return $stmt->execute();
    }

    public function deleteClient($id) {
        $query = "DELETE FROM clients WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getLinkedClients($contactId) {
        $query = "SELECT c.* FROM clients c 
                  JOIN client_contacts cc ON c.id = cc.client_id 
                  WHERE cc.contact_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $contactId);
        $stmt->execute();
        $result = $stmt->get_result();

        $clients = [];
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }

        return $clients;
    }
}
?>
