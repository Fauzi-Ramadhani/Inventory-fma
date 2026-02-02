# Panduan Deploy Inventory FMA ke Render.com (Gratis)

## **Pendahuluan**
Render.com menawarkan hosting gratis untuk aplikasi web dengan resource yang wajar. Anda bisa menggunakan layanan ini tanpa biaya sama sekali untuk tujuan trial atau testing.

## **Langkah-langkah Deploy**

### **1. Persiapan**
Pastikan Anda memiliki:
- Akun GitHub (https://github.com)
- Akun Render.com (https://render.com - gratis)
- Git terinstal di komputer Anda

### **2. Push Project ke GitHub**

#### **a. Buat Repository GitHub**
1. Buka https://github.com
2. Klik "New" untuk membuat repository baru
3. Beri nama repository (misal: `inventory-fma`)
4. Pilih "Public" (untuk gratis)
5. Klik "Create repository"

#### **b. Push Local Project ke GitHub**
Buka terminal (CMD) dan jalankan perintah berikut di direktori project:

```bash
# Inisialisasi git (jika belum)
git init

# Tambahkan semua file
git add .

# Commit perubahan
git commit -m "Initial commit - Inventory FMA System"

# Hubungkan ke repository GitHub
git remote add origin https://github.com/[username]/inventory-fma.git

# Push ke GitHub
git push -u origin main
```

Ganti `[username]` dengan username GitHub Anda.

### **3. Deploy ke Render.com**

#### **a. Hubungkan GitHub ke Render.com**
1. Buka https://render.com dan login
2. Klik "New" > "Web Service"
3. Pilih "Connect to GitHub"
4. Izinkan akses ke repository yang baru saja Anda buat
5. Klik "Connect" pada repository `inventory-fma`

#### **b. Konfigurasi Web Service**
1. **Name**: inventory-fma (atau nama lain yang Anda inginkan)
2. **Region**: Singapore (terdekat dengan Indonesia)
3. **Runtime**: PHP
4. **Build Command**: `composer install --no-dev`
5. **Start Command**: `php -S 0.0.0.0:${PORT} index.php`
6. **Environment Variables**:
   - Tambahkan variable `CI_ENV` dengan nilai `production`
   - Tambahkan variable `BASE_URL` dengan nilai `https://[nama-app].onrender.com/`
   (Ganti `[nama-app]` dengan nama web service Anda)

#### **c. Buat Database**
1. Klik "New" > "PostgreSQL" (atau "MySQL" - gratis juga)
2. **Name**: inventory-fma-db
3. **Region**: Singapore
4. **Plan**: Free
5. Klik "Create Database"

#### **d. Hubungkan Database ke Web Service**
1. Buka halaman Web Service Anda
2. Klik "Environment" tab
3. Klik "Add Environment Variable"
4. Pilih "Connect Database"
5. Pilih database `inventory-fma-db` yang baru saja dibuat
6. Render.com akan secara otomatis menambahkan variable database:
   - DATABASE_HOST
   - DATABASE_PORT
   - DATABASE_USER
   - DATABASE_PASSWORD
   - DATABASE_NAME

### **4. Import Database**

#### **a. Dapatkan Credential Database**
1. Buka halaman database di Render.com
2. Salin informasi koneksi (Host, Port, Username, Password, Database Name)

#### **b. Import SQL File**
Gunakan tool seperti:
- phpMyAdmin (jika menggunakan MySQL)
- pgAdmin (jika menggunakan PostgreSQL)
- Atau terminal (psql untuk PostgreSQL, mysql untuk MySQL)

File SQL untuk import: `DB/ci_inventory.sql`

Contoh perintah import untuk MySQL:
```bash
mysql -h [host] -u [username] -p [database_name] < DB/ci_inventory.sql
```

### **5. Test Aplikasi**
Setelah deploy selesai (biasanya membutuhkan 2-5 menit):
1. Buka URL aplikasi Anda (misal: https://inventory-fma.onrender.com)
2. Coba login dengan akun default (jika ada)
3. Test fitur-fitur utama aplikasi

## **Fitur Gratis Render.com**
- **Web Service**: 1 instance gratis (0.1 CPU, 512MB RAM)
- **Database**: 1 database gratis (PostgreSQL/MySQL)
- **SSL**: Gratis (HTTPS otomatis)
- **Deploy Otomatis**: Setiap push ke branch main akan deploy ulang aplikasi
- **Custom Domain**: Bisa menambahkan domain sendiri (gratis dengan cert SSL)

## **Tips Penggunaan Gratis**
1. **Scale Down**: Setelah trial selesai, bisa di-scale down ke plan gratis
2. **Monitor Usage**: Periksa dashboard Render.com untuk melihat penggunaan resource
3. **Auto-sleep**: Web service akan tidur jika tidak dipakai selama 15 menit (untuk menghemat resource)

## **Troubleshooting**
- **Application Error**: Periksa log di tab "Logs" Render.com
- **Database Connection**: Pastikan credential database benar
- **File Upload**: Pastikan folder `upload/` memiliki izin write (chmod 755)
- **Composer**: Pastikan semua dependency di `composer.json` benar

## **Alternative Free Hosting**
Jika Render.com tidak sesuai, Anda bisa mencoba:
- **PythonAnywhere**: Free for 1 website, support PHP
- **000webhost**: Free hosting PHP dengan database MySQL
- **Netlify/Vercel**: Jika menggunakan frontend framework (tidak recommended untuk CodeIgniter)

## **Kontak**
Jika mengalami kesulitan, silakan lihat dokumentasi Render.com: https://render.com/docs