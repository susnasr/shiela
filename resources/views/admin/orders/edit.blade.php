@extends('layouts.admin')

@section('title', 'Edit Order #'.$order->id)

@section('content')
    <h2>Edit Order #{{ $order->id }}</h2>

    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label>Carrier</label>
            <input type="text" name="carrier" class="form-control" value="{{ old('carrier', $order->carrier) }}">
        </div>

        <div class="form-group mt-3">
            <label>Tracking Number</label>
            <input type="text" name="tracking_number" class="form-control" value="{{ old('tracking_number', $order->tracking_number) }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Order</button>
    </form>
@endsection
