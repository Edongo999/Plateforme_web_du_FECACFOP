<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");



if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        if ($diff->y > 0) {
            return "il y a " . $diff->y . " " . ($diff->y > 1 ? "ans" : "an");
        } elseif ($diff->m > 0) {
            return "il y a " . $diff->m . " mois";
        } elseif ($diff->d >= 7) {
            $weeks = floor($diff->d / 7);
            return "il y a " . $weeks . " semaine" . ($weeks > 1 ? "s" : "");
        } elseif ($diff->d > 0) {
            return "il y a " . $diff->d . " jour" . ($diff->d > 1 ? "s" : "");
        } elseif ($diff->h > 0) {
            return "il y a " . $diff->h . "h" . ($diff->i > 0 ? $diff->i . "min" : "");
        } elseif ($diff->i > 0) {
            return "il y a " . $diff->i . " minute" . ($diff->i > 1 ? "s" : "");
        } elseif ($diff->s > 30) {
            return "il y a " . $diff->s . " secondes";
        } else {
            return "à l’instant";
        }
    }
}

$sql = "SELECT * FROM actualites1 WHERE type_media = 'video' ORDER BY date_publication DESC";
$result = $conn->query($sql);
?>
<?php include_once '../header.php'; ?>
<div class="container-title">  
    <h6>Actualités & Nouvelles de la Plateforme</h6>  
    <p class="description">Explorez les dernières annonces, nouveautés techniques et événements marquants du FECACFOP</p>  
