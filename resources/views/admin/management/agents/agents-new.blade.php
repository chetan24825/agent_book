@extends('admin.layouts.app')
@section('content')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="card">

                        <div class="card-header card-header-bordered">
                            <h3 class="card-title">Add Agent</h3>

                        </div>
                        <div class="card-body">

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form class="custom-validation" action="{{ route('admin.agent-save') }}" method="post">

                                @csrf
                                <div class="row">
                                    <!-- Agent Code (Auto-generated) -->
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>

                                        </select>
                                        @error('status')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ ucwords($message) }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Full Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ ucwords($message) }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6 mt-2">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ ucwords($message) }}</strong>
                                            </span>
                                        @enderror
                                    </div> <!-- password -->
                                    <div class="col-md-6 mt-2">
                                        <label for="exampleFormControlTextarea1" class="form-label">Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control " name="password"
                                            id="exampleFormControlInput1" placeholder="" required>
                                        @error('password')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ ucwords($message) }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-6 mt-2">
                                        <label for="phone" class="form-label">Phone <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="phone" class="form-control" id="phone"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                            maxlength="10"  placeholder="" value="{{ old('phone') }}"
                                            required>
                                        @error('phone')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ ucwords($message) }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Alternate Phone -->
                                    <div class="col-md-6 mt-2">
                                        <label for="phone_2" class="form-label">Alternate Phone</label>
                                        <input type="number" name="phone_2" class="form-control" id="phone_2"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                            maxlength="10"  placeholder="" value="{{ old('phone_2') }}">
                                        @error('phone_2')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ ucwords($message) }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label for="avatar" class="form-label">Select The Profile Image</label>
                                            <div class="input-group" data-toggle="aizuploader" data-type="image"
                                                data-multiple="false">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        Browse
                                                    </div>
                                                </div>
                                                <div class="form-control file-amount">Choose file</div>
                                                <input type="hidden" name="avatar" value="" class="selected-files">
                                            </div>
                                            <div class="file-preview box sm"></div>
                                            @error('avatar')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ ucwords($message) }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Address -->
                                    <div class="col-12 mt-2">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea name="address" class="form-control" id="address" rows="3">{{ old('address') }}</textarea>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12 mt-4">
                                        <div class="d-flex justify-content-end btn-group btn-group-lg mb-2 mt-2">
                                            <button type="submit" name="save"
                                                class="btn btn-primary text-white">Create Agent</button>

                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
