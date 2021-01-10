@extends('layouts.template.app')
@section('title', 'Detail Payment')

@section('contents')

<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
          <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Detail Payment</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('payments.index')}}" class="text-muted">Payment</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
  </div>
  <div id="update-status-alert" class="alert alert-success d-none">
    
   </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
                  <div class="col-12">
                    <h4>Information</h4>
                    <hr>
                    <div class="row">
                      <div class="col-6">
                        <div>
                          <h6>Payment Number:</h6>
                          <p>{{$payment->number}}</p>
                        </div>
                        <div>
                          <h6>Type:</h6>
                          <p>{{$payment->type}}</p>
                        </div>
                        <div>
                          <h6>Amount:</h6>
                          <p>{{$payment->amount}}</p>
                        </div>
                      </div>
                      <div class="col-6">
                        <div>
                          <h6>Partner:</h6>
                          <p>{{\App\Models\Payment::getPartnerName($payment->partner_id)}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
            

            </div>
          </div>

          <a href="{{ route('payments.index') }}" type="button" class="btn btn-secondary btn-rounded mr-2">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
