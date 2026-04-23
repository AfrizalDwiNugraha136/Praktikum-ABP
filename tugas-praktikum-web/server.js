const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');

const app = express();
const port = 3000;

// Middleware untuk memproses data dari form dan JSON
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Menyajikan file statis (HTML, CSS, JS) dari folder 'public'
app.use(express.static('public'));

// --- Database Dummy (Data Disimpan di Memori) ---
let datasets = [
    { id: 1, platform: 'Google Maps', keyword: 'Ulasan Restoran', target_jumlah: 1000 },
    { id: 2, platform: 'X (Twitter)', keyword: 'Sentimen AI', target_jumlah: 1500 }
];

// --- ENDPOINT API CRUD ---

// 1. READ: Ambil semua data (Untuk ditampilkan di DataTable)
app.get('/api/datasets', (req, res) => {
    // Mengubah array 'datasets' menjadi format JSON dan mengirimkannya ke klien
    res.json(datasets);
});

// 2. CREATE: Tambah data baru dari Form
app.post('/api/datasets', (req, res) => {
    const newData = {
        // Buat ID otomatis (tambah 1 dari ID terakhir)
        id: datasets.length > 0 ? datasets[datasets.length - 1].id + 1 : 1,
        platform: req.body.platform,
        keyword: req.body.keyword,
        target_jumlah: req.body.target_jumlah
    };
    datasets.push(newData);
    res.json({ message: 'Data berhasil ditambahkan!', data: newData });
});

// 3. DELETE: Hapus data berdasarkan ID
app.delete('/api/datasets/:id', (req, res) => {
    const id = parseInt(req.params.id);
    datasets = datasets.filter(d => d.id !== id);
    res.json({ message: 'Data berhasil dihapus!' });
});

// Jalankan Server
app.listen(port, () => {
    console.log(`Server sudah berjalan! Buka di browser: http://localhost:${port}`);
});