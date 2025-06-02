@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Sales Report</h2>

        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Sales</h5>
                        <p class="card-text">${{ number_format($totalSales, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders Placed</h5>
                        <p class="card-text">{{ $orderCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Products Sold</h5>
                        <p class="card-text">{{ $productsSold }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h4>Top Selling Products</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Product</th>
                <th>Units Sold</th>
            </tr>
            </thead>
            <tbody>
            @foreach($topProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sales }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
