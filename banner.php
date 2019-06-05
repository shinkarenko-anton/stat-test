<?php
include_once 'ip-tool.php';
include_once 'file-tool.php';

$file = 'image.jpg';

$mysqli = new mysqli("127.0.0.1", "root", "", "test", 3306);
if (!$mysqli->connect_errno) {
    $id = null;
    $ip = getIpAddr();
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $url = $_SERVER['HTTP_REFERER'];
    $date = date("Y-m-d H:i:s");

    $sql = "SELECT * FROM stat WHERE ip_address = ? AND user_agent = ? AND page_url = ? LIMIT 1";

    if($query = $mysqli->prepare($sql)) {
        $query->bind_param('sss', $ip, $agent, $url);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows) {
            $record = $result->fetch_object();
            $count = $record->views_count+1;
            $sql = "UPDATE stat SET view_date = ?, views_count = ? WHERE id = ?";
            if($query = $mysqli->prepare($sql)) {
                $query->bind_param('sii', $date, $count, $record->id);
                $query->execute();
            }
        } else {
            $count = 1;
            $sql = "INSERT INTO stat VALUES (?, ?, ?, ?, ?, ?)";
            if($query = $mysqli->prepare($sql)) {
                $query->bind_param('issssi', $id, $ip, $agent, $date, $url, $count);
                $query->execute();
            }
        }
    }
}

$mysqli->close();

printFile($file);
