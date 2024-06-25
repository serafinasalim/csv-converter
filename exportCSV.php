<?php
include 'config.php';

$sql = "SELECT judul, penulis, genre, tahun_terbit, penerbit FROM buku";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="buku.csv"');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Write headers manually
    fputs($output, "id,judul,penulis,genre,tahun_terbit,penerbit\n");

    // Write data rows
    while ($row = $result->fetch_assoc()) {
        // Prepare each row's data
        $judul = $row['judul'];
        $penulis = $row['penulis'];
        $genre = $row['genre'];
        $tahun_terbit = $row['tahun_terbit'];
        $penerbit = $row['penerbit'];

        // Format the row without double quotes
        $line = "$judul,$penulis,$genre,$tahun_terbit,$penerbit\n";

        // Write the line to CSV
        fputs($output, $line);
    }

    // Close output stream
    fclose($output);

    // Free result set
    $result->free();

    // Close database connection
    $conn->close();

} else {
    echo "No records found";
}
?>
