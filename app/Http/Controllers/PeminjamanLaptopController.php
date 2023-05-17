<?php

namespace App\Http\Controllers;

use App\Models\peminjamanLaptop;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;
use Spatie\FlareClient\Api;

class PeminjamanLaptopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request$request)
    {
        // untuk ambil data dari search_nama bagian params 
        $search = $request->search_nama;
        // untuk ambil data limit bagian params
        $limit = $request->limit;
        $laptops = peminjamanLaptop::where('nama', 'LIKE', '%'.$search.'%')->limit($limit)->get();
        if ($laptops){
            // kalau data berhasil di ambil 
            return ApiFormatter::createAPI(200, 'success', $laptops);
        }else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            // untuk memvalidasi data 
            $request->validate([
                'no_laptop' => 'required',
                'nama' => 'required',
                'nis' => 'required',
                'rombel' => 'required',
                'rayon' => 'required',
                'tanggal_peminjaman' => 'required',
            ]);

            // ngrim data ke table peminjaman_laptops lewat model peminjamanLaptop
            $laptops = peminjamanLaptop::create([
                'no_laptop' => $request->no_laptop, 
                'nama' => $request->nama,
                'nis' => $request->nis,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
                'tanggal_peminjaman' => \Carbon\Carbon::Parse($request->tanggal_peminjaman)->format('Y-m-d'),
            ]);

            // mencari data yang berhasil di simpen cari berdasarkan id lewat data dari id $laptops di atas
            $tambahData = peminjamanLaptop::where('id', $laptops->id)->first();

            if($tambahData) {
                  // kalau data berhasil di ambil menampilkan data dari $laptops dengan tanda cose 200
                return ApiFormatter::createAPI(200, 'success', $laptops);
            }else{
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error) {
            // untuk memunculkan deskripsi error di property json
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function createToken(){
        return csrf_token();    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            // unutk find hanya untuk mencari berdasarkan id
            $laptops =  PeminjamanLaptop::find($id);
            if($laptops){
                // kalau data berhasil di ambil menampilkan data dari $laptops dengan tanda cose 200
                return ApiFormatter::createAPI(200, 'success', $laptops);
            }else{
                //kalau data gagal diambil data yang dikembalikan status code nya 400
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error) {
             // untuk memunculkan deskripsi error di property json
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(peminjamanLaptop $peminjamanLaptop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, peminjamanLaptop $peminjamanLaptop, $id)
    {
        try{
            // untuk cek validasi inputan pada body postman
            $request->validate([
                'no_laptop' => 'required',
                'nama' => 'required',
                'nis' => 'required',
                'rombel' => 'required',
                'rayon' => 'required',
                'tanggal_peminjaman' => 'required',
            ]);

            // untuk mengabil data yang akan di ubah 
            $laptop = peminjamanLaptop::find($id);

            // untuk update data yang akan di ubah 
            $laptop->update([
                'no_laptop' => $request->no_laptop, 
                'nama' => $request->nama,
                'nis' => $request->nis,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
                'tanggal_peminjaman' => \Carbon\Carbon::Parse($request->tanggal_peminjaman)->format('Y-m-d'),
            ]);
            // cari berdasarkan data yang berhasil di ubah tadi cari berdasarkan id $laptops yang di ambil data di awal 
            $dataBaru = peminjamanLaptop::where('id', $laptop->id)->first();
            if($dataBaru) {
                 // jika update berhasil tampilkan data dari $dataBaru diatas ( data yang sudah berhasil diubah)
                return ApiFormatter::createAPI(200, 'success',$dataBaru);
            }else {
                return ApiFormatter::createAPI(400, 'faiiled');
            }
        }catch (Exception $error) {
             // untuk memunculkan deskripsi error di property json
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(peminjamanLaptop $peminjamanLaptop, $id)
    {
        try {
            // untuk mencari id mana yanng akan di hapus 
            $laptop = peminjamanLaptop::find($id);
            // untuk hapus data yang di ambil
        $delete = $laptop->delete();

        if($delete) {
            // kalau data berhasil di delete akan memunnculkan status code 200
            return ApiFormatter::createAPI(200, 'success', 'data berhasil dihapus');
        }else {
            return ApiFormatter::createAPI(400, 'failed');
        }
        }catch (Exception $error) {
             // untuk memunculkan deskripsi error di property json
            return ApiFormatter::createAPI(400, 'failed', $error->getMessage());
        }
        
    }

    public function trash(){
        try{
            // untuk mengabil data yang sudah di hapus sementara
            $laptop = peminjamanLaptop::onlyTrashed()->get();
            if($laptop){
                // kalau data berhasil diambil akan memunculkan code 200 dengan data daru $laptop
                return ApiFormatter::createAPI(200, 'success', $laptop);
            }else{
                // jika data gagal diambil 
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error){
             // untuk memunculkan deskripsi error di property json
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function restore($id){
        try{
            // mengabil data yang akan di batalkan hapusnya di ambil berdasarkan id nya 
            $laptop = peminjamanLaptop::onlyTrashed()->where('id', $id);
            // untuk mengembalikan si data nya 
            $laptop->restore();
            // mengambil kemabli data yang sudah di restore
            $datasKembali = peminjamanLaptop::where('id', $id)->first();
            if ($datasKembali){
                // jika data berhasil diambil akan memunculkana code 200 dan menampilkan data dari $datasKembali
                return ApiFormatter::createAPI(200, 'success', $datasKembali);
            }else{
                // jika data gagal diamabil akan memunculkan code 400 
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
             // untuk memunculkan deskripsi error di property json
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function permanenDelete($id){
        try{
            //mengambil data yang akan di hapus permananet
            $laptop = peminjamanLaptop::onlyTrashed()->where('id', $id);
            // menghapus permananet data yang diambil
            $Memproses = $laptop->forceDelete();
            if ($Memproses){
                // kalau data berhasil didelete/ambil akan menampilkan code 200 dan memunculkan pesan berhasil hapus permanent
                return ApiFormatter::createAPI(200, 'success', 'Berhasil hapus permanent');
            }else{
                // kalau data gagal di ambil akan menampilkan code 400
                return ApiFormatter::createAPI(400, 'failed');
            }
        }catch (Exception $error){
             // untuk memunculkan deskripsi error di property json
             return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }
}
