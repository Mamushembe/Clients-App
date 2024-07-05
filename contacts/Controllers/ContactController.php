<?php
class ContactController {

    private $contactModel;

    public function __construct() {
        $this->contactModel = new ContactModel();
    }

    public function manageContacts() {
        $contacts = $this->contactModel->getAllContacts();
        include __DIR__ . '/../views/manage_contacts.php';
    }

    public function editContact() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $contactId = $_POST['id'];
            $contactName = $_POST['contact_name'];
            $contactEmail = $_POST['contact_email'];

            if ($this->contactModel->updateContact($contactId, $contactName, $contactEmail)) {
                $_SESSION['message'] = "Contact updated successfully.";
            } else {
                $_SESSION['message'] = "Failed to update contact.";
            }
            header("Location: index.php?action=manageContacts");
            exit();
        } else {
            $contactId = $_GET['id'];
            $contact = $this->contactModel->getContactById($contactId);
            include __DIR__ . '/../views/edit_contact.php';
        }
    }

    public function deleteContact() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $contactId = $_POST['id'];

            if ($this->contactModel->deleteContact($contactId)) {
                $_SESSION['message'] = "Contact deleted successfully.";
            } else {
                $_SESSION['message'] = "Failed to delete contact.";
            }
            header("Location: index.php?action=manageContacts");
            exit();
        }
    }

    public function unlinkClientFromContact() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $clientId = $_POST['client_id'];
            $contactId = $_POST['contact_id'];

            $this->contactModel->unlinkClientFromContact($clientId, $contactId);

            $_SESSION['message'] = 'Client unlinked from contact successfully';
            $_SESSION['message_type'] = 'success';

            header('Location: index.php?action=viewContacts');
            exit();
        }
    }
}
?>
