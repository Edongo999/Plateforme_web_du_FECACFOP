<?php
session_start();
$conn = new mysqli("localhost", "root", "", "rapcefop");
if ($conn->connect_error) die("Erreur DB");

$logs = $conn->query("SELECT * FROM login_logs ORDER BY date_connexion DESC");

function nbEchecs($conn, $ip) {
  $stmt = $conn->prepare("SELECT COUNT(*) FROM login_logs WHERE ip_address = ? AND statut = 'échec' AND date_connexion > (NOW() - INTERVAL 15 MINUTE)");
  $stmt->bind_param("s", $ip);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  return $count;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Admin - Tentatives de connexion</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
  <style>
    body {
      background: #f5f7fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
    }
    h2.journal-title {
  text-align: center;
  font-size: 1.9em;
  font-weight: 700;
  color: #005BAC;
  margin-bottom: 30px;
  letter-spacing: 0.5px;
  border-bottom: 1px solid #ccc;
  padding-bottom: 12px;
  position: relative;
}

h2::before {
  content: "🛡️";
  position: absolute;
  left: 0;
  top: 0;
  font-size: 1.1em;
  color: #0072cc;
}

    h2 {
      text-align: center;
  font-size: 1.9em;
  font-weight: 700;
  color: #005BAC;
  margin-bottom: 30px;
  letter-spacing: 0.5px;
  border-bottom: 1px solid #ccc;
  padding-bottom: 12px;
  position: relative;
    }
    .table thead th {
      background: #e9f0f7;
      color: #333;
      font-weight: 500;
    }
    .status-success {
      color: #198754;
      font-weight: 500;
    }
    .status-fail {
      color: #d63384;
      font-weight: 500;
    }
    .badge {
      font-size: 0.85em;
    }
    .table tbody tr:hover {
      background-color: #f2f8ff;
    }
  </style>
</head>
<body class="p-4">
  <div class="container">
    <div class="card">
      <h2><i class="bi bi-shield-lock"></i> Journal des connexions</h2>
      <p class="text-muted mb-4">Liste des tentatives de connexion enregistrées ces dernières heures. Les IP bloquées peuvent être débloquées manuellement si nécessaire.</p>

      <table class="table table-bordered table-hover">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Utilisateur</th>
            <th>IP</th>
            <th>Statut</th>
            <th>Navigateur</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $seen_ips = [];
        $count = 1;
        while ($row = $logs->fetch_assoc()) :
          $ip = $row['ip_address'];
          $echecs = nbEchecs($conn, $ip);
          if (!in_array($ip, $seen_ips)) {
            $seen_ips[] = $ip;
        ?>
        <tr>
          <td><?= $count++ ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><code><?= $ip ?></code></td>
          <td>
            <span class="<?= $row['statut'] === 'succès' ? 'badge bg-success' : 'badge bg-danger' ?>">
              <?= ucfirst($row['statut']) ?>
            </span>
          </td>
          <td><?= substr($row['navigateur'], 0, 30) ?>…</td>
          <td><?= $row['date_connexion'] ?></td>
          <td>
            <?php if ($echecs >= 5): ?>
              <a href="debloquer_ip.php?ip=<?= urlencode($ip) ?>" class="btn btn-sm btn-danger">
                Débloquer
              </a>
            <?php else: ?>
              <span class="badge bg-secondary">✓</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php } endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
