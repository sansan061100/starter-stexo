<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\Toko;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

/**
 * ambil data di table
 *
 * @param string $table
 */
function table($table)
{
    return \Illuminate\Support\Facades\DB::table($table);
}
/**
 * Ambil data dari uri ke-n
 *
 * @param int $uri
 * @return string
 */
function getUri($uri)
{
    return request()->segment($uri);
}

/**
 * Set active class di menu
 *
 * @param string $name
 * @param integer $uri
 * @return void
 */
function active_class($name, $uri)
{
    return getUri($uri) == $name ? 'active' : '';
}

function active_class_parent($arrayName, $uri)
{
    return in_array(getUri($uri), $arrayName) ? 'active' : '';
}

/**
 * Generate General Table
 *
 * @param array $data
 * @return void
 */
function generateTable($data)
{
    return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
}

/**
 * Set Respon Json
 *
 * @param boolean $status
 * @param string $message
 * @param object $data
 * @return void
 */
function setResponse($status, $message, $data = [], $code = 200)
{
    return response()->json(
        [
            'status' => $status,
            'message' => $message,
            'result' => $data
        ],
        $code
    );
}




/**
 * Input File ke Storage
 *
 * @param string $public
 * @param object $image
 * @param string $name
 * @return void
 */

function storage_insert($public, $image, $name)
{
    return Storage::putFileAs($public, $image, $name);
}

/**
 * Input File Ke Storage di cek dulu ada tidaknya dan mengubah nama file
 *
 * @param object $file
 * @param string $oldFile
 * @param string $path
 * @return void
 */
function insertImage($file, $oldFile = '', $path)
{
    if ($file) {
        if (storage_exist($path . $oldFile)) {
            storage_delete($path . $oldFile);
        }
        $newImage = $file;
        $extension = $newImage->getClientOriginalExtension();
        $lastFile = md5(rand(5, 10) . time() . uniqid()) . '.' . $extension;
        $p = storage_insert('public/' . $path, $newImage, $lastFile);
    } else {
        if ($oldFile != null) {
            $lastFile = $oldFile;
        } else {
            $lastFile = '';
        }
    }

    return $lastFile;
}

/**
 * Hapus Gambar dari Storage Check dulu file nya ada atau tidak
 *
 * @param string $file
 * @return void
 */
function deleteImage($file)
{
    if (storage_exist($file)) {
        storage_delete($file);
    }
}

/**
 * Random String ,default panjang data 10
 *
 * @param integer $length
 * @return string
 */
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function noRupiah($angka, $seperator = '.')
{
    $hasil_rupiah = number_format($angka, 0, ",", $seperator);
    return $hasil_rupiah;
}

/**
 * Ubah Angka dalam Format Rupiah Terbilang
 *
 * @param int $angka
 * @return void
 */
function terbilang($x)
{
    $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

    if ($x < 12) {
        $terbilang = " " . $angka[$x];
    } elseif ($x < 20) {
        $terbilang = terbilang($x - 10) . " belas";
    } elseif ($x < 100) {
        $terbilang = terbilang($x / 10) . " puluh" . terbilang($x % 10);
    } elseif ($x < 200) {
        $terbilang = "seratus" . terbilang($x - 100);
    } elseif ($x < 1000) {
        $terbilang = terbilang($x / 100) . " ratus" . terbilang($x % 100);
    } elseif ($x < 2000) {
        $terbilang = "seribu" . terbilang($x - 1000);
    } elseif ($x < 1000000) {
        $terbilang = terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
    } elseif ($x < 1000000000) {
        $terbilang = terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
    } elseif ($x < 1000000000000) {
        $terbilang = terbilang($x / 1000000000) . " miliar" . terbilang($x % 1000000000);
    } elseif ($x < 1000000000000000) {
        $terbilang = terbilang($x / 1000000000000) . " triliun" . terbilang($x % 1000000000000);
    }
    return ucwords($terbilang);
}

/**
 * Ubah Nilai String Angka ke Integer
 *
 * @param int $number

 */
function clearNumber($number)
{
    return preg_replace('/[^A-Za-z0-9\-]/', '', $number);
}

/**
 * Get Data Admin
 *
 * @param string $guard
 *
 */
function getUser($guard = 'web')
{
    return auth()->guard($guard)->user();
}

function sideActive($name, $segment)
{
    if ($name == request()->segment($segment)) {
        return 'success';
    }
}

/**
 * Check File Ada di Storage
 *
 * @param string $path
 * @return void
 */
function storage_exist($path)
{
    return Storage::disk('public')->exists($path);
}

/**
 * Hapus File dari Storage
 *
 * @param string $path
 * @return void
 */
