@extends('admin.layouts.app')

@section('content')
    <style>
        /* Include your CSS styling exactly as given */
        {!! file_get_contents(public_path('panel/css/invoice-style.css')) !!}
    </style>

    <div id="layout-wrapper">

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="invoice-wrapper">

                        <!-- Top Bar -->
                        <div class="top-bar">
                            <div class="company-logo">
                                <div class="logo-box ">
                                    @if (get_setting('web_logo'))
                                        <img src="{{ uploaded_asset(get_setting('web_logo')) }}" alt="Logo">
                                    @else
                                        <span style="color: red">KP</span>
                                    @endif
                                </div>

                                <div class="company-details">
                                    <h1>KINGPIN WEARS</h1>
                                    <p>
                                        {{ get_setting('company_address') }}<br>
                                        Phone: {{ get_setting('company_phone') }}<br>
                                        Email: {{ get_setting('company_email') }} <br>
                                        GSTIN: {{ get_setting('company_gst') }}
                                    </p>
                                </div>
                            </div>
                            <div class="invoice-side">
                                <span>INVOICE</span><br>
                                {{ str_replace('ODR', 'INV', $order->custom_order_id) }}

                            </div>

                        </div>

                        <!-- invoice no / date -->
                        <div class="info-strip">
                            <div>Invoice No: <span>{{ $order->custom_order_id }}</span></div>
                            <div>Invoice Date: <span>{{ $order->created_at->format('d M, Y') }}</span></div>
                        </div>

                        <!-- bill / ship -->
                        <div class="bill-ship">
                            <div class="bill-block">
                                <h3>BILL TO</h3>
                                <h4>{{ $order->user?->name }}</h4>
                                <p>
                                    {{ $order->user?->address }}<br>
                                    Phone: {{ $order->user?->phone }}<br>
                                    Email: {{ $order->user?->email }}<br>
                                    State: {{ $order->user?->state }}
                                </p>
                            </div>

                            <div class="bill-block">
                                <h3>SHIP TO</h3>
                                <h4>{{ $order->user?->name }}</h4>
                                <p>
                                    {{ $order->user?->address }}<br>
                                    State: {{ $order->user?->state }}
                                </p>
                            </div>
                        </div>

                        <!-- items -->
                        <table>
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Items</th>
                                    <th>Quantity</th>
                                    <th>Price per unit</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₹ {{ number_format($item->price, 2) }}</td>
                                        <td>₹ {{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        <!-- Subtotal -->
                        <div class="subtotal-row">
                            <table>
                                <tr>
                                    <td>Sub Total</td>
                                    <td style="text-align:center;">{{ $order->items->sum('quantity') }}</td>
                                    <td style="text-align:right;">₹ {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Bank & Totals -->
                        <div class="bottom-section">

                            <!-- Bank -->
                            <div class="bank-details">
                                <h3>Bank Details</h3>
                                <p><span class="label">Account holder:</span>{{ get_setting('account_holder_name') }}</p>
                                <p><span class="label">Account number:</span>{{ get_setting('account_number') }}</p>
                                <p><span class="label">Bank:</span> {{ get_setting('bank_name') }}</p>
                                <p><span class="label">Branch:</span> {{ get_setting('bank_branch') }}</p>
                                <p><span class="label">IFSC code:</span> {{ get_setting('ifsc_code') }} </p>
                                <p><span class="label">UPI ID:</span> {{ get_setting('upi_id') }}</p>

                                <p style="margin-top:8px;"><span class="label">UPI QR:</span></p>
                                <div class="upi-qr logo-box">
                                    <div class="">
                                        <img src="{{ uploaded_asset(get_setting('upi_scaner')) }}" alt="Logo">
                                    </div>
                                </div>
                            </div>

                            <!-- Amount Summary -->
                            <div class="amount-summary">
                                <table>
                                    <tr>
                                        <td>Taxable Amount</td>
                                        <td>₹ {{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td>- ₹ {{ number_format($order->discount_amount ?? 0, 2) }}</td>
                                    </tr>
                                </table>

                                <div class="row-border">
                                    <table>
                                        <tr>
                                            <td class="label-bold">Total Amount</td>
                                            <td class="label-bold">₹ {{ number_format($order->total_amount, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                @php
                                    $receive_amount = App\Models\Orders\CommissionInstallment::where(
                                        'order_id',
                                        $order->id,
                                    )
                                        ->where('status', 1)
                                        ->sum('payment_amount');

                                    $due_amount = max($order->total_amount - $receive_amount, 0); // prevent negative

                                    $current_balance = $due_amount;
                                @endphp


                                <table>
                                    <tr>
                                        <td>Received Amount</td>
                                        <td>₹{{ number_format($receive_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Due Balance</td>
                                        <td>₹{{ number_format($due_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Previous Balance</td>
                                        <td>₹ {{ number_format($due_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-bold">Current Balance</td>
                                        <td class="label-bold">₹
                                            {{ number_format($current_balance ?? 0, 2) }}</td>
                                    </tr>
                                </table>
                            </div>

                        </div>

                        <!-- Terms -->
                        <div class="terms">
                            <h3>Terms and Conditions</h3>
                            <ol>
                                <li>We have six months warranty all products from TeeBros.</li>
                                <li>To claim warranty please follow below steps.</li>
                                <li>Billing of the product is required photo or xerox copy.</li>
                                <li>Tag on shirt is mandatory.</li>
                                <li>No damage in the product.</li>
                                <li>Six months free return if product not sold.</li>
                            </ol>
                        </div>

                    </div>

                    <!-- Print Button -->
                    <div class="text-center mt-3">
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fa fa-print"></i> Print Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
