# 📦 SIPMBG API
#### Sistem Informasi Presensi Makan Bergizi Gratis
SIPMBG adalah aplikasi berbasis web yang dirancang untuk mengelola dan memantau presensi peserta dalam program Makan Bergizi Gratis (MBG) secara digital, terstruktur, dan real-time. Sistem ini membantu sekolah atau instansi penyelenggara dalam memastikan distribusi makanan bergizi berjalan tepat sasaran, transparan, dan terdokumentasi dengan baik.
Melalui SIPMBG, proses pencatatan kehadiran peserta dilakukan secara cepat menggunakan metode digital fingerprint. Data presensi tersimpan secara otomatis dalam database dan dapat diakses dalam bentuk laporan.

## ✨ Features  
- Authentication
- Schools Endpoint


## ⚙️ Installation & 🚀 Usage 
##### Clone Project
```
git clone https://github.com/ASNProject/sipmbg-api.git
```
<b > Jika menggunakan xampp/ Windows, download file dan simpan di dalam C:/xampp/htdocs</b>

- Rename .env.example dengan .env dan sesuaikan pengaturan DB seperti dibawah
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_sipmbg
DB_USERNAME=root
DB_PASSWORD=
```

- Download database di folder ```sql``` dan import di mysql

##### Run Project
- Run Composer
```
composer update
```

- Run server
```
php artisan serve
```
- Development (For localhost)
```
php artisan serve --host=0.0.0.0 --port=8000
```
- Web Access
```
127.0.0.1:8000
```

#### Route
##### Register
- Post
```
Route : http://127.0.0.1:8000/api/register
```
```
Body: 
{
  "name": "admin",
  "password": "123456",
  "password_confirmation": "123456",
  "email": "admin@gmail.com"
}
```

##### Login
- Post
```
Route : http://127.0.0.1:8000/api/login
```
```
Body: 
{
    "name": "admin",
    "password": "123456"
}
```

##### Logout
- Post
```
Route : http://127.0.0.1:8000/api/logout
```

##### Profil
- Get 
```
Route : http://127.0.0.1:8000/api/profile
```

##### Schools
- Create (POST)
```
Route : http://127.0.0.1:8000/api/schools
```
```
Body: 
{
    "school_name": "SD Negeri 2 Yogyakarta",
    "school_address": "Yogyakarta",
    "school_phone": "0274123456",
    "school_capacity": 200
}
```

- List Data (GET)
```
Route : http://127.0.0.1:8000/api/schools
```

- Detail Data (GET)
```
Route : http://127.0.0.1:8000/api/schools/{id}
```

- Update Data (PUT)
```
Route : http://127.0.0.1:8000/api/schools/{id}
```
```
Body: 
{
    "school_name": "SD Negeri 2 Yogyakarta",
    "school_address": "Yogyakarta",
    "school_phone": "0274123456",
    "school_capacity": 200
}
```

- Delete Data (DELETE)
```
Route : http://127.0.0.1:8000/api/schools/{id}
```

##### Students
- Create (POST)
```
Route : http://127.0.0.1:8000/api/students
```
```
Body: 
{
    "fingerprint_id": "F1235",
    "student_name": "Rais",
    "student_address": "Yogyakarta",
    "student_phone": "081234567890",
    "student_class":"8",
    "school_id":"1"
}
```

- List Data (GET)
```
Route : http://127.0.0.1:8000/api/students
```

- Detail Data (GET)
```
Route : http://127.0.0.1:8000/api/students/{id}
```

- Update Data (PUT)
```
Route : http://127.0.0.1:8000/api/students/{id}
```
```
Body: 
{
    "fingerprint_id": "F1235",
    "student_name": "Rais",
    "student_address": "Yogyakarta",
    "student_phone": "081234567890",
    "student_class":"8",
    "school_id":"1"
}
```

- Delete Data (DELETE)
```
Route : http://127.0.0.1:8000/api/schools/{id}
```

##### Attendance
- Create (POST)
```
Route : http://127.0.0.1:8000/api/attendances/{fingerprint_id}
```

- List Data (GET)
```
Route : http://127.0.0.1:8000/api/attendances
```

- Detail Data (GET)
```
Route : http://127.0.0.1:8000/api/attendances/{id}
```

- Delete Data (DELETE)
```
Route : http://127.0.0.1:8000/api/attendances/{id}
```


## Notes
- Versi Larvel 12.0

## Production
### .htaccess
```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```