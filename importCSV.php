<?php
header('Content-Type: application/json');

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    include 'config.php';
    
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    if ($fileExtension === 'csv') {
        $handle = fopen($fileTmpPath, 'r');
        if ($handle !== FALSE) {
            fgetcsv($handle); // Skip the header row
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $judul = $conn->real_escape_string($data[0]);
                $penulis = $conn->real_escape_string($data[1]);
                $genre = $conn->real_escape_string($data[2]);
                $tahun_terbit = $conn->real_escape_string($data[3]);
                $penerbit = $conn->real_escape_string($data[4]);

                $sql = "INSERT INTO buku (judul, penulis, genre, tahun_terbit, penerbit) VALUES ('$judul', '$penulis', '$genre', '$tahun_terbit', '$penerbit')";
                $conn->query($sql);
            }
            fclose($handle);
            $response = ['status' => 'success', 'message' => 'Import successful'];
        } else {
            $response = ['status' => 'error', 'message' => 'Error opening the file'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid file type'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Error uploading the file'];
}

echo json_encode($response);
?>
