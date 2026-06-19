import 'package:flutter/material.dart';
import '../models/task_model.dart';

class TaskProvider extends ChangeNotifier {
  final List<Task> _tasks = [];

  List<Task> get tasks => _tasks;

  // Fungsi menambah tugas baru
  void addTask(String title) {
    if (title.isNotEmpty) {
      _tasks.add(Task(title: title));
      notifyListeners(); // Memberitahu UI untuk merender ulang
    }
  }

  // Fungsi menghapus semua tugas
  void clearAllTasks() {
    _tasks.clear();
    notifyListeners();
  }
}
