<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once 'db_config.php';
    $conn = getDBConnection();

    if (isset($_GET['key']) && isset($_GET['hwid'])) {
        $key = $_GET['key'];
        $providedHwid = strtolower($_GET['hwid']);
        
		$checkQuery = "SELECT `hwid_bound`, `frozen`, `expiry_date`, `bound_hwid` FROM `keys` WHERE `key`='$key' LIMIT 1";
        
		$checkResult = $conn->query($checkQuery);
        if ($checkResult->num_rows === 1) {
            $row = $checkResult->fetch_assoc();
            if ($row['frozen']) {
                echo "Key is frozen";
            } elseif ($row['expiry_date'] < date('Y-m-d')) {
                $deleteQuery = "DELETE FROM `keys` WHERE `key`='$key'";
                if ($conn->query($deleteQuery) === TRUE) {
                    echo "Key has expired and has been deleted";
                } else {
                    echo "Error when deleting an expired key: " . $conn->error;
                }
            } else {
                if ($row['hwid_bound']) {
                    if (strtolower($row['bound_hwid']) === $providedHwid) {
                        echo "Key is valid";
                    } else {
                        echo "HWID does not match the associated HWID";
                    }
                } else {
                    $bindHwidQuery = "UPDATE `keys` SET `hwid_bound`=TRUE, `bound_hwid`='$providedHwid' WHERE `key`='$key'";
                    if ($conn->query($bindHwidQuery) === TRUE) {
                        echo "Key is valid and HWID has been bound";
                    } else {
                        echo "Error when binding HWID to key: " . $conn->error;
                    }
                }
            }
        } else {
            echo "Key not found";
        }
    }

    $conn->close();
} else {
    echo "Invalid request method";
}
?>
