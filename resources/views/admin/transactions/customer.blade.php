@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Transaksi Saya</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->date }}</td>
                <td>{{ $transaction->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
