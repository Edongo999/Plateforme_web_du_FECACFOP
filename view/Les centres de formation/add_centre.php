<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Centre</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center text-primary">Ajouter un Centre de Formation</h2>
            <form action="traitement.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nom du Centre :</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email :</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Spécialité :</label>
                    <input type="text" name="specialite" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Logo du Centre :</label>
                    <input type="file" name="logo" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ajouter</button>
            </form>
        </div>
    </div>
</body>
</html>
