<?php
require_once 'db_config.php';
$conn = getDBConnection();

$sql = "SELECT * FROM `keys`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    
    while ($row = $result->fetch_assoc()) {
        $key = $row["key"];
        $expiryDate = $row["expiry_date"];
        $hwidBound = $row["hwid_bound"];
        $boundHwid = $row["bound_hwid"];
        $frozen = $row["frozen"];
        
        echo "<li>Key: $key<br>Expiration date: $expiryDate<br>HWID linked: ";
        
        if ($hwidBound) {
            echo "Yes<br>HWID: $boundHwid<br>";
        } else {
            echo "No<br>";
        }
        
        if ($hwidBound) { 
            echo "<button data-key='$key' data-action='unbind'>Unbind HWID</button>";
        }
        if ($frozen) {
            echo "<button onclick='toggleKeyState(\"$key\", false)'>Unfreeze</button>";
        } else {
            echo "<button onclick='toggleKeyState(\"$key\", true)'>Freeze</button>";
        }
        echo "<button data-key='$key' data-action='delete'>Delete</button>";
        
        echo "</li>";
    }
    
    echo "</ul>";
} else {
    echo "The list of keys is empty";
}

$conn->close();
?>
