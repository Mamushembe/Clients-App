<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel="stylesheet" href="../styling/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <?php include 'includes/header.php'; ?>

    <br>
    <nav aria-label="breadcrumb mt-5 mb-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?action=index">Home</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=viewClients">Clients List</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=create">Register Client</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=manageClients">Manage Clients</a></li>
        </ol>
        </nav>
</div>
    
<div class="container mt-5">
    <h2>Edit Client</h2>
    <form action="index.php?action=editClient" method="POST">
        <div class="form-group">
            <label for="name">Client Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($client['name']); ?>" required>
        </div>
        <input type="hidden" name="client_id" value="<?php echo $client['id']; ?>">
        <br>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
