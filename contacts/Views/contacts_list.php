<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts List</title>
    <link rel="stylesheet" href="../styling/bootstrap-5.3.3-dist/css/bootstrap.min.css">

</head>
<body>
<div class="container">
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <br>
     <nav aria-label="breadcrumb mt-5 mb-5">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?action=index">Home</a></li>
        <li class="breadcrumb-item"><a href="index.php?action=createContact">Register Contact</a></li>
        <li class="breadcrumb-item"><a href="index.php?action=linkExistingContact">Linked Contacts List</a></li>
        <li class="breadcrumb-item"><a href="index.php?action=manageContacts">Manage Contacts</a></li>
    </ol>
</nav>


</div>

 

<div class="container mt-5 content">
    <h1>Contacts List</h1>
    <?php if (!empty($contacts)) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Contact Full Name</th>
                    <th>Contact Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td class="text-left">
                            <?php echo htmlspecialchars($contact['contact_name'] ?? ''); ?>
                        </td>
                        <td class="text-left">
                            <?php echo htmlspecialchars($contact['contact_email'] ?? ''); ?>
                        </td>
                        <td class="text-left">
                            <?php if (isset($contact['client_id']) && !empty($contact['client_id'])): ?>
                                <form action="index.php?action=unlinkContact" method="POST">
                                    <input type="hidden" name="client_id" value="<?php echo htmlspecialchars($contact['client_id']); ?>">
                                    <input type="hidden" name="contact_id" value="<?php echo htmlspecialchars($contact['id']); ?>">
                                    <button type="submit" class="btn btn-danger">Unlink</button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">Not Linked</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No contacts found.</p>
    <?php endif; ?>
</div>

</body>
</html>
