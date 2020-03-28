<?php
use RealRashid\SweetAlert\Facades\Alert;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    // toast('Halo Selamat Datang','success');
    return redirect('/home');
});

Auth::routes();
Route::get('/home', 'HomeController@index');



Route::group(['middleware'=>'auth'],function(){
    
View::composer('layouts.layout', function($view)
{
    $view->with('name', Auth::check() ? Auth::user()->firstname : '');
});


Route::post('/ubah/password','HomeController@ubah_password');

// Pengguna Controller

Route::get('/DaftarKanpengurus', 'PenggunaController@DaftarKanpengurus');
Route::post('/DaftarKanpengurusPOST', 'PenggunaController@DaftarKanpengurusPOST');
Route::post('/DaftarKanpiketPOST', 'PenggunaController@DaftarKanpiketPOST');
// Akhir Tambah User Controller

Route::get('/pengurus', 'PenggunaController@pengurus');
Route::get('/pengguna/hapus/{id}', 'PenggunaController@pengguna_hapus');
Route::post('/foto_pengguna_ubah', 'PenggunaController@foto_pengguna_ubah');

// Instruktur Nilai
Route::get('/input_nilai_senbud/{id_senbud}', 'SenbudController@input_nilai_senbud');
Route::post('/input_nilai_senbud_post', 'SenbudController@input_nilai_senbud_post');
Route::get('/lihat_nilai_senbud/{id_senbud}', 'SenbudController@lihat_nilai_senbud');
Route::get('/lihat_detail_nilai_senbud/{keterangan_nilai_senbud}', 'SenbudController@lihat_detail_nilai_senbud');
Route::get('/hapus_nilai_senbud/{id_keterangan_nilai_senbud}', 'SenbudController@hapus_nilai_senbud');
Route::get('/nilai_senbud_ubah', 'SenbudController@nilai_senbud_ubah');
Route::post('/nilai_senbud_ubah_post', 'SenbudController@nilai_senbud_ubah_post');
Route::get('/export_nilai_senbud/{keterangan_nilai}', 'SenbudController@export_nilai_senbud');

Route::get('/input_nilai_ekskul_biasa/{id_ekskul_biasa}', 'EkskulBiasaController@input_nilai_ekskul_biasa');
Route::post('/input_nilai_ekskul_biasa_post', 'EkskulBiasaController@input_nilai_ekskul_biasa_post');
Route::get('/lihat_nilai_ekskul_biasa/{id_ekskul_biasa}', 'EkskulBiasaController@lihat_nilai_ekskul_biasa');
Route::get('/lihat_detail_nilai_ekskul_biasa/{keterangan_nilai_ekskul_biasa}', 'EkskulBiasaController@lihat_detail_nilai_ekskul_biasa');
Route::get('/hapus_nilai_ekskul_biasa/{id_keterangan_nilai_ekskul_biasa}', 'EkskulBiasaController@hapus_nilai_ekskul_biasa');
Route::get('/nilai_ekskul_biasa_ubah', 'EkskulBiasaController@nilai_ekskul_biasa_ubah');
Route::post('/nilai_ekskul_biasa_ubah_post', 'EkskulBiasaController@nilai_ekskul_biasa_ubah_post');
Route::get('/export_nilai_ekskul_biasa/{keterangan_nilai}', 'EkskulBiasaController@export_nilai_ekskul_biasa');

Route::get('/input_nilai_ekskul_produktif/{id_ekskul_produktif}', 'EkskulProduktifController@input_nilai_ekskul_produktif');
Route::post('/input_nilai_ekskul_produktif_post', 'EkskulProduktifController@input_nilai_ekskul_produktif_post');
Route::get('/lihat_nilai_ekskul_produktif/{id_ekskul_produktif}', 'EkskulProduktifController@lihat_nilai_ekskul_produktif');
Route::get('/lihat_detail_nilai_ekskul_produktif/{keterangan}', 'EkskulProduktifController@lihat_detail_nilai_ekskul_produktif');
Route::get('/hapus_nilai_ekskul_produktif/{id}', 'EkskulProduktifController@hapus_nilai_ekskul_produktif');
Route::get('/nilai_ekskul_produktif_ubah', 'EkskulProduktifController@nilai_ekskul_produktif_ubah');
Route::post('/nilai_ekskul_produktif_ubah_post', 'EkskulProduktifController@nilai_ekskul_produktif_ubah_post');
Route::get('/export_nilai_ekskul_produktif/{keterangan_nilai}', 'EkskulProduktifController@export_nilai_ekskul_produktif');

Route::get('/input_nilai_keputrian/{id_keputrian}', 'KeputrianController@input_nilai_keputrian');
Route::post('/input_nilai_keputrian_post', 'KeputrianController@input_nilai_keputrian_post');
Route::get('/lihat_nilai_keputrian/{id_keputrian}', 'KeputrianController@lihat_nilai_keputrian');
Route::get('/lihat_detail_nilai_keputrian/{keterangan_nilai_keputrian}', 'KeputrianController@lihat_detail_nilai_keputrian');
Route::get('/hapus_nilai_keputrian/{id_keterangan_nilai_keputrian}', 'KeputrianController@hapus_nilai_keputrian');
Route::get('/nilai_keputrian_ubah', 'KeputrianController@nilai_keputrian_ubah');
Route::post('/nilai_keputrian_ubah_post', 'KeputrianController@nilai_keputrian_ubah_post');
Route::get('/export_nilai_keputrian/{keterangan_nilai}', 'KeputrianController@export_nilai_keputrian');
// Akhir Instruktur Nilai

Route::get('/instruktur_kehadiran/{id}', 'PenggunaController@instruktur_kehadiran');
Route::get('/instruktur_kehadiran_senbud/{id_senbud}/{instruktur_senbud_id}', 'PenggunaController@instruktur_kehadiran_senbud');
Route::get('/instruktur_kehadiran_ekskul_biasa/{id_ekskul_biasa}/{instruktur_ekskul_biasa_id}', 'PenggunaController@instruktur_kehadiran_ekskul_biasa');
Route::get('/instruktur_kehadiran_ekskul_produktif/{id_ekskul_produktif}/{instruktur_ekskul_produktif_id}', 'PenggunaController@instruktur_kehadiran_ekskul_produktif');
Route::get('/instruktur_kehadiran_keputrian/{id_keputrian}/{instruktur_keputrian_id}', 'PenggunaController@instruktur_kehadiran_keputrian');
Route::get('/instruktur', 'PenggunaController@instruktur');
Route::get('/input_absen_instruktur/{id}', 'PiketController@input_absen_instruktur');
Route::get('/piket', 'PenggunaController@piket');
Route::get('/pengguna/detail/{id}', 'PenggunaController@pengguna_detail');
Route::post('/instuktur_data_pribadi/update', 'PenggunaController@instruktur_data_pribadi_update');
Route::post('/instruktur_akun/update', 'PenggunaController@instruktur_akun_update');


Route::get('/siswa', 'PenggunaController@siswa');
Route::get('/instruktur/ekskul/detail/{id_ekskul}/{id}', 'PenggunaController@instruktur_ekskul_detail');
Route::get('/pengguna/aktif/{id}', 'PenggunaController@ubah_aktif');
Route::post('/pengguna_data_pribadi/update', 'PenggunaController@pengguna_data_pribadi_update');
Route::post('/pengguna_akun/update', 'PenggunaController@pengguna_akun_update');
Route::get('/siswa/detail/{id}', 'PenggunaController@siswa_detail');
Route::post('/tambah/siswa', 'PenggunaController@tambah_siswa_post');
Route::post('/tambah/instruktur', 'PenggunaController@tambah_instruktur_post');
Route::post('/tambah/pengurus', 'PenggunaController@tambah_pengurus_post');
Route::get('/pengguna/nonaktif', 'PenggunaController@pengguna_nonaktif');
// Akhir Pengguna Controller

// Rombel Controller
Route::get('/rombel', 'AdminController@rombel')->middleware('admin_level');;
// Route::get('/rombel/hapus/{id_rombel}', 'AdminController@rombel_hapus');
Route::get('/rombel/detail/{id_rombel}', 'AdminController@rombel_detail');
Route::get('/rombel/edit/{id_rombel}', 'AdminController@rombel_edit');
Route::post('/rombel/store', 'AdminController@rombel_store');
Route::post('/rombel/update', 'AdminController@rombel_update');
Route::post('/pindahkan/rombel', 'AdminController@pindahkan_rombel');
// Akhir Rombel Controller


// Rayon Controller
Route::get('/rayon', 'AdminController@rayon');
Route::get('/rayon/hapus/{id_rayon}', 'AdminController@rayon_hapus');
Route::get('/rayon/detail/{id_rayon}', 'AdminController@rayon_detail');
Route::get('/rayon/edit/{id_rayon}', 'AdminController@rayon_edit');
Route::post('/rayon/store', 'AdminController@rayon_store');
Route::post('/rayon/update', 'AdminController@rayon_update');
Route::post('/pindahkan/rayon', 'AdminController@pindahkan_rayon');
// Akhir Rayon Controller


// Jurusan Controller
Route::get('/jurusan', 'AdminController@jurusan');
// Route::get('/jurusan/hapus/{id_jurusan}', 'AdminController@jurusan_hapus');
Route::get('/jurusan/detail/{id_jurusan}', 'AdminController@jurusan_detail');
Route::get('/jurusan/edit/{id_jurusan}', 'AdminController@jurusan_edit');
Route::post('/jurusan/store', 'AdminController@jurusan_store');
Route::post('/jurusan/update', 'AdminController@jurusan_update');
Route::post('/pindahkan/jurusan', 'AdminController@pindahkan_jurusan');
// Akhir Jurusan Controller


// Senbud Controller
Route::get('/senbud', 'SenbudController@senbud');
// Route::get('/senbud/hapus/{id_senbud}', 'SenbudController@senbud_hapus');
Route::get('/senbud/detail/{id_senbud}/{instruktur_id}', 'SenbudController@senbud_detail');
Route::get('/detail/senbud/siswa/{id_siswa}', 'SenbudController@detail_senbud_siswa');
Route::post('/senbud/update', 'SenbudController@senbud_update');
Route::post('/senbud/store', 'SenbudController@senbud_store');
Route::post('/pindahkan/senbud', 'AdminController@pindahkan_senbud');
// Akhir Senbud Controller

// keputrian Controller
Route::get('/keputrian', 'KeputrianController@keputrian');
// Route::get('/keputrian/hapus/{id_keputrian}', 'KeputrianController@keputrian_hapus');
Route::get('/keputrian/detail/{id_keputrian}/{instruktur_id}', 'KeputrianController@keputrian_detail');
Route::get('/detail/keputrian/siswa/{id_siswa}', 'KeputrianController@detail_keputrian_siswa');
Route::post('/keputrian/update', 'KeputrianController@keputrian_update');
Route::post('/keputrian/store', 'KeputrianController@keputrian_store');
Route::post('/pindahkan/keputrian', 'KeputrianController@pindahkan_keputrian');
// Akhir keputrian Controller

// ekskul_biasa Controller
Route::get('/ekskul/biasa', 'EkskulBiasaController@ekskul_biasa');
// Route::get('/ekskul/biasa/hapus/{id_ekskul_biasa}', 'EkskulBiasaController@ekskul_biasa_hapus');
Route::get('/ekskul_biasa/detail/{id_ekskul_biasa}/{instruktur_id}', 'EkskulBiasaController@ekskul_biasa_detail');
Route::get('/detail/ekskul/biasa/siswa/{id_siswa}', 'EkskulBiasaController@detail_ekskul_biasa_siswa');
Route::post('/ekskul_biasa/update', 'EkskulBiasaController@ekskul_biasa_update');
Route::post('/ekskul_biasa/store', 'EkskulBiasaController@ekskul_biasa_store');
Route::post('/pindahkan/ekskul_biasa', 'EkskulBiasaController@pindahkan_ekskul_biasa');
// Akhir ekskul_biasa Controller

// ekskul_produktif Controller
Route::get('/ekskul/produktif', 'EkskulProduktifController@ekskul_produktif');
// Route::get('/ekskul/produktif/hapus/{id_ekskul_produktif}', 'EkskulProduktifController@ekskul_produktif_hapus');
Route::get('/ekskul_produktif/detail/{id_ekskul_produktif}/{instruktur_id}', 'EkskulProduktifController@ekskul_produktif_detail');
Route::get('/detail/ekskul/produktif/siswa/{id_siswa}', 'EkskulProduktifController@detail_ekskul_produktif_siswa');
Route::post('/ekskul_produktif/update', 'EkskulProduktifController@ekskul_produktif_update');
Route::post('/ekskul_produktif/store', 'EkskulProduktifController@ekskul_produktif_store');
Route::post('/pindahkan/ekskul_produktif', 'EkskulProduktifController@pindahkan_ekskul_produktif');
// Akhir ekskul_produktif Controller



// INSTRUKTUR Controller
Route::get('/dashboard_instruktur', 'InstrukturController@dashboard_instruktur');
// Senbud
Route::get('/input/absen/senbud', 'SenbudController@input_absen_senbud');
Route::post('/input/absen/senbud', 'SenbudController@input_absen_senbud_post');
Route::get('/input_absen_instruktur_senbud', 'SenbudController@input_absen_instruktur_senbud');
Route::post('/input_absen_instruktur_senbud', 'SenbudController@input_absen_instruktur_senbud_post');
Route::get('/data_kehadiran_instruktur_senbud_ubah/{id_absen_instruktur_senbud}', 'SenbudController@data_kehadiran_instruktur_senbud_ubah');
Route::post('/data_kehadiran_instruktur_senbud_ubah_post', 'SenbudController@data_kehadiran_instruktur_senbud_ubah_post');
Route::get('/data_kehadiran_instruktur_senbud_hapus/{id_absen_instruktur_senbud}', 'SenbudController@data_kehadiran_instruktur_senbud_hapus');
Route::get('/kehadiran_instruktur_senbud/{id_senbud}', 'SenbudController@kehadiran_instruktur_senbud');
Route::get('/kehadiran_instruktur_senbud/detail/{tgl_absen_senbud}/{tgl_absen_senbud_id}', 'SenbudController@kehadiran_instruktur_senbud_detail');
Route::get('/filter_senbud_alpa', 'SenbudController@filter_senbud_alpa');
Route::get('/data_senbud/{id_senbud}', 'SenbudController@data_senbud');
Route::get('/data/senbud/siswa/{id}/{senbud_id}', 'SenbudController@data_senbud_siswa');
Route::get('/data_senbud_siswa_ubah', 'SenbudController@data_senbud_siswa_ubah');
Route::post('/data_senbud_siswa_ubah_post', 'SenbudController@data_senbud_siswa_ubah_post');
Route::get('/data_kehadiran_senbud_ubah', 'SenbudController@data_kehadiran_senbud_ubah');
Route::post('/data_kehadiran_senbud_ubah_post', 'SenbudController@data_kehadiran_senbud_ubah_post');
Route::get('/kehadiran/senbud/{id_senbud}', 'SenbudController@kehadiran_senbud');
Route::get('/kehadiran/senbud/detail/{tgl_absen_senbud}/{tgl_absen_senbud_id}', 'SenbudController@kehadiran_senbud_detail');
Route::get('/kehadiran/senbud/hapus/{tgl_absen_senbud}', 'SenbudController@kehadiran_senbud_hapus');
Route::post('/keterangan_kehadiran_update', 'SenbudController@keterangan_kehadiran_update');
Route::post('/upload_senbud_foto', 'SenbudController@upload_senbud_foto');
Route::get('/gambar_senbud_hapus/{id_gambar_senbud}', 'SenbudController@gambar_senbud_hapus');
Route::post('/ubah_foto_senbud', 'SenbudController@ubah_foto_senbud');
Route::get('/export/data_senbud/{id_senbud}', 'SenbudController@export_data_senbud');
Route::get('/export/data_senbud_alpa/{id_senbud}', 'SenbudController@export_data_senbud_alpa');
Route::get('/export/kehadiran_senbud_export/{tgl_absen_senbud_detail}/{id_senbud}', 'SenbudController@export_kehadiran_senbud');
Route::get('/export/kehadiran_senbud_persiswa_export/{id}', 'SenbudController@export_kehadiran_senbud_persiswa');

// Ekskul Biasa
Route::get('/input/absen/ekskul_biasa', 'EkskulBiasaController@input_absen_ekskul_biasa');
Route::post('/input/absen/ekskul_biasa', 'EkskulBiasaController@input_absen_ekskul_biasa_post');
Route::get('/input_absen_instruktur_ekskul_biasa', 'EkskulBiasaController@input_absen_instruktur_ekskul_biasa');
Route::post('/input_absen_instruktur_ekskul_biasa', 'EkskulBiasaController@input_absen_instruktur_ekskul_biasa_post');
Route::get('/data_kehadiran_instruktur_ekskul_biasa_ubah/{id_absen_instruktur_ekskul_biasa}', 'EkskulBiasaController@data_kehadiran_instruktur_ekskul_biasa_ubah');
Route::post('/data_kehadiran_instruktur_ekskul_biasa_ubah_post', 'EkskulBiasaController@data_kehadiran_instruktur_ekskul_biasa_ubah_post');
Route::get('/data_kehadiran_instruktur_ekskul_biasa_hapus/{id_absen_instruktur_ekskul_biasa}', 'EkskulBiasaController@data_kehadiran_instruktur_ekskul_biasa_hapus');
Route::get('/kehadiran_instruktur_ekskul_biasa/{id_ekskul_biasa}', 'EkskulBiasaController@kehadiran_instruktur_ekskul_biasa');
Route::get('/kehadiran_instruktur_ekskul_biasa/detail/{tgl_absen_ekskul_biasa}/{tgl_absen_ekskul_biasa_id}', 'EkskulBiasaController@kehadiran_instruktur_ekskul_biasa_detail');
Route::get('/filter_ekskul_biasa_alpa', 'EkskulBiasaController@filter_ekskul_biasa_alpa');
Route::get('/data_ekskul_biasa/{id_ekskul_biasa}', 'EkskulBiasaController@data_ekskul_biasa');
Route::get('/data/ekskul_biasa/siswa/{id}/{ekskul_biasa_id}', 'EkskulBiasaController@data_ekskul_biasa_siswa');
Route::get('/data_ekskul_biasa_siswa_ubah', 'EkskulBiasaController@data_ekskul_biasa_siswa_ubah');
Route::post('/data_ekskul_biasa_siswa_ubah_post', 'EkskulBiasaController@data_ekskul_biasa_siswa_ubah_post');
Route::get('/data_kehadiran_ekskul_biasa_ubah', 'EkskulBiasaController@data_kehadiran_ekskul_biasa_ubah');
Route::post('/data_kehadiran_ekskul_biasa_ubah_post', 'EkskulBiasaController@data_kehadiran_ekskul_biasa_ubah_post');
Route::get('/kehadiran/ekskul_biasa/{id_ekskul_biasa}', 'EkskulBiasaController@kehadiran_ekskul_biasa');
Route::get('/kehadiran/ekskul_biasa/detail/{tgl_absen_ekskul_biasa}/{tgl_absen_ekskul_biasa_id}', 'EkskulBiasaController@kehadiran_ekskul_biasa_detail');
Route::get('/kehadiran/ekskul_biasa/hapus/{tgl_absen_ekskul_biasa}', 'EkskulBiasaController@kehadiran_ekskul_biasa_hapus');
Route::post('/keterangan_kehadiran_update', 'EkskulBiasaController@keterangan_kehadiran_update');
Route::post('/upload_ekskul_biasa_foto', 'EkskulBiasaController@upload_ekskul_biasa_foto');
Route::get('/gambar_ekskul_biasa_hapus/{id_gambar_ekskul_biasa}', 'EkskulBiasaController@gambar_ekskul_biasa_hapus');
Route::post('/ubah_foto_ekskul_biasa', 'EkskulBiasaController@ubah_foto_ekskul_biasa');
Route::get('/export/data_ekskul_biasa/{id_ekskul_biasa}', 'EkskulBiasaController@export_data_ekskul_biasa');
Route::get('/export/data_ekskul_biasa_alpa/{id_ekskul_biasa}', 'EkskulBiasaController@export_data_ekskul_biasa_alpa');
Route::get('/export/kehadiran_ekskul_biasa_export/{tgl_absen_ekskul_biasa_detail}/{id_ekskul_biasa}', 'EkskulBiasaController@export_kehadiran_ekskul_biasa');
Route::get('/export/kehadiran_ekskul_biasa_persiswa_export/{id}', 'EkskulBiasaController@export_kehadiran_ekskul_biasa_persiswa');

// Keputrian
Route::get('/input/absen/keputrian', 'KeputrianController@input_absen_keputrian');
Route::post('/input/absen/keputrian', 'KeputrianController@input_absen_keputrian_post');
Route::get('/input_absen_instruktur_keputrian', 'KeputrianController@input_absen_instruktur_keputrian');
Route::post('/input_absen_instruktur_keputrian', 'KeputrianController@input_absen_instruktur_keputrian_post');
Route::get('/data_kehadiran_instruktur_keputrian_ubah/{id_absen_instruktur_keputrian}', 'KeputrianController@data_kehadiran_instruktur_keputrian_ubah');
Route::post('/data_kehadiran_instruktur_keputrian_ubah_post', 'KeputrianController@data_kehadiran_instruktur_keputrian_ubah_post');
Route::get('/data_kehadiran_instruktur_keputrian_hapus/{id_absen_instruktur_keputrian}', 'KeputrianController@data_kehadiran_instruktur_keputrian_hapus');
Route::get('/kehadiran_instruktur_keputrian/{id_keputrian}', 'KeputrianController@kehadiran_instruktur_keputrian');
Route::get('/kehadiran_instruktur_keputrian/detail/{tgl_absen_keputrian}/{tgl_absen_keputrian_id}', 'KeputrianController@kehadiran_instruktur_keputrian_detail');
Route::get('/filter_keputrian_alpa', 'KeputrianController@filter_keputrian_alpa');
Route::get('/data_keputrian/{id_keputrian}', 'KeputrianController@data_keputrian');
Route::get('/data/keputrian/siswa/{id}/{keputrian_id}', 'KeputrianController@data_keputrian_siswa');
Route::get('/data_keputrian_siswa_ubah', 'KeputrianController@data_keputrian_siswa_ubah');
Route::post('/data_keputrian_siswa_ubah_post', 'KeputrianController@data_keputrian_siswa_ubah_post');
Route::get('/data_kehadiran_keputrian_ubah', 'KeputrianController@data_kehadiran_keputrian_ubah');
Route::post('/data_kehadiran_keputrian_ubah_post', 'KeputrianController@data_kehadiran_keputrian_ubah_post');
Route::get('/kehadiran/keputrian/{id_keputrian}', 'KeputrianController@kehadiran_keputrian');
Route::get('/kehadiran/keputrian/detail/{tgl_absen_keputrian}/{tgl_absen_keputrian_id}', 'KeputrianController@kehadiran_keputrian_detail');
Route::get('/kehadiran/keputrian/hapus/{tgl_absen_keputrian}', 'KeputrianController@kehadiran_keputrian_hapus');
Route::post('/keterangan_kehadiran_update', 'KeputrianController@keterangan_kehadiran_update');
Route::post('/upload_keputrian_foto', 'KeputrianController@upload_keputrian_foto');
Route::get('/gambar_keputrian_hapus/{id_gambar_keputrian}', 'KeputrianController@gambar_keputrian_hapus');
Route::post('/ubah_foto_keputrian', 'KeputrianController@ubah_foto_keputrian');
Route::get('/export/data_keputrian/{id_keputrian}', 'KeputrianController@export_data_keputrian');
Route::get('/export/data_keputrian_alpa/{id_keputrian}', 'KeputrianController@export_data_keputrian_alpa');
Route::get('/export/kehadiran_keputrian_export/{tgl_absen_keputrian_detail}/{id_keputrian}', 'KeputrianController@export_kehadiran_keputrian');
Route::get('/export/kehadiran_keputrian_persiswa_export/{id}', 'KeputrianController@export_kehadiran_keputrian_persiswa');

// Ekskul Produktif
Route::get('/input/absen/ekskul_produktif', 'EkskulProduktifController@input_absen_ekskul_produktif');
Route::post('/input/absen/ekskul_produktif', 'EkskulProduktifController@input_absen_ekskul_produktif_post');
Route::get('/input_absen_instruktur_ekskul_produktif', 'EkskulProduktifController@input_absen_instruktur_ekskul_produktif');
Route::post('/input_absen_instruktur_ekskul_produktif', 'EkskulProduktifController@input_absen_instruktur_ekskul_produktif_post');
Route::get('/data_kehadiran_instruktur_ekskul_produktif_ubah/{id}', 'EkskulProduktifController@data_kehadiran_instruktur_ekskul_produktif_ubah');
Route::post('/data_kehadiran_instruktur_ekskul_produktif_ubah_post', 'EkskulProduktifController@data_kehadiran_instruktur_ekskul_produktif_ubah_post');
Route::get('/data_kehadiran_instruktur_ekskul_produktif_hapus/{id}', 'EkskulProduktifController@data_kehadiran_instruktur_ekskul_produktif_hapus');
Route::get('/kehadiran_instruktur_ekskul_produktif/{id_ekskul_produktif}', 'EkskulProduktifController@kehadiran_instruktur_ekskul_produktif');
Route::get('/kehadiran_instruktur_ekskul_produktif/detail/{tgl_absen_ekskul_produktif}/{tgl_absen_ekskul_produktif_id}', 'EkskulProduktifController@kehadiran_instruktur_ekskul_produktif_detail');
Route::get('/filter_ekskul_produktif_alpa', 'EkskulProduktifController@filter_ekskul_produktif_alpa');
Route::get('/data_ekskul_produktif/{id_ekskul_produktif}', 'EkskulProduktifController@data_ekskul_produktif');
Route::get('/data/ekskul_produktif/siswa/{id}/{ekskul_produktif_id}', 'EkskulProduktifController@data_ekskul_produktif_siswa');
Route::get('/data_ekskul_produktif_siswa_ubah', 'EkskulProduktifController@data_ekskul_produktif_siswa_ubah');
Route::post('/data_ekskul_produktif_siswa_ubah_post', 'EkskulProduktifController@data_ekskul_produktif_siswa_ubah_post');
Route::get('/data_kehadiran_ekskul_produktif_ubah', 'EkskulProduktifController@data_kehadiran_ekskul_produktif_ubah');
Route::post('/data_kehadiran_ekskul_produktif_ubah_post', 'EkskulProduktifController@data_kehadiran_ekskul_produktif_ubah_post');
Route::get('/kehadiran/ekskul_produktif/{id_ekskul_produktif}', 'EkskulProduktifController@kehadiran_ekskul_produktif');
Route::get('/kehadiran/ekskul_produktif/detail/{tgl_absen_ekskul_produktif}/{tgl_absen_ekskul_produktif_id}', 'EkskulProduktifController@kehadiran_ekskul_produktif_detail');
Route::get('/kehadiran/ekskul_produktif/hapus/{tgl_absen_ekskul_produktif}', 'EkskulProduktifController@kehadiran_ekskul_produktif_hapus');
Route::post('/keterangan_kehadiran_update', 'EkskulProduktifController@keterangan_kehadiran_update');
Route::post('/upload_ekskul_produktif_foto', 'EkskulProduktifController@upload_ekskul_produktif_foto');
Route::get('/gambar_ekskul_produktif_hapus/{id_gambar_ekskul_produktif}', 'EkskulProduktifController@gambar_ekskul_produktif_hapus');
Route::post('/ubah_foto_ekskul_produktif', 'EkskulProduktifController@ubah_foto_ekskul_produktif');
Route::get('/export/data_ekskul_produktif/{id_ekskul_produktif}', 'EkskulProduktifController@export_data_ekskul_produktif');
Route::get('/export/data_ekskul_produktif_alpa/{id_ekskul_produktif}', 'EkskulProduktifController@export_data_ekskul_produktif_alpa');
Route::get('/export/kehadiran_ekskul_produktif_export/{tgl}/{id_ekskul_produktif}', 'EkskulProduktifController@export_kehadiran_ekskul_produktif');
Route::get('/export/kehadiran_ekskul_produktif_persiswa_export/{id}', 'EkskulProduktifController@export_kehadiran_ekskul_produktif_persiswa');


// Route::get('/input/absen/ekskul_biasa', 'EkskulBiasaController@input_absen_ekskul_biasa');
// Route::post('/input/absen/ekskul_biasa', 'EkskulBiasaController@input_absen_ekskul_biasa_post');
// Route::get('/data_ekskul_biasa/{id_ekskul_biasa}', 'EkskulBiasaController@data_ekskul_biasa');
// Route::get('/data/ekskul_biasa/siswa/{id}/{ekskul_biasa_id}', 'EkskulBiasaController@data_ekskul_biasa_siswa');
// Route::get('/data_ekskul_biasa_siswa_ubah', 'EkskulBiasaController@data_ekskul_biasa_siswa_ubah');
// Route::post('/data_ekskul_biasa_siswa_ubah_post', 'EkskulBiasaController@data_ekskul_biasa_siswa_ubah_post');
// Route::get('/kehadiran/ekskul_biasa/{id_ekskul_biasa}', 'EkskulBiasaController@kehadiran_ekskul_biasa');
// Route::get('/kehadiran/ekskul_biasa/detail/{tgl_absen_ekskul_biasa}/{tgl_absen_ekskul_biasa_id}', 'EkskulBiasaController@kehadiran_ekskul_biasa_detail');
// Route::get('/kehadiran/ekskul_biasa/hapus/{tgl_absen_ekskul_biasa}', 'EkskulBiasaController@kehadiran_ekskul_biasa_hapus');


Route::get('/data_ekskul_biasa/{id_ekskul_biasa}', 'EkskulBiasaController@data_ekskul_biasa');
Route::post('/instruktur_absen', 'SenbudController@instruktur_absen');
// Akhir INSTRUKTUR Controller


// Pengurus Controller
Route::get('/dashboard_admin', 'AdminController@dashboard_admin');
Route::get('/cari_tidak_masuk', 'AdminController@cari_tidak_masuk');
Route::get('/export_senbud_tidak_masuk', 'AdminController@export_senbud_tidak_masuk');
Route::get('/export_ekskul_biasa_tidak_masuk', 'AdminController@export_ekskul_biasa_tidak_masuk');
Route::get('/export_ekskul_produktif_tidak_masuk', 'AdminController@export_ekskul_produktif_tidak_masuk');
Route::get('/export_ekskul_keputrian_tidak_masuk', 'AdminController@export_ekskul_keputrian_tidak_masuk');

Route::get('/senbud_alpa_3_export', 'AdminController@senbud_alpa_3_export');
Route::get('/ekskul_biasa_alpa_3_export', 'AdminController@ekskul_biasa_alpa_3_export');
Route::get('/ekskul_produktif_alpa_3_export', 'AdminController@ekskul_produktif_alpa_3_export');
Route::get('/keputrian_alpa_3_export', 'AdminController@keputrian_alpa_3_export');

Route::get('/senbud_alpa_3', 'AdminController@senbud_alpa_3');
Route::get('/ekskul_biasa_alpa_3', 'AdminController@ekskul_biasa_alpa_3');
Route::get('/ekskul_produktif_alpa_3', 'AdminController@ekskul_produktif_alpa_3');
Route::get('/keputrian_alpa_3', 'AdminController@keputrian_alpa_3');
Route::get('/banyak/siswa', 'AdminController@banyak_siswa');
Route::get('/sudah/memilih', 'AdminController@sudah_memilih');
Route::get('/belum/memilih', 'AdminController@belum_memilih');
Route::get('/alpa', 'AdminController@alpa');
Route::get('/detail_siswa/{id}', 'AdminController@detail_siswa');

// Siswa Controller
Route::get('/dashboard_siswa', 'SiswaController@dashboard_siswa');
Route::post('/siswa/memilih', 'SiswaController@siswa_memilih');
Route::get('/kehadiran_senbud_per_siswa/{id_senbud}', 'SiswaController@kehadiran_senbud_per_siswa');
Route::get('/kehadiran_ekskul_biasa_per_siswa/{id_ekskul_biasa}', 'SiswaController@kehadiran_ekskul_biasa_per_siswa');
Route::get('/kehadiran_ekskul_produktif_per_siswa/{id_ekskul_produktif}', 'SiswaController@kehadiran_ekskul_produktif_per_siswa');
Route::get('/kehadiran_keputrian_per_siswa/{id_keputrian}', 'SiswaController@kehadiran_keputrian_per_siswa');
// Akhir Siswa Controller


// Piket Controller
Route::get('/dashboard_piket', 'PiketController@dashboard_piket');
// Akhir Piket Controller



// Datatables
Route::get('/banyak/siswa/json','AdminController@banyak_siswa_json');
Route::get('/siswa/json','AdminController@siswa_json');
Route::get('/cari/json','AdminController@cari_json');
Route::get('/sudah/memilih/json','AdminController@sudah_memilih_json');
Route::get('/belum/memilih/json','AdminController@belum_memilih_json');
// Akhir Datatables

// Export
Route::get('/siswa/belum_memilih_export', 'AdminController@belum_memilih_export');
Route::get('/siswa/sudah_memilih_export', 'AdminController@sudah_memilih_export');
// Akhir Export
});
Route::get('/perkenalan_senbud/{id_senbud}', 'HomeController@perkenalan_senbud');
Route::get('/perkenalan_ekskul_biasa/{id_ekskul_biasa}', 'HomeController@perkenalan_ekskul_biasa');
Route::get('/perkenalan_ekskul_produktif/{id_ekskul_produktif}', 'HomeController@perkenalan_ekskul_produktif');
Route::get('/perkenalan_keputrian/{id_keputrian}', 'HomeController@perkenalan_keputrian');
Route::get('/home', 'HomeController@index')->name('home');