function storage_delete($path)
{
    return Storage::disk('public')->delete($path);
}

/**
 * Generate file untuk upload file
 *
 * @param [type] $file
 * @param string $path
 * @param string $oldFile
 * @return string
 */
function getFileName($file, $path = null, $oldFile = null)
{
    $hash = Str::random(30);
    $meta = '-meta' . base64_encode($file->getClientOriginalName()) . '-';
    $extension = '.' . $file->guessExtension();
    if ($path) {
        if (storage_exist($path . '/' . $oldFile)) {
            storage_delete($path . '/' . $oldFile);
        }
    }
    return $hash . $meta . $extension;
}

function getImage($path, $file)
{
    if (@fopen($file, "r")) {
        return $file;
    }
    return asset('storage/' . $path) . '/' . $file;
}

/**
 * Fungsi utuk menghilangkan post dan ID string
 *
 * @param string $message
 * @return string
 */
function post($message)
{
    return str_replace('id', '', str_replace('post.', '', $message));
}

/**
 * Fungsi generate slug
 *
 * @param string $string
 * @return string
 */
function slug($string)
{
    return Str::slug($string, '-') . '-' . generateRandomString(4);
}

function imgDumy($width, $height)
{
    return "https://via.placeholder.com/" . $width . "x" . "$height.";
}

/**
 * Ubah Angka dalam Format Rupiah
 *
 * @param int $angka
 * @return void
 */
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ",", ".");
    return $hasil_rupiah;
}
/**
 * Mengubah tanggal menjadi tanggal format indonesia
 *
 * @param string $date
 * @return string
 */
function translateDate($date)
{
    \Carbon\Carbon::setLocale('id');
    return \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y');
}

/**
 * Mengubah tanggal menjadi tanggal format indonesia
 *
 * @param string $date
 * @return string
 */
function translateDate2($date)
{
    \Carbon\Carbon::setLocale('id');
    return \Carbon\Carbon::parse($date)->translatedFormat('d F Y H:i');
}

/**
 * Menampilkan pesan untuk tambah atau update
 *
 * @param int $id
 * @return string
 */
function setMessage($id, $tambah = 'Berhasil Menambahkan data', $edit = 'Berhasil Mengubah data')
{
    return ($id == null) ? $tambah : $edit;
}

/**
 * Menampilkan pesan delete
 *
 * @param int $id
 * @return string
 */
function setMessageDelete()
{
    return 'Berhasil Hapus Data';
}

/**
 * Set unique rule validation
 *
 * @param string $table
 * @param string $field
 * @param string $value
 * @param string $primaryKey
 * @param string $method
 * @return string
 */
function setRuleUnique($table, $field, $value = null, $method = 'POST', $primaryKey = 'id')
{
    if ($method == 'POST') {
        return "required|unique:" . $table . ',' . $field;
    } else {
        return "required|unique:" . $table . ',' . $field . ',' . $value . ',' . $primaryKey;
    }
}

/**
 * Set unique rule validation
 *
 * @param string $table
 * @param string $field
 * @param string $value
 * @param string $primaryKey
 * @param string $method
 * @return string
 */
function setRuleUnique2($table, $field, $value = null, $method = 'POST', $primaryKey = 'id')
{
    if ($method == 'POST') {
        return "unique:" . $table . ',' . $field;
    } else {
        return "unique:" . $table . ',' . $field . ',' . $value . ',' . $primaryKey;
    }
}

/**
 * Membandingan sebuah perbandingan
 *
 * @return string
 */
function selected($param1, $param2)
{
    if ($param1 == $param2) {
        return 'selected';
    }
}

function customValidation($request, array $default = [], array $custom = [])
{
    // Array Rules
    $rules = array_merge($default, $custom);

    // Set Validation
    return $request->validate($rules);
}

function dateInputFormat($date, $status)
{
    if ($status == 'awal') {
        $code = ' 00:00:00';
    } else {
        $code = ' 23:59:59';
    }
    return Carbon::parse($date)->format('Y-m-d') . $code;
}

function checkString($string, $filter)
{
    return strpos($string, $filter);
}

function sum(...$number)
{
    $total = 0;
    foreach ($number as $val) {
        $total = $total + $val;
    }
    return $total;
}

function selectedTime($time)
{
    return date('Y-m-d\TH:i:sP', strtotime($time));
}

function dateHumans($dateLast)
{
    $dateLast = Carbon::parse($dateLast);
    return $dateLast->diffForHumans();
}

function createBreadCumb($name, $status = '', $link = '#')
{
    return [
        'name' => $name,
        // 'link' => $link,
        'status' => $status
    ];
}

function isAjax()
{
    return request()->ajax();
}
