@extends('layouts.v1')
@section('title')
    {{ $page }}
@endsection
@section('content')
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0"><span>{{ $page }}</span></h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                            </li>
                            {{-- <li class="breadcrumb-item"><a href="#">Table</a>
              </li> --}}
                            <li class="breadcrumb-item active">{{ $page }}
                            </li>
                        </ol>
                    </div>
                    <div class="col s2 m6 l6">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="section section-data-tables">
            <!-- Page Length Options -->
            <div class="row">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <a href="{{ $data['template'] }}" download>Download Template Excel</a>
                            <form action="{{ $data['action'] ?? route('import.process') }}" enctype="multipart/form-data"
                                method="POST">
                                @csrf
                                <input type="hidden" name="module" value="{{ $data['module'] }}">
                                <input type="hidden" name="redirect" value="{{ $data['redirect'] }}">
                                <div class="row">
                                  <div class="col s6">
                                    <div class="file-field input-field ">
                                        <div class="btn waves-effect waves-light">
                                            <span>File</span>
                                            <input type="file" name="excel_file" required>
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text"
                                                placeholder="Upload Excel Template">
                                        </div>
                                        @error('excel_file')
                                            <span class="red-text text-darken-2">{{ $message }}</small>
                                            @enderror
                                    </div>

                                  </div>
                                </div>

                                <button type="submit" class="btn waves-effect waves-light green ">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
