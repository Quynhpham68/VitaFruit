<?php
header("Content-Type: application/json");

// Kết nối database
$host = "localhost";   
$user = "root";       
$pass = "";            
$db   = "vitafruit";     

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(["error" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Nhận JSON từ JS
$data = json_decode(file_get_contents("php://input"), true);
$action = $data["action"] ?? "";

// Lưu tin nhắn
if ($action === "save") {
    $question = $conn->real_escape_string($data["question"]);
    $reply    = $conn->real_escape_string($data["reply"]);

    $sql = "INSERT INTO chat_messages (user_id, question, reply, created_at)
            VALUES (1, '$question', '$reply', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
}

// Load lịch sử
elseif ($action === "load") {
    $result = $conn->query("SELECT * FROM chat_messages ORDER BY created_at ASC");
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    echo json_encode($messages);
}

else {
    echo json_encode(["error" => "Hành động không hợp lệ"]);
}

$conn->close();
?>
