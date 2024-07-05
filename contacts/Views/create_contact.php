<!-- create_contact.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Create Contact</title>
    <link rel="stylesheet" href="../styling/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <?php include 'includes/header.php'; ?>
    </div>
    <div class="container">
        

    <h2>Create a New Contact</h2>
    <form action="index.php?action=storeContact" method="POST">
        <div class="form-group">
            <label for="contactName">Contact Name</label>
            <input type="text" class="form-control" id="contactName" name="contactName" required>
        </div>
        <div class="form-group">
            <label for="contactEmail">Contact Email</label>
            <input type="email" class="form-control" id="contactEmail" name="contactEmail" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
