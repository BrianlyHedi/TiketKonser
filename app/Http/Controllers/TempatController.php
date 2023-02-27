<?php

namespace App\Http\Controllers;

use App\Models\Tempat;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TempatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiket = Tiket::orderBy('kode')->orderBy('name')->get();
        $tempat = Tempat::with('tiket.category')->orderBy('created_at', 'desc')->get();
        return view('server.tempat.index', compact('tempat', 'tiket'));
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
        $this->validate($request, [
            'tujuan' => 'required',
            'harga' => 'required',
            'jam' => 'required',
            'tiket_id' => 'required'
        ]);

        Tempat::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'tujuan' => $request->tujuan,
                'harga' => $request->harga,
                'jam' => $request->jam,
                'tiket_id' => $request->tiket_id,
            ]
        );

        if ($request->id) {
            return redirect()->route('tempat.index')->with('success', 'Success Update Tempat!');
        } else {
            return redirect()->back()->with('success', 'Success Add Tempat!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tempat = Tempat::find($id);
        $tiket = Tiket::orderBy('kode')->orderBy('name')->get();
        return view('server.tempat.edit', compact('tempat', 'tiket'));
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
        Tempat::find($id)->delete();
        return redirect()->back()->with('success', 'Success Delete Tempat!');
    }
}
