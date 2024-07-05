<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contacts</title>
    <link rel="stylesheet" href="../styling/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php include 'includes/header.php'; ?>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info">
            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

     <br>
     <nav aria-label="breadcrumb mt-5 mb-5">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?action=index">Home</a></li>
        <li class="breadcrumb-item"><a href="index.php?action=createContact">Register Contact</a></li>
        <li class="breadcrumb-item"><a href="index.php?action=linkExistingContact">Linked Contacts List</a></li>
    </ol>
</nav>

    <h2>Manage Contacts</h2>
    <?php if (empty($contacts)): ?>
        <p>No contact(s) found.</p>
    <?php else: ?>
        <table class="table table-striped">
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
                        <td><?php echo htmlspecialchars($contact['contact_name']); ?></td>
                        <td><?php echo htmlspecialchars($contact['contact_email']); ?></td>
                        <td>
                            <a href="index.php?action=editContact&id=<?php echo $contact['id']; ?>" class="btn btn-warning">Edit</a>
                            <form action="index.php?action=deleteContact" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
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
