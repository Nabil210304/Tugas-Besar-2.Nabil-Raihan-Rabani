<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use ArielMejiaDev\LarapexCharts\BarChart;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function TampilHome()
    {
        // Cek apakah pengguna adalah admin
        $isAdmin = Auth::user()->isAdmin;

        // Query produk dengan filter untuk non-admin
        $produkPerHariQuery = Produk::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc');

        // Jika bukan admin, filter produk berdasarkan user_id
        if (!$isAdmin) {
            $produkPerHariQuery->where('user_id', Auth::id());
        }

        $produkPerHari = $produkPerHariQuery->get();

        // Pisahkan data untuk chart
        $dates = [];
        $totals = [];

        foreach ($produkPerHari as $item) {
            $dates[] = Carbon::parse($item->date)->format('Y-m-d');
            $totals[] = $item->total;
        }

        // Buat chart dengan data yang diambil
        $chart = LarapexChart::barChart()
            ->setTitle('Produk Ditambahkan Per Hari')
            ->setSubtitle('Data Penambahan Produk Harian')
            ->addData('Jumlah Produk', $totals)
            ->setXAxis($dates);

        // Data tambahan untuk view
        $data = [
            'totalProducts' => Produk::count(), // Total produk
            'salesToday' => 130, // Data contoh
            'totalRevenue' => 'Rp 75,000,000', // Data contoh
            'registeredUsers' => 350,
            'chart' => $chart
        ];

        return view('home', $data);
    }

    public function ViewProduk()
    {
        $produk = Produk::all();
        return view('produk', compact('produk'));
    }
}
