import 'package:firebase_messaging/firebase_messaging.dart';

class FCMService {
  final FirebaseMessaging _messaging = FirebaseMessaging.instance;

  Future<void> initNotification() async {
    // Meminta izin notifikasi (Penting untuk Android 13+ dan iOS)
    await _messaging.requestPermission();

    // Mengambil FCM Token untuk keperluan testing di Postman / Firebase Console
    String? token = await _messaging.getToken();
    print("================ FCM TOKEN ================");
    print(token);
    print("===========================================");

    // Menangani notifikasi ketika aplikasi sedang terbuka (Foreground)
    FirebaseMessaging.onMessage.listen((RemoteMessage message) {
      print('Notifikasi Masuk: ${message.notification?.title}');
    });
  }
}
