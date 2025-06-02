@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Customer Report</h2>

        <table class="table">
            <thead>
            <tr>
                <th>Customer</th>
                <th>Orders</th>
                <th>Total Spent</th>
                <th>Last Order</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}<br>{{ $customer->email }}</td>
                    <td>{{ $customer->total_orders }}</td>
                    <td>${{ number_format($customer->total_spent, 2) }}</td>
                    <td>
                        @if($customer->orders->count())
                            {{ $customer->orders->sortByDesc('created_at')->first()->created_at->format('M d, Y') }}
                        @else
                            Never
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $customers->links() }}
    </div>
@endsection
