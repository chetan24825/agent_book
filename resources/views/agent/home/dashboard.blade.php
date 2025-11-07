@extends('agent.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <div>
                                    @php
                                        $currentHour = \Carbon\Carbon::now()->format('H');

                                        if ($currentHour < 12) {
                                            $greeting = 'Good Morning';
                                        } elseif ($currentHour < 18) {
                                            $greeting = 'Good Afternoon';
                                        } else {
                                            $greeting = 'Good Evening';
                                        }
                                    @endphp
                                    <h4 class="fs-16 fw-semibold mb-1 mb-md-2">{{ $greeting }}, <span
                                            class="text-primary">{{ auth()->user()->name }}</span></h4>
                                    <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                                </div>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
