<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_config.php';
	$conn = getDBConnection();
	
    if (isset($_POST['key']) && isset($_POST['hwid'])) {
        $key = $_POST['key'];
        $hwid = $_POST['hwid'];
        $checkQuery = "SELECT `hwid_bound`, `frozen` FROM `keys` WHERE `key`='$key' LIMIT 1";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows === 1) {
            $row = $checkResult->fetch_assoc();
            if ($row['hwid_bound']) {
                echo "HWID is already bound to this key";
            } elseif ($row['frozen']) {
                echo "Key is frozen and cannot be changed";
            } else {
                $updateQuery = "UPDATE `keys` SET `hwid_bound`=TRUE, `bound_hwid`='$hwid' WHERE `key`='$key'";

                if ($conn->query($updateQuery) === TRUE) {
                    echo "HWID successfully bound to the key";
                } else {
                    echo "Error when binding HWID to key: " . $conn->error;
                }
            }
        } else {
            echo "Key not found";
        }
    } else {
        echo "The key and/or HWID is missing in the POST request";
    }
	
    $conn->close();
} else {
    echo "Invalid request method";
}
?>