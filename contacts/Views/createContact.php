<!DOCTYPE html>
<html>
<head>
    <title>Create Contact</title>
    <link rel="stylesheet" type="text/css" href="path/to/your/css/styles.css">
</head>
<body>
<div class="container">
    <?php include __DIR__ . '/../includes/header.php'; ?>
</div>

<h1>Create Contact</h1>
<form action="index.php?action=createContact" method="post">
    <div class="form-group">
        <label for="contact_name">Contact Name</label>
        <input type="text" class="form-control" id="contact_name" name="contact_name" required>
    </div>
    <div class="form-group">
        <label for="contact_email">Contact Email</label>
        <input type="email" class="form-control" id="contact_email" name="contact_email" required>
    </div>
    <button type="submit" class="btn btn-primary">Create Contact</button>
</form>


</body>
</html>