</div>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Actualités - Lire plus</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
          .actualite-unique-scope .actualites {
        background: #f9f9f9;
        padding: 40px 20px;
        max-width: 1200px;
        margin: 40px auto;
        border-radius: 14px;
        border: 1px solid #ddd;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
      }

  
    .actualite-unique-scope .actualite-card {
        background: #fff;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        
        border-radius: 10px;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        align-items: flex-start;
         flex-wrap: wrap;
       align-items: stretch;
 
    }
        .actualite-unique-scope .actualite-media {
      width: 100%;
      max-width: 200px;
      height: auto;
      border-radius: 12px;
      object-fit: cover;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      border: 3px solid #f2f2f2
      flex-shrink: 0;
    }
    .actualite-unique-scope .actualite-content {
        flex: 1;
    }
    .actualite-unique-scope .actualite-titre {
        font-size: 20px;
        margin: 0 0 10px;
        color: #007bff;
    }
    .actualite-unique-scope .actualite-description {
        margin: 0 0 15px;
    }
    .actualite-unique-scope .btn-details-view,
    .actualite-unique-scope .btn-share-toggle {
        background: #007bff;
        border: none;
        color: white;
        padding: 8px 15px;
        cursor: pointer;
        border-radius: 5px;
        font-weight: bold;
        margin-right: 8px;
    }
    .actualite-unique-scope .btn-details-view:hover,
    .actualite-unique-scope .btn-share-toggle:hover {
        background: #0056b3;
    }
    .actualite-unique-scope .share-container {
        position: relative;
        display: inline-block;
        margin-top: 10px;
    }
    .actualite-unique-scope .share-icons {
        display: none;
        position: absolute;
        top: 42px;
        left: 0;
        background: white;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 6px 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        gap: 10px;
        z-index: 100;
    }
    .actualite-unique-scope .share-icons a i {
        font-size: 20px;
        transition: transform 0.2s;
    }
    .actualite-unique-scope .share-icons a i:hover {
        transform: scale(1.3);
    }
  .actualite-unique-scope .custom-modal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.actualite-unique-scope #modal-description {
  text-align: justify;
  white-space: pre-wrap;
  line-height: 1.9;
  font-size: 17px;
  letter-spacing: 0.1px;
  padding: 16px;
  max-height: 320px;
  overflow-y: auto;
  border: 1px solid #eee;
  background: #fafafa;
  border-radius: 6px;
}

    .actualite-unique-scope #modal-title {
  font-size: 22px;
  font-weight: 600;
  color: #007bff;
  margin-bottom: 15px;
  word-break: break-word;
  line-height: 1.4;
  text-align: center;
}

    .actualite-unique-scope .custom-modal-content {
        background: white;
        padding: 20px;
        max-width: 600px;
        width: 90%;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        text-align: center;
        max-height: 90vh;
        overflow-y: auto;
    }
    .actualite-unique-scope #modal-media img,
    .actualite-unique-scope #modal-media video {
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
        margin-bottom: 15px;
    }
    .actualite-unique-scope #modal-description {
       
        line-height: 1.6;
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
        text-align: justify;
    }
    .actualite-unique-scope .custom-modal-close-btn {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 8px 12px;
        margin-top: 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    @media (max-width: 600px) {
        .actualite-unique-scope .actualite-card {
            flex-direction: column;
            align-items: flex-start;
        }
        .actualite-unique-scope .actualite-media {
            width: 100%;
            max-height: 150px;
        }
        .actualite-unique-scope .share-icons {
            flex-direction: column;
            right: 0;
            left: auto;
        }
        .actualite-unique-scope .custom-modal-content {
            padding: 15px;
            max-height: 90vh;
        }
        .actualite-unique-scope #modal-description {
            max-height: 250px;
            font-size: 14px;
        }
    }
    .actualite-unique-scope .date-publiee {
  font-size: 13px;
  color: #888;
  margin: 6px 0;
}
.fade-up-on-scroll {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

.fade-up-on-scroll.visible {
  opacity: 1;
  transform: translateY(0);
}

.media-wrapper {
  position: relative;
  display: inline-block;
  cursor: zoom-in;
}

.overlay-icon {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 32px;
  color: rgba(255, 255, 255, 0.9);
  opacity: 0;
  transition: opacity 0.3s ease;
  pointer-events: none;
}

.media-wrapper:hover .overlay-icon {
  opacity: 1;
}

#image-modal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.7);
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

#image-modal img {
  max-width: 95%;
  max-height: 90vh;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
  </style>
</head>
<body>

<div class="actualite-unique-scope">
  <div class="actualites">
    <?php
    $conn = new mysqli("localhost", "root", "", "rapcefop");
   $sql = "SELECT * FROM actualites1 WHERE type_media = 'video' ORDER BY date_publication DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $titre = htmlspecialchars($row['titre'], ENT_QUOTES);
            $contenu = htmlspecialchars($row['contenu'], ENT_QUOTES);
            $media = htmlspecialchars($row['media'], ENT_QUOTES);
            $type = htmlspecialchars($row['type_media'], ENT_QUOTES);
            $url = "http://localhost/Plateforme_web_du_FECACFOP/view/Actualites/article.php?id={$id}";
            echo "<div class='actualite-card fade-up-on-scroll'>";
            if ($type === 'image') {
            echo "<div class='media-wrapper' onclick=\"openImageModal('{$media}')\">";
            echo "<img src='{$media}' class='actualite-media' alt='Image actualité'>";
            echo "<div class='overlay-icon'><i class='fas fa-search-plus'></i></div>";
            echo "</div>";
            } elseif ($type === 'video') {
                echo "<video controls class='actualite-media'><source src='{$media}' type='video/mp4'></video>";
            }
            echo "<div class='actualite-content'>";
           
            echo "<h2 class='actualite-titre'>{$titre}</h2>";
            echo "<p class='date-publiee'>Publié " . time_elapsed_string($row['date_publication']) . "</p>";

            echo "<p class='actualite-description'>" . substr($contenu, 0, 100) . "...</p>";

            echo "<button class='btn-details-view' 
                    data-title=\"{$titre}\"
                    data-description=\"{$contenu}\"
                    data-media=\"{$media}\"
                    data-type=\"{$type}\"
                    onclick=\"handleModalClick(this)\">Lire plus</button>";

            echo "<div class='share-container'>
                    <button class='btn-share-toggle' onclick='toggleShare(this)'>
                        <i class='fas fa-share-alt'></i> Partager
                    </button>
                    <div class='share-icons'>
                        <a href='https://wa.me/?text=" . urlencode($url) . "' target='_blank' title='WhatsApp'><i class='fab fa-whatsapp' style='color:#25D366;'></i></a>
                        <a href='https://www.facebook.com/sharer/sharer.php?u=" . urlencode($url) . "' target='_blank' title='Facebook'><i class='fab fa-facebook' style='color:#1877F2;'></i></a>
                        <a href='https://twitter.com/intent/tweet?url=" . urlencode($url) . "' target='_blank' title='X'><i class='fab fa-x-twitter' style='color:#000;'></i></a>
                        <a href='https://www.linkedin.com/sharing/share-offsite/?url=" . urlencode($url) . "' target='_blank' title='LinkedIn'><i class='fab fa-linkedin' style='color:#0077B5;'></i></a>
                        <a href='mailto:?subject=Article%20intéressant&body=" . urlencode($url) . "' target='_blank' title='Email'><i class='fas fa-envelope' style='color:#D44638;'></i></a>
                    </div>
                  </div>";

            echo "</div></div>";
        }
    } else {
        echo "<p>Aucune actualité disponible.</p>";
    }
    ?>
  </div>


  <div id="modal" class="custom-modal">
      <div class="custom-modal-content">
          <div id="modal-media"></div>
          <h2 id="modal-title"></h2>
          <p id="modal-description"></p>
          <button class="custom-modal-close-btn" onclick="close
                    closeModal()">Fermer</button>
      </div>
  </div>

  <script>
  function handleModalClick(button) {
      const title = button.dataset.title;
      const description = button.dataset.description;
      const media = button.dataset.media;
      const type = button.dataset.type;
      openModal(title, description, media, type);
  }

  function openModal(title, description, media, type) {
      const modal = document.getElementById('modal');
      const modalTitle = document.getElementById('modal-title');
      const modalDescription = document.getElementById('modal-description');
      const modalMedia = document.getElementById('modal-media');

      modalTitle.textContent = title;
      modalDescription.innerHTML = description
        .split(/(?<=\.)\s+/)  // découpe après chaque point et espace
        .map(phrase => `<p>${phrase.trim()}</p>`)
        .join('');

      
      modalMedia.innerHTML = '';

      if (type === 'image') {
          modalMedia.innerHTML = `<img src="${media}" alt="Image">`;
      } else if (type === 'video') {
          modalMedia.innerHTML = `<video controls style="max-width:100%;"><source src="${media}" type="video/mp4"></video>`;
      }

      modal.style.display = 'flex';
  }

  function closeModal() {
      document.getElementById('modal').style.display = 'none';
  }

  function toggleShare(button) {
      const icons = button.nextElementSibling;
      icons.style.display = (icons.style.display === 'none' || icons.style.display === '') ? 'flex' : 'none';
  }
  document.addEventListener('click', function (e) {
  document.querySelectorAll('.share-icons').forEach(function (menu) {
    const toggle = menu.previousElementSibling;
    if (!menu.contains(e.target) && !toggle.contains(e.target)) {
      menu.style.display = 'none';
    }
  });
});

  </script>
  <script>
  const cards = document.querySelectorAll('.fade-up-on-scroll');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, {
    threshold: 0.1
  });

  cards.forEach(card => {
    observer.observe(card);
  });
</script>




  <div class="footer-separator-unique"></div>
  <footer id="footer-unique" class="footer-unique">
      <?php include_once '../footer.php'; ?>
      <?php include_once '../script_site.php'; ?>
  </footer>
</div> <!-- Fin de .actualite-unique-scope -->
</body>
</html>
