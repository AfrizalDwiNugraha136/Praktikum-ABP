# Struktur Project
toko-cokomi-wowo/
├── app/Http/Controllers/
│   ├── Auth/ (Breeze)
│   └── ProductController.php
├── app/Models/
│   ├── User.php
│   └── Product.php
├── database/
│   ├── factories/ProductFactory.php
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       └── ProductSeeder.php
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── auth/ (Breeze)
│   └── products/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
└── routes/web.php
