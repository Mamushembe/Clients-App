

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Client</title>
    <link rel="stylesheet" href="../styling/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <?php
            $action = $_GET['action'] ?? ''; // Assuming you handle action in create.php as well
            include __DIR__ . '/../includes/header.php';
        ?>
        <br>
        <nav aria-label="breadcrumb mt-5 mb-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?action=index">Home</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=viewClients">Clients List</a></li>
        </ol>
        </nav>

    </div>
    <div class="container mt-5">
        <h2>Create Client</h2>
        <form action="index.php?action=store" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="clientName" class="form-label">Name</label>
                <input type="text" class="form-control" id="clientName" name="name" required>
                <div class="invalid-feedback">
                    Please provide a client name.
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="../styling/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
