<?php
// Allow the browser to send data here
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Read the incoming JSON data from the typing test
$data = file_get_contents("php://input");

if ($data) {
    // Open the jsonl file and append the new data on a new line
    $file = fopen("diagon_alley_scores.jsonl", "a");
    fwrite($file, $data . "\n");
    fclose($file);
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "No data received."]);
}
?>