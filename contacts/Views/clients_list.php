<?php
if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo htmlspecialchars($_SESSION['message_type']); ?> alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients List</title>
    <link rel="stylesheet" href="../styling/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <?php include __DIR__ . '/../includes/header.php'; ?>
        <br>
        
        <nav aria-label="breadcrumb mt-5 mb-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?action=index">Home</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=create">Register Client</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=manageClients">Manage Clients</a></li>
        </ol>
        </nav>

        <div class="container mt-5">
            <h2>Clients List</h2>
            <?php if (empty($clients)): ?>
                <p>No client(s) found.</p>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left">Name</th>
                            <th class="text-left">Client Code</th>
                            <th class="text-center">No. of Linked Contacts</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client): ?>
                            <tr>
                                <td class="text-left"><?php echo htmlspecialchars($client['name']); ?></td>
                                <td class="text-left"><?php echo htmlspecialchars($client['client_code']); ?></td>
                                <td class="text-center"><?php echo (int)$client['linked_contacts']; ?></td>
                                <td>
                                    <form action="index.php?action=linkContact" method="post">
                                        <input type="hidden" name="client_id" value="<?php echo $client['id']; ?>">
                                        <select name="contact_id">
                                            <?php foreach ($allContacts as $contact) : ?>
                                                <option value="<?php echo $contact['id']; ?>"><?php echo htmlspecialchars($contact['contact_name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary">Link Contact</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
