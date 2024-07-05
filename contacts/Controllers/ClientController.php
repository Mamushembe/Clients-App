<?php
class ClientController {
    private $db;
    private $clientModel;

    public function __construct($db) {
        $this->db = $db;
        $this->clientModel = new Client($db);
    }

    public function index() {
        include __DIR__ . '/../views/index.php';
    }

    public function create() {
        include __DIR__ . '/../views/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $clientName = $_POST['name'] ?? '';

            if (empty($clientName)) {
                echo "Client Name is required.";
                return;
            }

            $clientCode = $this->generateClientCode($clientName);

            if ($this->clientModel->create($clientName, $clientCode)) {
                $_SESSION['message'] = "Client created successfully.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to create client.";
                $_SESSION['message_type'] = "danger";
            }
            header('Location: index.php?action=viewClients');
            exit();
        } else {
            $this->create();
        }
    }

    private function generateClientCode($clientName) {
        $words = explode(' ', $clientName);
        $alphaPart = '';

        foreach ($words as $word) {
            $alphaPart .= strtoupper($word[0]);
            if (strlen($alphaPart) >= 3) {
                break;
            }
        }

        if (strlen($alphaPart) < 3) {
            $alphaPart = str_pad($alphaPart, 3, 'A');
        }

        $numericPart = str_pad($this->clientModel->getNextClientCodeNumber($alphaPart), 3, '0', STR_PAD_LEFT);
        return $alphaPart . $numericPart;
    }

    public function linkContacts() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $clientName = $_POST['client_name'] ?? '';
            $contactName = $_POST['contact_name'] ?? '';
            $contactEmail = $_POST['contact_email'] ?? '';
            $actionLink = $_POST['action_link'] ?? '';

            if (empty($clientName) || empty($contactName) || empty($contactEmail) || empty($actionLink)) {
                $_SESSION['message'] = "All fields are required.";
                $_SESSION['message_type'] = "danger";
                header('Location: index.php?action=viewClients');
                exit();
            }

            if ($this->clientModel->linkContact($clientName, $contactName, $contactEmail, $actionLink)) {
                $_SESSION['message'] = "Contact '{$contactName}' linked successfully to client '{$clientName}'.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to link contact.";
                $_SESSION['message_type'] = "danger";
            }
            header('Location: index.php?action=viewClients');
            exit();
        } else {
            include __DIR__ . '/../views/link_contacts.php';
        }
    }

    public function viewClients() {
        $query = "SELECT clients.*, COUNT(client_contacts.contact_id) AS linked_contacts 
                  FROM clients
                  LEFT JOIN client_contacts ON clients.id = client_contacts.client_id
                  GROUP BY clients.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $clients = [];
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }

        $contactsQuery = "SELECT id, contact_name FROM contacts";
        $contactsStmt = $this->db->prepare($contactsQuery);
        $contactsStmt->execute();
        $contactsResult = $contactsStmt->get_result();

        $allContacts = [];
        while ($contactRow = $contactsResult->fetch_assoc()) {
            $allContacts[] = $contactRow;
        }

        include __DIR__ . '/../views/clients_list.php';
    }

    public function linkContact() {
        if (isset($_POST['client_id']) && isset($_POST['contact_id'])) {
            $clientId = $_POST['client_id'];
            $contactId = $_POST['contact_id'];

            if ($this->clientModel->linkContactToClient($clientId, $contactId)) {
                header("Location: index.php?action=viewClients");
            } else {
                echo "Error linking contact.";
            }
        } else {
            echo "Client ID and Contact ID are required.";
        }
    }

    public function unlinkContact() {
        if (isset($_POST['client_id']) && isset($_POST['contact_id'])) {
            $clientId = $_POST['client_id'];
            $contactId = $_POST['contact_id'];

            $query = "DELETE FROM client_contacts WHERE client_id = ? AND contact_id = ?";
            $stmt = $this->db->prepare($query);

            if ($stmt === false) {
                throw new Exception("Error preparing statement: " . $this->db->error);
            }

            $stmt->bind_param('ii', $clientId, $contactId);
            $stmt->execute();

            header("Location: index.php?action=viewContacts");
            exit();
        }
    }

    public function viewContacts() {
        try {
            $contactsQuery = "SELECT * FROM contacts";
            $contactsStmt = $this->db->prepare($contactsQuery);
            $contactsStmt->execute();
            $contactsResult = $contactsStmt->get_result();
            $contacts = [];

            while ($contact = $contactsResult->fetch_assoc()) {
                $clientId = null;

                $linkedQuery = "SELECT client_id FROM client_contacts WHERE contact_id = ?";
                $linkedStmt = $this->db->prepare($linkedQuery);
                $linkedStmt->bind_param('i', $contact['id']);
                $linkedStmt->execute();
                $linkedStmt->bind_result($clientId);
                $linkedStmt->fetch();
                $linkedStmt->close();

                $contact['client_id'] = $clientId;
                $contacts[] = $contact;
            }

            include __DIR__ . '/../views/contacts_list.php';
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function linkExistingContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientId = $_POST['client_id'];
            $contactId = $_POST['contact_id'];
            $this->clientModel->linkContactToClient($clientId, $contactId);
        }
        $this->viewContacts();
    }

    public function createContact() {
        include 'views/create_contact.php';
    }

    public function storeContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactName = $_POST['contactName'] ?? '';
            $contactEmail = $_POST['contactEmail'] ?? '';

            if (empty($contactName) || empty($contactEmail)) {
                $_SESSION['message'] = "Contact Name and Email are required.";
                $_SESSION['message_type'] = "danger";
                header("Location: create_contact.php");
                exit();
            }

            if ($this->clientModel->createContact($contactName, $contactEmail)) {
                $_SESSION['message'] = "Contact created successfully.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to create contact.";
                $_SESSION['message_type'] = "danger";
            }

            header("Location: index.php?action=viewContacts");
            exit();
        } else {
            header("Location: create_contact.php");
            exit();
        }
    }

    public function getContacts() {
        $query = "
            SELECT c.id, c.full_name as contact_name, c.email as contact_email, cc.client_id 
            FROM contacts c
            LEFT JOIN client_contacts cc ON c.id = cc.contact_id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $contacts = [];
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }

        return $contacts;
    }

    public function manageClients() {
        $clients = $this->clientModel->getAllClients();
        include __DIR__ . '/../views/manage_clients.php';
    }

    public function editClient() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $clientId = $_POST['client_id'];
            $clientName = $_POST['name'];

            if (empty($clientName)) {
                echo "Client Name is required.";
                return;
            }

            if ($this->clientModel->updateClientName($clientId, $clientName)) {
                echo "Client updated successfully.";
            } else {
                echo "Failed to update client.";
            }
            header("Location: index.php?action=manageClients");
            exit();
        } else {
            $clientId = $_GET['id'];
            $client = $this->clientModel->getClientById($clientId);
            include __DIR__ . '/../views/edit_client.php';
        }
    }

    public function deleteClient() {
        if (isset($_POST['client_id'])) {
            $clientId = $_POST['client_id'];

            if ($this->clientModel->deleteClient($clientId)) {
                echo "Client deleted successfully.";
            } else {
                echo "Failed to delete client.";
            }
            header("Location: index.php?action=manageClients");
            exit();
        }
    }
}
?>
