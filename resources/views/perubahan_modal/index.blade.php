@extends('layouts.template.app')
@section('title', 'Perubahan Modal - Laporan')

@section('contents')
<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
          <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Perubahan Modal</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Perubahan Modal</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data"
            action="{{ route('perubahan_modal.print') }}">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="month">Select Date </label>
                    <label for="month">From</label>
                    <input type="date" class="form-control @error('month') is-invalid @enderror" id="month" name="month" value="{{ old('month') }}" required>
                    <label for="month">Until</label>
                    <input type="date" class="form-control @error('month_until') is-invalid @enderror" id="month_until" name="month_until" value="{{ old('month_until') }}" required>
                    @error('month')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <hr>
                    <div class="">
                      <button type="submit" class="btn btn-primary btn-rounded">Print</button>
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection