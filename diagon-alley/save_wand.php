<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = file_get_contents("php://input");
$json = json_decode($data, true);

if ($json) {
    // Add the generated_at timestamp just like your Python script did
    $json['generated_at'] = date("Y-m-d H:i:s");
    
    // Save to the wands ledger
    $file = fopen("wands_ledger.jsonl", "a");
    fwrite($file, json_encode($json) . "\n");
    fclose($file);
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "No data received."]);
}
?>