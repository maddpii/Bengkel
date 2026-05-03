@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Booking Kendaraan Saya</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kendaraan</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->vehicle_name }}</td>
                <td>{{ $booking->date }}</td>
                <td>{{ $booking->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
