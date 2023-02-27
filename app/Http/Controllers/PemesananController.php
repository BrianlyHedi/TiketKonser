<?php

namespace App\Http\Controllers;

use App\Models\Tempat;
use App\Models\Category;
use App\Models\Pemesanan;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tempatAwal = Tempat::orderBy('tujuan')->get()->groupBy('tujuan');
        if (count($tempatAwal) > 0) {
            foreach ($tempatAwal as $key => $value) {
                $data['tujuan'][] = $key;
            }
        } else {
            $data['tujuan'] = [];
        }

        $category = Category::orderBy('name')->get();
        return view('client.index', compact('data', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->category) {
            $category = Category::find($request->category);
            $data = [
                'category' => $category->id,
                'tujuan' => $request->tujuan,
                'waktu' => $request->waktu,
            ];
            $data = Crypt::encrypt($data);
            return redirect()->route('show', ['id' => $category->slug, 'data' => $data]);
        } else {
            $this->validate($request, [
                'tempat_id' => 'required',
                'waktu' => 'required',
            ]);

            $huruf = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            $kodePemesanan = strtoupper(substr(str_shuffle($huruf), 0, 7));

            $tempat = Tempat::with('tiket.category')->find($request->tempat_id);
            // $jumlah_kursi = $tempat->tiket->jumlah + 2;
            // $kursi = (int) floor($jumlah_kursi / 5);
            // $kode = "ABCDE";
            // $kodeKursi = strtoupper(substr(str_shuffle($kode), 0, 1) . rand(1, $kursi));

            $waktu = $request->waktu . " " . $tempat->jam;

            Pemesanan::Create([
                'kode' => $kodePemesanan,
                'tujuan' => $tujuan,
                'waktu' => $waktu,
                'total' => $tempat->harga,
                'tempat_id' => $tempat->id,
                'penumpang_id' => Auth::user()->id
            ]);

            return redirect()->back()->with('success', 'Pemesanan Tiket ' . $tempat->tiket->category->name . ' Success!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $data)
    {
        $data = Crypt::decrypt($data);
        $category = Category::find($data['category']);
        $tempat = Tempat::with('tiket')->where('tujuan', $data['tujuan'])->get();
        if ($tempat->count() > 0) {
            foreach ($tempat as $val) {
                $pemesanan = Pemesanan::where('tempat_id', $val->id)->where('waktu')->count();
                if ($val->tiket) {
                    $kursi = Tiket::find($val->tiket_id)->jumlah - $pemesanan;
                    if ($val->tiket->category_id == $category->id) {
                        $dataTempat[] = [
                            'harga' => $val->harga,
                            'tujuan' => $val->tujuan,
                            'tiket' => $val->tiket->name,
                            'kode' => $val->tiket->kode,
                            'kursi' => $kursi,
                            'waktu' => $data['waktu'],
                            'id' => $val->id,
                        ];
                    }
                }
            }
            sort($dataTempat);
        } else {
            $dataTempat = [];
        }
        $id = $category->name;
        return view('client.show', compact('id', 'dataTempat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Crypt::decrypt($id);
        $tempat = Tempat::find($data['id']);
        $tiket = Tiket::find($tempat->tiket_id);
        return view('client.kursi', compact('data', 'tiket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pesan($kursi, $data)
    {
        $d = Crypt::decrypt($data);
        $huruf = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $kodePemesanan = strtoupper(substr(str_shuffle($huruf), 0, 7));

        $tempat = Tempat::with('tiket.category')->find($d['id']);

        $waktu = $d['waktu'] . " " . $tempat->jam;
        Pemesanan::Create([
            'kode' => $kodePemesanan,
            'kursi' => $kursi,
            'waktu' => $waktu,
            'total' => $tempat->harga,
            'tempat_id' => $tempat->id,
            'pemesan_id' => Auth::user()->id
        ]);

        return redirect('/')->with('success', 'Pemesanan Tiket ' . $tempat->tiket->category->name . ' Success!');
    }
}
