@extends('layout.app')

@section('content')
<div class="container p-t-120 p-b-60">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 m-0">Daftar Kendaraan Tersedia</h1>
        <a href="{{ url('/bookings/create') }}" class="btn btn-primary btn-sm">
            Buat Booking
        </a>
    </div>

    @if($vehicles->isEmpty())
        <div class="alert alert-info">
            Belum ada kendaraan yang disediakan admin.
        </div>
    @else
        <div class="row g-3">
            @foreach($vehicles as $v)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $v->brand }}</h5>
                            <p class="card-text">
                                Bengkel menerima servis untuk merek mobil ini.
                            </p>
                            <a href="{{ url('/vehicles/' . $v->id) }}" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
