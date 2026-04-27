<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    // Mengizinkan penggunaan fitur otorisasi (cek izin user)
    use AuthorizesRequests;

    // Mengizinkan penggunaan fitur validasi cepat di dalam controller
    use ValidatesRequests;
    
    /**
     * Tips: Kamu bisa menambahkan fungsi bantuan (helper) di sini
     * agar bisa dipanggil di semua controller lain.
     */
}