@extends('agent.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">

                    @if ($errors->any() || session()->has('message') || session()->has('error') || session()->has('success'))
                        <div
                            class="alert {{ $errors->any() ? 'alert-danger' : (session()->has('error') ? 'alert-danger' : (session()->has('success') ? 'alert-success' : 'alert-warning')) }}">
                            <ul>
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                @endif

                                @if (session()->has('message') || session()->has('error') || session()->has('success'))
                                    {{ session('message') ?? (session('error') ?? session('success')) }}
                                @endif
                            </ul>
                        </div>
                    @endif

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-bordered">
                                <h3 class="card-title">Add Client</h3>
                            </div>
                            <div class="card-body">

                                <form action="{{ route('agent.newClients') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row g-3">
                                        {{-- User ID (hidden if auto) --}}
                                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">



                                        {{-- Name --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Enter client name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Email --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Enter email" value="{{ old('email') }}" required>

                                            @error('email')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>



                                        {{-- Phone --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control"
                                                placeholder="Enter phone number" value="{{ old('phone') }}" required>
                                            @error('phone')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Alternate Phone --}}
                                        <div class="col-md-6">
                                            <label class="form-label">Alternate Phone</label>
                                            <input type="text" name="phone_2" class="form-control"
                                                placeholder="Enter alternate phone" value="{{ old('phone_2') }}">

                                            @error('phone_2')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Avatar --}}
                                        <div class="col-md-6 ">
                                            <div class="form-group mt-3 ">
                                                <label for="signinSrEmail">Select The Profile Image (300x300) </label>

                                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                    data-multiple="false">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            Browse
                                                        </div>
                                                    </div>
                                                    <div class="form-control file-amount">Choose File</div>
                                                    <input type="hidden" name="avatar" value="{{ old('avatar') }}"
                                                        class="selected-files">
                                                </div>
                                                <div class="file-preview box sm">

                                                </div>

                                                @error('avatar')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ ucwords($message) }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>
                                        {{-- Address --}}
                                        <div class="col-md-12">
                                            <label class="form-label">Address</label>
                                            <textarea name="address" class="form-control" cols="4" rows="4">{{ old('address') }}</textarea>
                                            @error('address')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror

                                        </div>

                                        {{-- City --}}




                                        {{-- Submit --}}
                                        <div class="col-12 mt-3">
                                            <button type="submit" class="btn btn-success w-100">Save Client</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
