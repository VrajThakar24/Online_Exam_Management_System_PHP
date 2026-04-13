<?php
function getUserFullname($conn, $username) {
    $stmt = $conn->prepare("SELECT fullname FROM users_details WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return ($row = $result->fetch_assoc()) ? $row['fullname'] : '';
}
?>