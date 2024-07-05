<?php
require_once __DIR__ . '/autoload.php';

// Initialize the database connection
$database = new Database();
$db = $database->getConnection();

// Initialize controllers
$clientController = new ClientController($db);
$contactController = new ContactController();

// Determine action
$action = $_GET['action'] ?? 'index';

// Routing for client actions
switch ($action) {
    case 'store':
        $clientController->store();
        break;
    case 'create':
        $clientController->create();
        break;
    case 'viewClients':
        $clientController->viewClients();
        break;
    case 'linkContacts':
        $clientController->linkContacts();
        break;
    case 'linkContact':
        $clientController->linkContact();
        break;
    case 'unlinkContact':
        $clientController->unlinkContact();
        break;
    case 'viewContacts':
        $clientController->viewContacts();
        break;
    case 'createContact':
        $clientController->createContact();
        break;
    case 'storeContact':
        $clientController->storeContact();
        break;
    case 'linkExistingContact':
        $clientController->linkExistingContact();
        break;
    case 'manageClients':
        $clientController->manageClients();
        break;
    case 'editClient':
        $clientController->editClient();
        break;
    case 'deleteClient':
        $clientController->deleteClient();
        break;
    default:
        $clientController->index();
        break;

        // 
    case 'manageContacts':
        $contactController->manageContacts();
        break;
    case 'editContact':
        $contactController->editContact();
        break;
    case 'deleteContact':
        $contactController->deleteContact();
        break;
    case 'unlinkClientFromContact':
        $contactController->unlinkClientFromContact();
        break;

}
?>
