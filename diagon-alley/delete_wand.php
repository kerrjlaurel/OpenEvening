<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = file_get_contents("php://input");
$request = json_decode($data, true);

// The wand selector uses 'generated_at' instead of 'timestamp'
if (isset($request['generated_at'])) {
    $target_timestamp = $request['generated_at'];
    $filename = "wands_ledger.jsonl";
    
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $new_lines = [];
    
    foreach ($lines as $line) {
        $wand = json_decode($line, true);
        if (isset($wand['generated_at']) && $wand['generated_at'] !== $target_timestamp) {
            $new_lines[] = $line;
        }
    }
    
    file_put_contents($filename, implode("\n", $new_lines) . "\n");
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "No timestamp provided."]);
}
?>