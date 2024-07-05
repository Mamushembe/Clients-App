<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
    <link rel="stylesheet" href="../styling/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php include 'includes/header.php'; ?>

   <br>
     <nav aria-label="breadcrumb mt-5 mb-5">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?action=index">Home</a></li>
        <li class="breadcrumb-item"><a href="index.php?action=createContact">Register Contact</a></li>
        <li class="breadcrumb-item"><a href="index.php?action=linkExistingContact">Linked Contacts List</a></li>
        <li class="breadcrumb-item"><a href="index.php?action=manageContacts">Manage Contacts</a></li>
    </ol>
</nav>

    <br>
    <h2>Edit Contact</h2>
    <form action="index.php?action=editContact" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($contact['id']); ?>">
        <div class="form-group">
            <label for="contactName">Contact Name</label>
            <input type="text" class="form-control" id="contactName" name="contact_name" value="<?php echo htmlspecialchars($contact['contact_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="contactEmail">Contact Email</label>
            <input type="email" class="form-control" id="contactEmail" name="contact_email" value="<?php echo htmlspecialchars($contact['contact_email']); ?>" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
