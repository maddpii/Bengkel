@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2>Kendaraan Saya</h2>
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kendaraan</th>
                            <th>Plat Nomor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->id }}</td>
                            <td>
                                @if(isset($vehicle->brand) && isset($vehicle->model))
                                    {{ $vehicle->brand }} {{ $vehicle->model }}
                                @elseif(isset($vehicle->vehicle_name))
                                    {{ $vehicle->vehicle_name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $vehicle->license_plate ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Tidak ada kendaraan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
