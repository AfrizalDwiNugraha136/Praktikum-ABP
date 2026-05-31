import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Tugas ABP Notif',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        primarySwatch: Colors.blue,
        useMaterial3: true,
      ),
      home: const MyHomePage(),
    );
  }
}

class MyHomePage extends StatefulWidget {
  const MyHomePage({super.key});

  @override
  State<MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  File? _image;

  final ImagePicker _picker = ImagePicker();

  final FlutterLocalNotificationsPlugin _localNotificationsPlugin =
  FlutterLocalNotificationsPlugin();

  @override
  void initState() {
    super.initState();
    _initNotification();
  }

  // =========================
  // Inisialisasi Notifikasi
  // =========================
  Future<void> _initNotification() async {
    try {
      const AndroidInitializationSettings androidSettings =
      AndroidInitializationSettings('@mipmap/ic_launcher');

      const InitializationSettings initializationSettings =
      InitializationSettings(
        android: androidSettings,
      );

      await _localNotificationsPlugin.initialize(
        initializationSettings,
      );

      await _localNotificationsPlugin
          .resolvePlatformSpecificImplementation<
          AndroidFlutterLocalNotificationsPlugin>()
          ?.requestNotificationsPermission();

      debugPrint("✅ Notifikasi berhasil diinisialisasi");
    } catch (e) {
      debugPrint("❌ Gagal inisialisasi notifikasi: $e");
    }
  }

  // =========================
  // Tampilkan Notifikasi
  // =========================
  Future<void> _showNotification(String sourceName) async {
    try {
      debugPrint("🔔 Mencoba menampilkan notifikasi");

      const AndroidNotificationDetails androidDetails =
      AndroidNotificationDetails(
        'hardware_api_channel',
        'Notifikasi Perangkat Keras',
        channelDescription:
        'Saluran notifikasi untuk kamera dan galeri',
        importance: Importance.max,
        priority: Priority.high,
        playSound: true,
      );

      const NotificationDetails notificationDetails =
      NotificationDetails(
        android: androidDetails,
      );

      await _localNotificationsPlugin.show(
        1,
        'Foto Berhasil Dimuat!',
        'Gambar berhasil diambil melalui $sourceName',
        notificationDetails,
      );

      debugPrint("✅ Notifikasi berhasil dikirim");
    } catch (e) {
      debugPrint("❌ Error notifikasi: $e");
    }
  }

  // =========================
  // Ambil Gambar
  // =========================
  Future<void> _pickImage(
      ImageSource source,
      String sourceName,
      ) async {
    try {
      final XFile? pickedFile = await _picker.pickImage(
        source: source,
        imageQuality: 80,
      );

      if (pickedFile != null) {
        setState(() {
          _image = File(pickedFile.path);
        });

        debugPrint("📸 Foto berhasil dipilih");

        await _showNotification(sourceName);
      }
    } catch (e) {
      debugPrint("❌ Error mengambil gambar: $e");
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Notifikasi & API Perangkat Keras'),
        backgroundColor: Colors.blue.shade100,
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Column(
            children: [
              // Area Foto
              Container(
                width: double.infinity,
                height: 300,
                decoration: BoxDecoration(
                  color: Colors.grey.shade200,
                  borderRadius: BorderRadius.circular(12),
                  border: Border.all(
                    color: Colors.grey.shade400,
                  ),
                ),
                child: _image != null
                    ? ClipRRect(
                  borderRadius:
                  BorderRadius.circular(11),
                  child: Image.file(
                    _image!,
                    fit: BoxFit.cover,
                  ),
                )
                    : const Center(
                  child: Text(
                    'Belum ada foto yang dipilih',
                    style: TextStyle(fontSize: 16),
                  ),
                ),
              ),

              const SizedBox(height: 30),

              // Kamera
              ElevatedButton.icon(
                onPressed: () => _pickImage(
                  ImageSource.camera,
                  'Kamera',
                ),
                icon: const Icon(Icons.camera_alt),
                label: const Text(
                  'Buka Kamera Langsung (Camera API)',
                ),
                style: ElevatedButton.styleFrom(
                  minimumSize:
                  const Size(double.infinity, 50),
                ),
              ),

              const SizedBox(height: 15),

              // Galeri
              ElevatedButton.icon(
                onPressed: () => _pickImage(
                  ImageSource.gallery,
                  'Galeri',
                ),
                icon: const Icon(Icons.photo_library),
                label: const Text(
                  'Pilih Foto dari Galeri (Image Picker)',
                ),
                style: ElevatedButton.styleFrom(
                  minimumSize:
                  const Size(double.infinity, 50),
                ),
              ),

              const SizedBox(height: 15),

              // Tes Notifikasi
              ElevatedButton.icon(
                onPressed: () async {
                  await _showNotification(
                    'Tes Manual',
                  );
                },
                icon: const Icon(Icons.notifications),
                label: const Text(
                  'Tes Notifikasi',
                ),
                style: ElevatedButton.styleFrom(
                  minimumSize:
                  const Size(double.infinity, 50),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}