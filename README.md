# Tentang OkiPHPQL
OkiPHPQL merupakan class PHP yang menyederhanakan penulisan dan penggunaan fungsi-fungsi mysql/mysqli yang umum digunakan.
Class ini cocok digunakan dalam program PHP yang menggunakan metode penulisan terstruktur.
Class ini membutuhkan banyak peningkatan dari ketersediaan fungsi, keamanan, validitas kode, efisiensi kode dan lain sebagainya.
Class ini dibuat dengan gaya penulisan kode dasar agar mudah dimengerti dan mudah dikembangkan.

## Struktur Class OkiPHPQL
* `__construct($dbhost=NULL,$dbuser=NULL,$usrpwd=NULL,$dbname=NULL)` dipanggil pada saat inisiasi class dan menerima parameter yang dimasukkan pada saat inisiasi
* `insert($nmtabel,$isi)` fungsi untuk mengeksekusi perintah `INSERT INTO ...`
* `update($nmtabel,$isi,$wh)` fungsi untuk mengeksekusi perintah `UPDATE SET ... WHERE`
* `delete($nmtabel,$isi)` fungsi untuk mengeksekusi perintah `DELETE FROM ... WHERE`
* `select($nmtabel,$wh="",$cols="*")` fungsi untuk mengeksekusi perintah `SELECT FROM ... WHERE`, mempunyai return berupa array asosiatif
* `query($query)` fungsi untuk mengeksekusi query bebas dengan return berupa array asosiatif
* `_where($wh)` fungsi untuk memproses parameter `WHERE` untuk dieksekusi (internal)

## Cara Penggunaan
Class ini dapat digunakan/dimasukkan dengan metode `include`, `require`, atau `require_once`, sama dengan cara menggunakan class biasanya.
Inisiasi class:
```
	require_once('OkiPHPQL.php');
	$mysql	= new OkiPHPQL();
```

### Setting Koneksi Database
Koneksi database bisa ditentukan langsung di kelas atau ditentukan dengan cara memberikan parameter koneksi pada saat inisiasi kelas.

#### Setting Koneksi Database Dalam Class
* Edit OkiPHPQL.php
* Navigasi/masuk ke fungsi `__construct()`
* Sesuaikan isi variabel (yang terletak setelah `// setting koneksi`) `$dbhost`, `$dbuser`, `$usrpwd`, dan `$dbname` dengan konfigurasi yang diperlukan.
* Simpan perubahan file
* Maka, setiap kali class OkiPHPQL dipanggil/diinisiasi, koneksi database akan terbentuk dengan konfigurasi tadi (jika pada saat inisiasi parameter kelasnya dikosongkan)

#### Setting Koneksi Database Dalam Inisiasi Class
Class OkiPHPQL dapat menerima parameter operan dengan urutan sebagai berikut : `$dbname`, `$dbuser`, `$usrpwd`, `$dbname`;
Pada kode program setelah memasukkan file `OkiPHPQL.php` menggunakan `include`, `require`, atau `require_once`:
* Tentukan parameter koneksi database dan passing ke dalam class
* Contoh:
```
	require_once('OkiPHPQL.php');
	$dbhost		= "localhost";
	$dbuser		= "root";
	$userpwd	= "123";
	$dbname		= "namadatabase";
	$mysql	= new OkiPHPQL($dbhost,$dbuser,$usrpwd,$dbname);
```

### Contoh Penggunaan
Jangan lupa untuk inisiasi class dengan variabel `$mysql` sebelum menulis contoh-contoh di bawah ini.

#### Melakukan INSERT
Parameter INSERT dibuat dalam bentuk array asosiatif. Contoh:
```
$tabel	= "namatabel";
$record	= array(
	"NamaKolom1"	=> 'isikolom1',
	"NamaKolom2"	=> 'isikolom2',
	"NamaKolom3"	=> 'isikolom3',
	"NamaKolom4"	=> 'isikolom4',
);
$mysql->insert($tabel,$record);
```
atau
```
$tabel	= "namatabel";
$record["NamaKolom1"]	= 'isikolom1';
$record["NamaKolom2"]	= 'isikolom2';
$record["NamaKolom3"]	= 'isikolom3';
$record["NamaKolom4"]	= 'isikolom4';
$mysql->insert($tabel,$record);
```
Kode di atas akan menghasilkan dan menjalankan query sebagai berikut:
```
INSERT INTO `namatabel` (`NamaKolom1`,`NamaKolom2`,`NamaKolom3`,`NamaKolom4`) VALUES ('isikolom1','isikolom2','isikolom3','isikolom4')
```

#### Melakukan UPDATE
