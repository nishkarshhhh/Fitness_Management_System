<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "gym_codecampbd";

$resultMessage = "";

try {
    $conn = new PDO("mysql:host={$host};dbname={$db};", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bookingId"])) {
    $bookingId = $_POST["bookingId"];

    try {
        // Assuming GetTotalPayments is a stored procedure
        $stmt = $conn->prepare("CALL GetTotalPayments(:bookingId)");
        $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Fetch the result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && isset($row["payment"])) {
            $resultMessage = "Total Payments for Booking ID {$bookingId}: " . $row["payment"];
        } else {
            $resultMessage = "Total Payments not found for Booking ID {$bookingId}";
        }
    } catch (PDOException $e) {
        $resultMessage = "Error: " . $e->getMessage();
    }
}
?>
