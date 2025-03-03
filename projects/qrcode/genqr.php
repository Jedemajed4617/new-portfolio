<?php
if (isset($_GET["imageName"])) {
    $imageName = filter_var($_GET["imageName"], FILTER_SANITIZE_STRING);
    $imageSrc = "https://tgsoftware.services/qrcode/download.php?imageurl=" . urlencode($imageName);

    // Output directory
    $outputDir = "./qrcodes/";
    $qrCodePath = $outputDir . $imageName . ".png";

    // Ensure the output directory exists
    if (!file_exists($outputDir) && !mkdir($outputDir, 0777, true)) {
        echo json_encode(array("error" => "Failed to create output directory"));
        exit;
    }

    // Check if QRCode library exists
    if (!file_exists("./phpqrcode/qrlib.php")) {
        echo json_encode(array("error" => "QR library not found"));
        exit;
    }

    include "./phpqrcode/qrlib.php";

    // Generate QR code
    QRcode::png($imageSrc, $qrCodePath);

    echo json_encode(array("qr_code" => $qrCodePath));
    exit;

} else {
    echo json_encode(array("error" => "Invalid request"));
}
