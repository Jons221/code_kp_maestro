@extends('layouts.template.app')
@section('title', 'Data Payment - Purchasing App')

@section('contents')
<div class="page-wrapper">
  <div id="delete-alert" class="alert alert-success d-none">
    Data have been removed
   </div>
   @if(session('error'))
    <div id="alert" class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif
  @if(session('status'))
  <div id="alert" class="alert alert-success">
    {{ session('status') }}
  </div>
  @endif
  <div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Payment List</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Payment</li>
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
          <!-- <div class="mb-4">
            <a href="{{ route('payments.create') }}" type="button" class="btn btn-primary btn-rounded">
              + Add New Record</a>
          </div> -->
          <div class="table-responsive">
            <table class="table table-bordered yajra-datatable table-striped no-wrap">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Invoice code</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(function () {
        let alert = $('#alert').length;
        if (alert > 0) {
          setTimeout(() => {
            $('#alert').remove();
          }, 3000);
        }

        let error = $('#error').length;
        if (error > 0) {
            setTimeout(() => {
                $('#error').remove();
            }, 3000);
        }
        $table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('payment-list') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'number',
                    name: 'number'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('body').on('click', '#show-detail', function () {
            let data_id = $(this).data('id');
            let url = "payments/" + data_id;
            $(location).attr('href', url);
        });

        
    });

</script>
@endsection