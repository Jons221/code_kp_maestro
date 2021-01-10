@extends('layouts.template.app')
@section('title', 'Create partner')

@section('contents')
<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
          <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">{{isset($partner) ? 'Edit Existing' : 'Add New'}} partner</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('partners.index')}}" class="text-muted">partner</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">{{isset($partner) ? 'Edit' : 'Add'}} partner</li>
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
            action="{{ isset($partner) ? route('partners.update', $partner['id']) : route('partners.store') }}">
            @csrf
            @if(isset($partner))
            @method('PUT')
            @endif
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <small>* is required</small>
                </div>
                
                <div class="form-group">
                  <label for="name">Partner Name *</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Add partner name" name="name" value="{{ isset($partner) ? $partner['name'] : old('name') }}"
                    autocomplete="off">
                  @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone"
                    placeholder="Add phone number" name="phone" value="{{ isset($partner) ? $partner['phone'] : old('phone') }}"
                    autocomplete="off">
                  @error('phone')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="email">Email *</label>
                  <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                    placeholder="Email" name="email" value="{{ isset($partner) ? $partner['email'] : old('email') }}"
                    autocomplete="off">
                  @error('email')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <textarea class="form-control" id="address" name="address" rows="3">{{ isset($partner) ? $partner['address'] : old('address') }}</textarea>
                </div>
                <div class="form-group">
                  <label for="remark">Remark</label>
                  <textarea class="form-control" id="remark" name="remark" rows="3">{{ isset($partner) ? $partner['remark'] : old('remark') }}</textarea>
                </div>
              </div>
              <hr>
              <div>
                <a href="{{ route('partners.index') }}" type="button" class="btn btn-secondary btn-rounded mr-2">Back</a>
                <button type="submit" class="btn btn-primary btn-rounded">Submit</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
