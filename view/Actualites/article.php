





<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");
if ($conn->connect_error) die("Erreur de connexion");

function time_elapsed_string($datetime) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->y > 0) return "il y a {$diff->y} " . ($diff->y > 1 ? "ans" : "an");
    if ($diff->m > 0) return "il y a {$diff->m} mois";
    if ($diff->d >= 7) return "il y a " . floor($diff->d / 7) . " semaine(s)";
    if ($diff->d > 0) return "il y a {$diff->d} jour(s)";
    if ($diff->h > 0) return "il y a {$diff->h}h" . ($diff->i > 0 ? $diff->i . "min" : "");
    if ($diff->i > 0) return "il y a {$diff->i} minute(s)";
    if ($diff->s > 30) return "il y a {$diff->s} secondes";
    return "à l’instant";
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM actualites1 WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $article = $result->fetch_assoc();
    } else {
        echo "Article introuvable.";
        exit;
    }
} else {
    echo "Identifiant manquant.";
    exit;
}

// Préparation pour partage
$titre = htmlspecialchars($article['titre']);
$contenu = strip_tags($article['contenu']);
$description = mb_strimwidth($contenu, 0, 140, '...');
$media = $article['media'];
$url = "http://localhost/Plateforme_web_du_FECACFOP/view/Actualites/article.php?id={$id}";
$type = $article['type_media'] === 'video' ? 'video.other' : 'article';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= $titre ?> - FECACFOP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Balises Open Graph / Partage -->
  <meta property="og:title" content="<?= $titre ?>" />
  <meta property="og:description" content="<?= $description ?>" />
  <meta property="og:image" content="<?= $media ?>" />
  <meta property="og:url" content="<?= $url ?>" />
  <meta property="og:type" content="<?= $type ?>" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= $titre ?>" />
  <meta name="twitter:description" content="<?= $description ?>" />
  <meta name="twitter:image" content="<?= $media ?>" />

  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f9f9f9;
    }

    .article-banner {
      height: 280px;
      background: url('<?= $media ?>') center/cover no-repeat;
      border-bottom: 4px solid #007BFF;
    }

    .article-main {
      max-width: 850px;
      margin: -60px auto 40px;
      background: #fff;
      padding: 40px;
      border-radius: 14px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.08);
      z-index: 2;
      position: relative;
    }

    .article-main h1 {
      font-size: 28px;
      color: #2c3e50;
      margin-bottom: 10px;
    }

    .article-meta {
      color: #777;
      font-size: 14px;
      margin-bottom: 20px;
    }

    .article-content {
      line-height: 1.8;
      font-size: 17px;
      text-align: justify;
      color: #333;
    }

    .share-bar {
      margin-top: 40px;
      display: flex;
      gap: 15px;
    }

    .share-bar a {
      color: #555;
      font-size: 22px;
      transition: transform 0.2s;
    }

    .share-bar a:hover {
      transform: scale(1.15);
    }
    .article-header {
  text-align: center;
  margin-top: 30px;
  margin-bottom: 30px;
}

.article-header-img {
  width: 100%;
  max-width: 700px;
  aspect-ratio: 16 / 9;
  object-fit: cover;
  border-radius: 12px;
  border: 3px solid #007BFF;
  box-shadow: 0 8px 18px rgba(0,0,0,0.08);
  margin: 0 auto;
  display: block;
  transition: transform 0.3s ease;
}

.article-header-img:hover {
  transform: scale(1.02);
}
.partage-flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 40px;
  flex-wrap: wrap;
  gap: 15px;
}

.share-icons a {
  color: #444;
  font-size: 22px;
  margin-right: 12px;
  transition: transform 0.2s;
}

.share-icons a:hover {
  transform: scale(1.2);
}

.site-link-opposite a {
  font-weight: 600;
  text-decoration: none;
  color: #007BFF;
  position: relative;
}


@keyframes shine {
  0% { background-position: 0% 0; }
  100% { background-position: 200% 0; }
}
.share-icons a .fa-whatsapp   { color: #25D366; }
.share-icons a .fa-facebook   { color: #1877F2; }
.share-icons a .fa-x-twitter  { color: #000000; }
.share-icons a .fa-linkedin   { color: #0077B5; }
.share-icons a .fa-envelope   { color: #D44638; }
.site-link-opposite a {
  font-weight: 600;
  color: #007BFF;
  text-decoration: none;
  animation: clignoteFlashy 1s infinite alternate;
  transition: color 0.3s;
}

@keyframes clignoteFlashy {
  0% {
    opacity: 1;
    text-shadow: 0 0 0 transparent;
  }
  100% {
    opacity: 0.7;
    text-shadow: 0 0 8px #33a1ff, 0 0 12px #33a1ff;
  }
}

.site-link-opposite a:hover {
  color: #0056b3;
  text-shadow: 0 0 10px #007BFF, 0 0 14px #007BFF;
}
@media screen and (max-width: 600px) {
  .article-main {
    padding: 20px;
    margin: 10px;
  }

  .article-main h1 {
    font-size: 22px;
    line-height: 1.3;
  }

  .article-header-img {
    max-width: 100%;
    aspect-ratio: 16 / 9;
  }

  .article-content {
    font-size: 16px;
    line-height: 1.6;
  }

  .partage-flex {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .site-link-opposite a {
    font-size: 16px;
    animation: clignoteFlashy 0.9s infinite alternate;
  }

  .share-icons a {
    font-size: 20px;
    margin-right: 10px;
  }
}


  </style>
</head>
<body>




  <div class="article-header">
  <?php if ($article['type_media'] === 'image'): ?>
    <img src="<?= $media ?>" alt="Image" class="article-header-img">
  <?php elseif ($article['type_media'] === 'video'): ?>
    <video controls class="article-header-img"><source src="<?= $media ?>" type="video/mp4"></video>
  <?php endif; ?>
</div>





  <div class="article-main">
    <h1><?= $titre ?></h1>
    <div class="article-meta">Publié <?= time_elapsed_string($article['date_publication']) ?></div>

    <div class="article-content">
      <?= nl2br(htmlspecialchars($article['contenu'])) ?>
    </div>
<div class="partage-flex">
  <div class="share-icons">
    <a href="https://wa.me/?text=<?= urlencode($url) ?>" title="WhatsApp" target="_blank"><i class="fab fa-whatsapp"></i></a>
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($url) ?>" title="Facebook" target="_blank"><i class="fab fa-facebook"></i></a>
    <a href="https://twitter.com/intent/tweet?url=<?= urlencode($url) ?>" title="X" target="_blank"><i class="fab fa-x-twitter"></i></a>
    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($url) ?>" title="LinkedIn" target="_blank"><i class="fab fa-linkedin"></i></a>
    <a href="mailto:?subject=<?= rawurlencode($titre) ?>&body=<?= rawurlencode($url) ?>" title="Email"><i class="fas fa-envelope"></i></a>
  </div>

  <div class="site-link-opposite">
    <a href="http://localhost/Plateforme_web_du_FECACFOP/public/index.php" class="visit-link">Visiter notre plateforme</a>
  </div>
</div>

</body>
</html>



