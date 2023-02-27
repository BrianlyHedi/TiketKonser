@extends('layouts.app')
@section('title', 'Detail Ticket')
@if (Auth::user()->level == "Admin")
  @section('heading', 'Detail Ticket')
@endif
@section('styles')
  <style>
    .card-body {
      padding: .5rem 1rem;
      color: #000;
      border-bottom: 1px solid #e3e6f0;
    }

    .title {
      color: #1ccc8c;
      text-decoration: none;
      font-size: 1.2rem;
      font-weight: 800;
      text-align: center;
      text-transform: uppercase;
      z-index: 1;
      align-items: center;
      justify-content: center;
      display: flex;
    }

    .title .title-text {
      display: inline;
    }

    .table {
      margin-bottom: 0;
      color: #000;
    }

    .table td {
      padding: 0;
      border-top: none;
    }
  </style>
@endsection
@section('content')
  <div class="row justify-content-center" style="margin-bottom: 35px;">
    @if (Auth::user()->level != "Admin")
    <div class="col-12" style="margin-top: -15px">
      <a href="javascript:window.history.back();" class="text-white btn"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
    @else
    <div class="col-12">
    @endif
      <div class="card shadow h-100" style="border-top: .25rem solid #1ccc8c">
        <div class="card-body">
          <div class="row no-gutters align-items-center justify-content-center">
            <div class="col h5 font-weight-bold" style="margin-bottom: 0">Detail Tiket</div>
            <div class="col-auto">
              <span class="title">
                <div class="title-icon rotate-n-15">
                </div>
                <div class="title-text ml-1">Agen X</div>
              </span>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="font-weight-bold h4 text-center" style="margin-bottom: 0">{{ $data->tempat->tujuan }}</div>
          <div class="row no-gutters align-items-center justify-content-center">
            <div class="col-auto font-weight-bold h5" style="margin-bottom: 0">
                {{ $data->tempat->tiket->name }}
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row no-gutters align-items-center justify-content-center">
            <div class="col">
              <p style="margin-bottom: 0">Kode Booking</p>
              <h3 class="font-weight-bold">{{ $data->kode }}</h3>
            </div>
            <div class="col-auto">
              {!! DNS1D::getBarcodeHTML($data->kode, "C128", 1.2, 45) !!}
            </div>
          </div>
          <p style="margin-bottom: 0; margin-top: 5px;">Waktu Pemesanan</p>
          <h5 class="font-weight-bold text-center">
            <div>
              {{ date('l, d F Y', strtotime($data->waktu)) }}
            </div>
            <div>
              {{ date('H:i', strtotime($data->waktu)) }} WIB
            </div>
          </h5>
        </div>
        <div class="card-body">
          <table class="table">
            <tr>
              <td>Nama Pemesan</td>
              <td class="text-right">{{ $data->penumpang->name }}</td>
            </tr>
            <tr>
              <td>Kode Kursi</td>
              <td class="text-right">{{ $data->kursi }}</td>
            </tr>
            <tr>
              <td>Harga</td>
              <td class="text-right">Rp. {{ number_format($data->total, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td>Status Verifikasi</td>
              <td class="text-right">{{ $data->status }}</td>
            </tr>
          </table>
        </div>
        @if ($data->status == "Belum Terverifikasi" && Auth::user()->level != "Penumpang")
          <div class="card-body">
            <a href="{{ route('pembayaran', $data->id) }}" class="btn btn-success btn-block btn-sm text-white">Verifikasi</a>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection