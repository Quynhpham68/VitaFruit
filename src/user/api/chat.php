<?php
// chat.php: Chứa khung chat để include vào các trang khác
// Kết nối database
include(__DIR__ . "/../connect.php");
 // file connect.php chứa $conn = new mysqli(...)

// Nếu gửi request AJAX
if(isset($_POST['message'])){
    $userMessage = $_POST['message'];

    // Hàm kiểm tra database
    function queryDatabase($message, $conn) {
    $messageLower = strtolower($message);
    $conditions = [];

    // 1. Sale
    if (preg_match("/sale|giảm giá|khuyến mại/", $messageLower)) {
        $conditions[] = "discount_percent > 0";
    }

    // 2. Danh mục
    $categories = ['hoa quả', 'rau củ', 'thịt', 'cá', 'thực phẩm chức năng'];
    $foundCategory = null;
    foreach ($categories as $cat) {
        if (strpos($messageLower, $cat) !== false) {
            $foundCategory = $cat;
            break;
        }
    }
    if ($foundCategory) {
        $conditions[] = "category LIKE '%$foundCategory%'";
    }

    // Nếu hỏi về sale nhưng không nói category, mặc định tìm trong "hoa quả"
    if (preg_match("/sale|giảm giá|khuyến mại/", $messageLower) && !$foundCategory) {
        $conditions[] = "category LIKE '%hoa quả%'";
    }

    // 3. Công dụng / người bệnh
    if (preg_match("/tiểu đường|tim mạch|tăng cân|giảm cân/i", $message, $matches)) {
        $keyword = mysqli_real_escape_string($conn, $matches[0]);
        $conditions[] = "details_desc LIKE '%$keyword%'";
    }

    // Nếu không có điều kiện nào → trả null
    if (empty($conditions)) return null;

    // Kết hợp điều kiện bằng AND để lọc chính xác
    $sql = "SELECT name, price, discount_percent, discount_price, quantity 
            FROM product 
            WHERE " . implode(" AND ", $conditions) . " 
            LIMIT 5";

    $result = $conn->query($sql);
    if(!$result) return "Lỗi truy vấn database: " . $conn->error;

    if($result->num_rows > 0){
        $data = [];
        while($row = $result->fetch_assoc()){
            $priceText = ($row['discount_percent'] > 0 && $row['discount_price'] !== null)
                ? number_format($row['discount_price'],0,',','.') . " VNĐ (Sale " . $row['discount_percent'] . "%)"
                : number_format($row['price'],0,',','.') . " VNĐ";
            $data[] = $row['name'] . " - " . $priceText . " (Còn " . $row['quantity'] . " sản phẩm)";
        }
        return "Danh sách sản phẩm tìm thấy: " . implode(", ", $data);
    }

    return "Hiện tại không có sản phẩm nào phù hợp.";
}

    $answer = queryDatabase($userMessage, $conn);

    if(!$answer){
        // gọi OpenAI nếu không tìm thấy sản phẩm
        $api_key = "AIzaSyDxoX6uytLJ6SRlqbeWfhNlQuJyi29P2Dg";
        $postData = [
            "model" => "gpt-4",
            "messages" => [
                ["role" => "user", "content" => $userMessage]
            ]
        ];
        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        $response = curl_exec($ch);
        curl_close($ch);

        $respData = json_decode($response, true);
        $answer = $respData['choices'][0]['message']['content'] ?? "Xin lỗi, tôi không hiểu.";
    }

    // Lưu chat
    $user_id = 1;
    $stmt = $conn->prepare("INSERT INTO chat_messages (user_id, question, reply) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $userMessage, $answer);
    $stmt->execute();
    $stmt->close();

    echo json_encode(["answer" => $answer]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Linking Google fonts for icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="chat.css" />
</head>

<!-- Chatbot Toggler -->
    <button id="chatbot-toggler">
        <span class="material-symbols-rounded">mode_comment</span>
        <span class="material-symbols-rounded">close</span>
    </button>
    <div class="chatbot-popup">
        <!-- Chatbot Header -->
        <div class="chat-header">
            <div class="header-info">
            <svg class="chatbot-logo" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
                <path
                d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"
                />
            </svg>
            <h2 class="logo-text">VitaFruit</h2>
            </div>
            <button id="close-chatbot" class="material-symbols-rounded">keyboard_arrow_down</button>
        </div>
        <!-- Chatbot Body -->
        <div class="chat-body">
            <div class="message bot-message">
            <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
                <path
                d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"
                />
            </svg>
            <!-- prettier-ignore -->
            <div class="message-text"> Xin chào 👋<br /> Tôi có thể giúp gì cho bạn? </div>
            </div>
        </div>
        <!-- Chatbot Footer -->
        <div class="chat-footer">
            <form action="#" class="chat-form">
            <textarea placeholder="Message..." class="message-input" required></textarea>
            <div class="chat-controls">
                <button type="button" id="emoji-picker" class="material-symbols-outlined">sentiment_satisfied</button>
                <div class="file-upload-wrapper">
                <input type="file" id="file-input" hidden />
                <img src="#" />
                <button type="button" id="file-upload" class="material-symbols-rounded">attach_file</button>
                <button type="button" id="file-cancel" class="material-symbols-rounded">close</button>
                </div>
                <button type="submit" id="send-message" class="material-symbols-rounded">arrow_upward</button>
            </div>
            </form>
        </div>
    </div>

    <!-- Linking Emoji Mart script for emoji picker -->
    <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>

    <!-- Linking for file upload functionality -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
    
    <!-- Linking custom script -->
    <script src="api/chat.js"></script>

