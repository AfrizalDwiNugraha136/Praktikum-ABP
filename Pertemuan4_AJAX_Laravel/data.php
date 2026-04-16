<?php
header('Content-Type: application/json');

$data = [
    'nama' => 'Afrizal Dwi Nugraha',
    'pekerjaan' => 'Mahasiswa Informatika / Web Developer',
    'lokasi' => 'Purwokerto'
];

echo json_encode($data);
?>