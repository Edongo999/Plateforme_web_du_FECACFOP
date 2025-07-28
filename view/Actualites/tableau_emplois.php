<?php
$conn = new mysqli("localhost", "root", "", "rapcefop");
$result = $conn->query("SELECT * FROM emplois WHERE archived = 0"); // Exclure les offres archivées
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['titre']}</td>
            <td>
                <span class='short-text'>" . htmlspecialchars(substr($row['description'], 0, 30)) . "...</span>
                <button class='btn-lire-plus' onclick='openModal(\"" . htmlspecialchars($row['description']) . "\")'>Lire plus</button>
            </td>
            <td class='media-container'>";
    if (pathinfo($row['media'], PATHINFO_EXTENSION) == "mp4") {
        echo "<video controls>
                <source src='{$row['media']}' type='video/mp4'>
              </video>";
    } else {
        echo "<img src='{$row['media']}' alt='Image'>";
    }
    echo "</td>
            <td>{$row['date_publication']}</td>
            <td>
                <div style='display: flex; justify-content: center; gap: 10px;'>
                    <a href='modifier_emploi.php?id={$row['id']}' class='btn btn-edit'>Modifier</a>
                    <a href='javascript:void(0)' class='btn btn-archive' onclick='archiveEmploi({$row['id']})'>Archiver</a>
                </div>
            </td>
        </tr>";
}
$conn->close();
?>
