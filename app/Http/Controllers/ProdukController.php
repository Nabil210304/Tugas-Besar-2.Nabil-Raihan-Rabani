<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function ViewProduk()
    {
        // Mengambil semua data di tabel produk
        $isAdmin = Auth::user()->role == "admin";

        // Jika user adalah admin, tampilkan semua data; jika bukan, tampilkan data dengan user_id yang sama dengan user yang login
        $produk = $isAdmin ? Produk::all() : Produk::where("user_id", Auth::user()->id)->get();

        return view('produk', compact('produk'));
    }


    public function CreateProduk(Request $request)
    {
        // Menambahkan variabel $filePath untuk mendefinisikan penyimpanan file
        $imageName = null;

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->storeAs('public/images', $imageName); // Simpan gambar di 'storage/app/public/images'
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga, // Add the harga field
            'jumlah_produk' => $request->jumlah_produk,
            'image' => $imageName,
            'user_id' => Auth::user()->id
        ]);

        return redirect(Auth::user()->role.'/produk');
    }
    public function ViewAddProduk()
    {
        return view('addproduk'); //menampilkan view dari addproduk.blade.php
    }
    public function DeleteProduk ($kode_produk)
    {
        Produk::where('kode_produk', $kode_produk)->delete(); //find the record by ID
        // Redirect back to the index page with a succes message
        return redirect('/produk');
    }

    public function ViewEditProduk($kode_produk)
    {
        // Cari produk berdasarkan kode_produk
        $produk = Produk::where('kode_produk', $kode_produk)->first();

        // Jika produk tidak ditemukan, redirect ke halaman produk dengan pesan error
        if (!$produk) {
        return redirect('/produk')->with('error', 'Produk tidak ditemukan');
        }
    // Tampilkan view edit dengan data produk
    return view('editproduk', compact('produk'));
    }

    public function ViewLaporan()
    {
        //mengambil semua data produk
        $products = Produk::all();
        return view('laporan', ['products' => $products]);
    }

    public function print()
    {
        // Mengambil semua data produk
        $products = Produk::all();

        // Load view untuk PDF dengan data produk
        $pdf = Pdf::loadView('report', compact('products'));

        // Menampilkan PDF langsung di browser
        return $pdf->stream('laporan-produk.pdfr');
    }


    public function UpdateProduk(Request $request, $kode_produk)
    {
        // Menambahkan variabel $filePath untuk mendefinisikan penyimpanan file
        $imageName = null;

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->storeAs('public/images', $imageName); // Simpan gambar di 'storage/app/public/images'
        }

        Produk::where('kode_produk', $kode_produk)->update([
            'nama_produk'    => $request->nama_produk,
            'deskripsi'      => $request->deskripsi,
            'harga'          => $request->harga,
            'jumlah_produk'  => $request->jumlah_produk,
            'image'          => $imageName
        ]);

        return redirect('/produk');
    }
}
