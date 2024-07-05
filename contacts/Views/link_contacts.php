<!DOCTYPE html>
<html>
<head>
    <title>Link Contact</title>
    <link rel="stylesheet" type="text/css" href="path/to/your/css/styles.css">
</head>
<body>
<div class="ciontainer">
    <?php include __DIR__ . '/../includes/header.php'; ?>
</div>

<h1>Link Existing Contact</h1>
<form action="index.php?action=linkExistingContact" method="POST">
    <label for="client_id">Client:</label>
    <select id="client_id" name="client_id">
        <?php foreach ($clients as $client): ?>
            <option value="<?php echo $client['id']; ?>"><?php echo htmlspecialchars($client['name']); ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <label for="contact_id">Contact:</label>
    <select id="contact_id" name="contact_id">
        <?php foreach ($contacts as $contact): ?>
            <option value="<?php echo $contact['id']; ?>"><?php echo htmlspecialchars($contact['full_name']); ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <button type="submit">Link Contact</button>
</form>
<?php include 'includes/footer.php'; ?>
</body>
</html>
