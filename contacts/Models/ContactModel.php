<?php
class ContactModel {
    private $db;

    public function __construct() {
        // Initialize your database connection here
        $this->db = new mysqli('localhost', 'root', '', 'Clients');
    }

    public function getAllContacts() {
        $query = "SELECT * FROM contacts";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getContactById($id) {
        $query = "SELECT * FROM contacts WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateContact($id, $name, $email) {
        $query = "UPDATE contacts SET contact_name = ?, contact_email = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssi', $name, $email, $id);
        return $stmt->execute();
    }

    public function deleteContact($id) {
        $query = "DELETE FROM contacts WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function unlinkClientFromContact($clientId, $contactId) {
        $query = "DELETE FROM client_contacts WHERE client_id = ? AND contact_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $clientId, $contactId);
        return $stmt->execute();
    }
}
?>
