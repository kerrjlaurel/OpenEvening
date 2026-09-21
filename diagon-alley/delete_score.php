<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = file_get_contents("php://input");
$request = json_decode($data, true);

if (isset($request['timestamp'])) {
    $target_timestamp = $request['timestamp'];
    $filename = "diagon_alley_scores.jsonl";
    
    // Read all existing records
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $new_lines = [];
    
    // Filter out the one that matches the timestamp
    foreach ($lines as $line) {
        $score = json_decode($line, true);
        if (isset($score['timestamp']) && $score['timestamp'] !== $target_timestamp) {
            $new_lines[] = $line;
        }
    }
    
    // Rewrite the file with the clean data
    file_put_contents($filename, implode("\n", $new_lines) . "\n");
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "No timestamp provided."]);
}
?>