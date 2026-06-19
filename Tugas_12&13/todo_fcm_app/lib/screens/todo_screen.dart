import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import '../providers/task_provider.dart';

class TodoScreen extends StatefulWidget {
  const TodoScreen({super.key});

  @override
  State<TodoScreen> createState() => _TodoScreenState();
}

class _TodoScreenState extends State<TodoScreen> {
  final TextEditingController _controller = TextEditingController();

  // 🟢 FUNGSI UNTUK MEMBUAT NOTIFIKASI MUNCUL DARI ATAS (MIRIP NOTIFIKASI PUSH)
  void _showTopNotification(
    String title,
    String message, {
    Color color = Colors.blueAccent,
  }) {
    OverlayState? overlayState = Overlay.of(context);
    late OverlayEntry overlayEntry;

    overlayEntry = OverlayEntry(
      builder: (context) => Positioned(
        top: 50, // Mengatur jarak dari atas layar
        left: 16,
        right: 16,
        child: Material(
          color: Colors.transparent,
          child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
            decoration: BoxDecoration(
              color: color,
              borderRadius: BorderRadius.circular(12),
              boxShadow: const [
                BoxShadow(
                  color: Colors.black26,
                  blurRadius: 8,
                  offset: Offset(0, 4),
                ),
              ],
            ),
            child: Row(
              children: [
                const Icon(
                  Icons.notifications_active,
                  color: Colors.white,
                  size: 28,
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      Text(
                        title,
                        style: const TextStyle(
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                          fontSize: 16,
                        ),
                      ),
                      const SizedBox(height: 2),
                      Text(
                        message,
                        style: const TextStyle(
                          color: Colors.white,
                          fontSize: 14,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );

    // Memasukkan notifikasi ke layar
    overlayState.insert(overlayEntry);

    // Notifikasi otomatis hilang setelah 3 detik
    Future.delayed(const Duration(seconds: 3), () {
      overlayEntry.remove();
    });
  }

  @override
  void initState() {
    super.initState();

    // 🟢 LISTEN NOTIFIKASI FCM DARI FIREBASE CONSOLE (TETAP AKTIF UNTUK TUGAS)
    FirebaseMessaging.onMessage.listen((RemoteMessage message) {
      if (message.notification != null) {
        _showTopNotification(
          message.notification!.title ?? 'Firebase Modul 12-13',
          message.notification!.body ?? '',
          color: Colors.blueAccent, // Warna biru untuk notifikasi Firebase
        );
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    final taskProvider = Provider.of<TaskProvider>(context);

    return Scaffold(
      appBar: AppBar(
        title: const Text('To-Do List Modul 12 & 13'),
        actions: [
          IconButton(
            icon: const Icon(Icons.delete_forever, color: Colors.red),
            tooltip: 'Hapus Semua',
            onPressed: () {
              taskProvider.clearAllTasks();
              _showTopNotification(
                'Sistem',
                'Semua tugas telah dihapus.',
                color: Colors.redAccent,
              );
            },
          ),
        ],
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            Row(
              children: [
                Expanded(
                  child: TextField(
                    controller: _controller,
                    decoration: const InputDecoration(
                      labelText: 'Tambah Tugas Baru',
                      border: OutlineInputBorder(),
                    ),
                  ),
                ),
                const SizedBox(width: 10),
                ElevatedButton(
                  onPressed: () {
                    if (_controller.text.isNotEmpty) {
                      String taskTitle = _controller.text;

                      // Menutup keyboard otomatis agar tidak menutupi layar
                      FocusScope.of(context).unfocus();

                      // Menambahkan tugas ke state Provider
                      taskProvider.addTask(taskTitle);

                      // 🟢 TRIGER NOTIFIKASI DARI ATAS LAYAR DENGAN TEKS DINAMIS
                      _showTopNotification(
                        'Aplikasi Sukses',
                        'Tugas "$taskTitle" berhasil ditambahkan!',
                        color: Colors
                            .green, // Warna hijau untuk notifikasi lokal tambah tugas
                      );

                      _controller.clear();
                    }
                  },
                  child: const Text('Tambah'),
                ),
              ],
            ),
            const SizedBox(height: 20),
            Expanded(
              child: taskProvider.tasks.isEmpty
                  ? const Center(child: Text('Belum ada tugas.'))
                  : ListView.builder(
                      itemCount: taskProvider.tasks.length,
                      itemBuilder: (context, index) {
                        return Card(
                          child: ListTile(
                            leading: CircleAvatar(child: Text('${index + 1}')),
                            title: Text(taskProvider.tasks[index].title),
                          ),
                        );
                      },
                    ),
            ),
          ],
        ),
      ),
    );
  }
}
