<?php
include 'config.php';

$sql = "SELECT * FROM buku";
$result = $conn->query($sql);

$books = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
$conn->close();

echo json_encode($books);
?>
