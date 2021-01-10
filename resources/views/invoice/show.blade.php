@extends('layouts.template.app')
@section('title', 'Detail Invoice - Invoice App')

@section('contents')

<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
          <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Detail Invoice</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('invoices.index')}}" class="text-muted">Invoice</a></li>
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
                    <h4>Basic Information (Required)</h4>
                    <hr>
                    <div class="row">
                      <div class="col-6">
                        <div>
                          <h6>Invoice Code:</h6>
                          <p>{{$invoice->number}}</p>
                        </div>
                        <div>
                          <h6>Order Date:</h6>
                          <p>{{$invoice->order_date}}</p>
                        </div>
                        <div>
                          <h6>Grand total:</h6>
                          <p>{{$invoice->grand_total}}</p>
                        </div>
                      </div>
                      <div class="col-6">
                        <div>
                          <h6>Partner:</h6>
                          <p>{{\App\Models\Invoice::getPartnerName($invoice->partner_id)}}</p>
                        </div>
                        <div>
                          <h6>Remark:</h6>
                          <p>{{$invoice->remarks}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
            
            <div class="col-md-6">
              <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <div class="card-title m-0">
                    Invoice Items
                  </div>
                </div>
                <div class="card-body row">
                <table>
                  <tr>
                    <th >Product name</th>
                    <th >Quantity</th>
                    <th >UOM</th>
                    <th >Unit Price</th>
                    <th >Sub Total</th>
                  </tr>
                  @foreach($productList as $product)
                  <td>
                      <h5>{{$product['product_name']}} </h5>
                  </td>
                    
                  <td >
                    <h5>{{$product['quantity']}} </h5>
                  </td>
                  <td >
                    <h5>{{$product['uom']}} </h5>
                  </td>
                  <td >
                    <h5>{{$product['price']}} </h5>
                  </td>
                  <td >
                      <h5>{{$product['sub_total']}} </h5>
                  </td>
                  @endforeach
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title m-0">
                  Detail Payment
                </div>
              </div>
              <div class="card-body">
                <ul class="list-group">
                @if(count($payments) < 1)
                <li class="list-group-item">
                  No Attachment
                </li>
                @endif
                @foreach ($payments as $payment)
                <li class="list-group-item">
                  <h6>Payment type:</h6>
                  <p>{{\App\Helpers\PaymentType::getString($payment->type) }}</p>
                  <h6>Payment amount:</h6>
                  <p>{{$payment->amount}}</p>
                  
                </li>
                @endforeach
                </ul>
              </div>
            </div>
            </div>
          </div>
          <div id="paymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <label for="amount">Amount</label>
                            <input  type="text" class="form-control" id="amount" name="amount" autocomplete="off">
                            
                            <!-- <label for="left-amount">Left Amount</label>
                            <input type="text" class="form-control" id="left-amount" name="left-amount" autocomplete="off" readonly> -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cancel</button>
                      <button id="create_payment" type="button" class="btn btn-primary btn-rounded">Create Payment</button>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->
            @if($invoice->state =='confirm')
          <button class="btn btn-success btn-rounded mr-2" type="button" data-toggle="modal" data-target="#paymentModal" data-id='.$data->id.'>Add Payment</button>
          <br/>
          @endif
          <a href="{{ route('invoices.index') }}" type="button" class="btn btn-secondary btn-rounded mr-2">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(function () {
        $('body').on('click', '#download', function () {
            let data_id = $(this).data("id");
            let url = window.location.origin + "/payments/download/" + data_id;
            $(location).attr('href', url);
        });

        $('body').on('click', '#create_payment', function () {
          let id = '{{$invoice->id}}';
          let amount = $("#amount").val();
          console.log(id);

          let url = window.location.origin + "/invoices-payment";
          $.ajax({
              url: url,
              type: 'POST',
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {
                  id: id,
                  amount: amount
              },
              success: function (data) {
                console.log(data);
                if (data.message){
                  let message =data.message;
                  $('#update-status-alert').append(message);
                }
                
                var table =  $(".yajra-datatable").DataTable();
                table.ajax.reload();
                var element = document.getElementById("update-status-alert");
                    element.classList.remove("d-none");
                    setTimeout(()=>{
                      element.classList.add("d-none");
                    }, 3000);
                    location.reload();
              },
              
            });
            $("#paymentModal").modal('hide');
        });
    });
</script>
@endsection