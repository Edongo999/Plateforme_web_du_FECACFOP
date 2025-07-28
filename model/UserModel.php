<?php

class UserModel {
  private $conn;

  public function __construct($db) {
    $this->conn = $db;
  }

  public function getByUsername($username) {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  public function updateProfile($oldUsername, $newUsername, $email, $password = null, $photo = null) {
    $sql = "UPDATE users SET username=?, email=?";
    $params = [$newUsername, $email];
    $types = "ss";

    if ($password) {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $sql .= ", password=?";
      $params[] = $hash;
      $types .= "s";
    }

    if ($photo) {
      $sql .= ", photo=?";
      $params[] = $photo;
      $types .= "s";
    }

    $sql .= " WHERE username=?";
    $params[] = $oldUsername;
    $types .= "s";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    return $stmt->execute();
  }

public function getByToken($token) {
  $stmt = $this->conn->prepare("SELECT * FROM users WHERE reset_token = ?");
  $stmt->bind_param("s", $token);
  $stmt->execute();
  return $stmt->get_result()->fetch_assoc();
}

public function updatePassword($id, $passwordHash) {
  $stmt = $this->conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expire = NULL WHERE id = ?");
  $stmt->bind_param("si", $passwordHash, $id);
  return $stmt->execute();
}


}

