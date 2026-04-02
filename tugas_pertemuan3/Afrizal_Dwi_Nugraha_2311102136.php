<?php
// 1. Array Asosiasi untuk menyimpan minimal 3 data mahasiswa
$data_mahasiswa = [
    [
        "nama" => "Afrizal Dwi Nugraha",
        "nim" => "2311102136",
        "nilai_tugas" => 85,
        "nilai_uts" => 90,
        "nilai_uas" => 88
    ],
    [
        "nama" => "Rico Ade Pratama",
        "nim" => "2311102138",
        "nilai_tugas" => 60,
        "nilai_uts" => 75,
        "nilai_uas" => 70
    ],
    [
        "nama" => "Arjun Werdho Kumoro",
        "nim" => "2311102009",
        "nilai_tugas" => 50,
        "nilai_uts" => 45,
        "nilai_uas" => 55
    ]
];

// 2. Function dan Operator Aritmatika untuk menghitung nilai akhir
function hitungNilaiAkhir($tugas, $uts, $uas) {
    // Menggunakan operator aritmatika: perkalian (*) dan penjumlahan (+)
    // Asumsi bobot: Tugas 30%, UTS 30%, UAS 40%
    return ($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4);
}

// 3. If/else untuk menentukan grade
function tentukanGrade($nilai) {
    if ($nilai >= 85) {
        return 'A';
    } elseif ($nilai >= 70) {
        return 'B';
    } elseif ($nilai >= 60) {
        return 'C';
    } elseif ($nilai >= 50) {
        return 'D';
    } else {
        return 'E';
    }
}

// 4. Operator perbandingan untuk menentukan lulus/tidak
function tentukanStatus($nilai) {
    // Menggunakan operator perbandingan (>=)
    if ($nilai >= 60) {
        return "<span style='color:green; font-weight:bold;'>Lulus</span>";
    } else {
        return "<span style='color:red; font-weight:bold;'>Tidak Lulus</span>";
    }
}

// Inisialisasi variabel untuk menghitung rata-rata dan nilai tertinggi
$total_nilai = 0;
$nilai_tertinggi = 0;
$jumlah_mahasiswa = count($data_mahasiswa);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penilaian Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .statistik { margin-top: 20px; padding: 15px; background-color: #e9ecef; border-radius: 5px; }
    </style>
</head>
<body>

    <h2>Data Penilaian Mahasiswa</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Nilai Akhir</th>
                <th>Grade</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 5. Gunakan loop untuk menampilkan seluruh data
            $no = 1;
            foreach ($data_mahasiswa as $mhs) {
                // Proses perhitungan menggunakan function
                $nilai_akhir = hitungNilaiAkhir($mhs['nilai_tugas'], $mhs['nilai_uts'], $mhs['nilai_uas']);
                $grade = tentukanGrade($nilai_akhir);
                $status = tentukanStatus($nilai_akhir);

                // Mengumpulkan data untuk statistik
                $total_nilai += $nilai_akhir;
                if ($nilai_akhir > $nilai_tertinggi) {
                    $nilai_tertinggi = $nilai_akhir;
                }

                // Cetak baris tabel
                echo "<tr>";
                echo "<td>{$no}</td>";
                echo "<td>{$mhs['nama']}</td>";
                echo "<td>{$mhs['nim']}</td>";
                echo "<td>" . number_format($nilai_akhir, 2) . "</td>";
                echo "<td>{$grade}</td>";
                echo "<td>{$status}</td>";
                echo "</tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>

    <?php
    // Menghitung rata-rata kelas menggunakan operator aritmatika pembagian (/)
    $rata_rata_kelas = $total_nilai / $jumlah_mahasiswa;
    ?>

    <div class="statistik">
        <p><strong>Rata-rata Nilai Kelas:</strong> <?php echo number_format($rata_rata_kelas, 2); ?></p>
        <p><strong>Nilai Tertinggi:</strong> <?php echo number_format($nilai_tertinggi, 2); ?></p>
    </div>

</body>
</html>