import 'package:flutter/material.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Tugas Modul Flutter',
      theme: ThemeData(primarySwatch: Colors.blue, useMaterial3: true),
      home: const TugasWidgetPage(),
    );
  }
}

class TugasWidgetPage extends StatelessWidget {
  const TugasWidgetPage({super.key});

  @override
  Widget build(BuildContext context) {
    // Data untuk ListView.builder
    final List<String> items = List.generate(5, (index) => "Item Builder ke-${index + 1}");

    return Scaffold(
      appBar: AppBar(
        title: const Text('Tugas Modul - Afrizal Dwi Nugraha'),
        backgroundColor: Colors.blueAccent,
      ),
      body: SingleChildScrollView( // Agar halaman bisa di-scroll karena banyak widget
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const Text("1. Stack & Container", style: TextStyle(fontWeight: FontWeight.bold)),
              const SizedBox(height: 10),
              // WIDGET STACK & CONTAINER
              Stack(
                children: [
                  Container(
                    width: 200,
                    height: 100,
                    color: Colors.red,
                  ),
                  Container(
                    width: 150,
                    height: 80,
                    color: Colors.yellow,
                    margin: const EdgeInsets.all(10),
                  ),
                  const Positioned(
                    top: 30,
                    left: 20,
                    child: Text("Teks di atas Stack", style: TextStyle(fontWeight: FontWeight.bold)),
                  ),
                ],
              ),

              const SizedBox(height: 30),
              const Text("2. ListView (Manual A, B, C)", style: TextStyle(fontWeight: FontWeight.bold)),
              // WIDGET LISTVIEW MANUAL
              SizedBox(
                height: 120,
                child: ListView(
                  children: const [
                    ListTile(leading: CircleAvatar(child: Text("A")), title: Text("Item A")),
                    ListTile(leading: CircleAvatar(child: Text("B")), title: Text("Item B")),
                    ListTile(leading: CircleAvatar(child: Text("C")), title: Text("Item C")),
                  ],
                ),
              ),

              const SizedBox(height: 30),
              const Text("3. GridView (6 Items)", style: TextStyle(fontWeight: FontWeight.bold)),
              // WIDGET GRIDVIEW
              GridView.builder(
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: 3,
                  mainAxisSpacing: 10,
                  crossAxisSpacing: 10,
                ),
                itemCount: 6,
                itemBuilder: (context, index) {
                  return Container(
                    color: Colors.blue[(index + 1) * 100],
                    child: Center(child: Text("Grid ${index + 1}")),
                  );
                },
              ),

              const SizedBox(height: 30),
              const Text("4. ListView Builder & Separated", style: TextStyle(fontWeight: FontWeight.bold)),
              // WIDGET LISTVIEW.BUILDER
              const Text("Builder:", style: TextStyle(fontSize: 12, color: Colors.grey)),
              ListView.builder(
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                itemCount: 3,
                itemBuilder: (context, index) => Text(items[index]),
              ),
              const Divider(),
              // WIDGET LISTVIEW.SEPARATED
              const Text("Separated (dengan garis):", style: TextStyle(fontSize: 12, color: Colors.grey)),
              ListView.separated(
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                itemCount: 3,
                separatorBuilder: (context, index) => const Divider(color: Colors.black),
                itemBuilder: (context, index) => Padding(
                  padding: const EdgeInsets.symmetric(vertical: 8.0),
                  child: Text("Data Separated ${index + 1}"),
                ),
              ),

              const SizedBox(height: 40),
              Center(child: Text("Afrizal Dwi Nugraha - 2311102136", style: TextStyle(color: Colors.grey[600]))),
            ],
          ),
        ),
      ),
    );
  }
}