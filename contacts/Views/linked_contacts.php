<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linked Contacts</title>
    <link rel="stylesheet" href="../styling/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <?php include 'includes/header.php'; ?>
    </div>
    
    <div class="container mt-5">
        <h2>Linked Contacts for <?php echo htmlspecialchars($client['name']); ?></h2>
        <?php if (empty($contacts)): ?>
            <p>No linked contact(s) found.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-left">Contact Full Name</th>
                        <th class="text-left">Contact Email</th>
                        <th class="text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td class="text-left"><?php echo htmlspecialchars($contact['contact_name']); ?></td>
                            <td class="text-left"><?php echo htmlspecialchars($contact['contact_email']); ?></td>
                            <td class="text-left">
                                <a href="index.php?action=editContact&contact_id=<?php echo $contact['id']; ?>" class="btn btn-primary">Edit</a>
                                <form action="index.php?action=deleteContact&contact_id=<?php echo $contact['id']; ?>" method="post" style="display: inline;">
                                    <input type="hidden" name="client_id" value="<?php echo $client['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
