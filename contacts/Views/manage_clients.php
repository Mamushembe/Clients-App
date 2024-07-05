<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Clients</title>
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
        </ol>
        </nav>
</div>

<div class="container mt-5">
    <h2>Manage Clients</h2>
    <?php if (empty($clients)): ?>
        <p>No client(s) found.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-left">Client Name</th>
                    <th class="text-left">Client Code</th>
                    <th class="text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td class="text-left"><?php echo htmlspecialchars($client['name']); ?></td>
                        <td class="text-left"><?php echo htmlspecialchars($client['client_code']); ?></td>
                        <td class="text-left">
                            <a href="index.php?action=editClient&id=<?php echo $client['id']; ?>" class="btn btn-primary">Edit</a>
                            <form action="index.php?action=deleteClient" method="POST" style="display:inline;">
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
