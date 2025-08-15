<?php
header("Content-Type: application/json");
include("connect.php");

$data = json_decode(file_get_contents("php://input"), true);
$userMessage = $data['message'] ?? '';

if (empty($userMessage)) {
    echo json_encode(["reply" => "Vui lòng nhập câu hỏi."]);
    exit;
}

$lowerMsg = strtolower($userMessage);

// Kiểm tra từ khóa sức khỏe
$healthKeywords = ['sức khỏe', 'tốt cho sức khỏe', 'tốt cho', 'healthy', 'bổ dưỡng', 'ăn tốt'];
foreach ($healthKeywords as $kw) {
    if (strpos($lowerMsg, $kw) !== false) {
        // Lấy ngẫu nhiên 3 sản phẩm chung (bạn có thể thay đổi theo ý muốn)
        $result = mysqli_query($code, "SELECT name FROM product ORDER BY RAND() LIMIT 3");
        $names = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $names[] = $row['name'];
        }
        $reply = "Một số sản phẩm tốt cho sức khỏe bạn có thể tham khảo: " . implode(", ", $names) . ".";
        echo json_encode(["reply" => $reply]);
        exit;
    }
}

// Kiểm tra từ khóa về rau củ
$vegetableKeywords = ['rau củ', 'rau', 'củ', 'rau củ quả', 'rau củ sạch', 'rau củ hữu cơ'];
foreach ($vegetableKeywords as $kw) {
    if (strpos($lowerMsg, $kw) !== false) {
        // Lấy 3 sản phẩm thuộc category "Rau Củ"
        $result = mysqli_query($code, "SELECT name FROM product WHERE category = 'Rau Củ' ORDER BY RAND() LIMIT 3");
        $names = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $names[] = $row['name'];
        }
        if (count($names) > 0) {
            $reply = "Bạn có thể tham khảo một số rau củ của chúng tôi: " . implode(", ", $names) . ".";
        } else {
            $reply = "Hiện tại chúng tôi chưa có rau củ phù hợp, bạn có thể thử hỏi thêm nhé.";
        }
        echo json_encode(["reply" => $reply]);
        exit;
    }
}

// Nếu không trúng điều kiện trên thì gọi Gemini API
$apiKey = 'AIzaSyDJUzVXivfSJ8yfmia6TsPfdtU-PA245do'; 
$endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

$body = [
    "contents" => [[
        "parts" => [[ "text" => $userMessage ]]
    ]]
];

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$json = json_decode($response, true);

if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
    $reply = $json['candidates'][0]['content']['parts'][0]['text'];
    echo json_encode(["reply" => $reply]);
} else {
    echo json_encode(["reply" => "Xin lỗi, tôi không hiểu câu hỏi của bạn."]);
}
?>
