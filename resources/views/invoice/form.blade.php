@extends('layouts.template.app')
@section('title', 'Create Invoice - Invoiceing App')

@section('contents')
<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
          <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">{{isset($invoice) ? 'Edit Existing' : 'Add New'}} Invoice</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('invoices.index')}}" class="text-muted">Invoices</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">{{isset($invoice) ? 'Edit' : 'Add'}} Invoice</li>
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
         <form method="POST"
            action="{{ isset($invoice) ? route('invoices.update', $invoice['id']) : route('invoices.store') }}">
            @csrf
            @if(isset($invoice))
            @method('PUT')
            @endif
            <div class="card">
              <div class="card-header">
               <h4 class="page-title text-dark">Invoice</h4> 
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <h4 class="text-dark">Basic Information (Required)</h4>
                    <hr>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="number">Number</label>
                          <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number" value="{{ isset($pc) ? $pc : $invoice['number'] }}" autocomplete="off" readonly>
                          @error('number')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group">
                          <label for="order_date">Order Date</label>
                          <input type="date" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" value="{{ isset($invoice) ? $invoice['order_date'] : old('order_date') }}" required>
                          @error('order_date')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group">
                          <label for="grand_total">Grand total</label>
                          <input type="text" class="form-control @error('grand_total') is-invalid @enderror" id="grand_total" name="grand_total"
                          value="{{isset($invoice) ? $invoice['grand_total'] : (old('grand_total') ? old('grand_total') : 0) }}" readonly>
                          @error('grand_total')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>


                      </div>
                      <div class="col-6">

                        <div class="form-group">
                          <label for="partner_id">Partner</label>
                          <select id="partner_id" name="partner_id" class="form-control select2" required></select>
                          @error('partner_id')
                          <div class="invalid-feedback d-inline-block">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                        <div class="form-group">
                          <label for="type">type</label>
                          <select id="type" name="type" class="form-control">
                            <option value="sale">Sale</option>
                            <option value="purchase">Purchase</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="remarks">Remarks</label>
                          <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ isset($invoice) ? $invoice['remarks'] : old('remarks') }}</textarea>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <hr>
                    <div class="d-flex align-items-center">
                      <a href="{{ route('invoices.index') }}" type="button" class="btn btn-secondary btn-rounded mr-2">Back</a>
                      <button type="submit" class="btn btn-primary btn-rounded">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card mt-4">
              <div class="card-header">
               <h4 class="page-title text-dark">Details</h4> 
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-4">
                    <!-- Button trigger modal -->
                    <button id="add-product" type="button" class="btn-add-row btn btn-primary btn-rounded mb-3" >
                      + Add Product
                    </button>

                    <div id="productModal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">Select Product</h4>
                              <button type="button" class="close" data-dismiss="modal"
                                  aria-hidden="true">×</button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-12">
                                <div class="form-group">
                                  <input id="product_name" name="product_name" class="form-control" type="text"/>
                                  @error('product_name')
                                  <div class="invalid-feedback d-inline-block">
                                    {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">Cancel</button>
                            <button id="update-detail" type="button" class="btn btn-primary btn-rounded">Update Detail</button>
                          </div>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    
                  </div>
                  <table class="w-100" id="product_table">
										<tr>
                      <th class="d-none">No.</th>
											<th >Product name</th>
											<th >Quantity</th>
											<th >UOM</th>
											<th >Unit Price</th>
											<th >Sub Total</th>
											<th >Option</th>
											<th></th>
										</tr>
										<tr>
											<td class="d-none">1</td>
											<td>
                        <input class="form-control product_name"
                            type="text"
                            id="product_name_0"
                            name="lines[0][product_name]"
                            />
											</td>
                      <td>
                        <input class="form-control quantity"
                            type="number"
                            min="1"
                            value="1"
                            id="quantity_0"
                            name="lines[0][quantity]"
                            onchange="calculatePrice()"
                            />
											</td>
                      <td>
                        <input class="form-control uom"
                            type="text"
                            min="1"
                            id="uom_0"
                            name="lines[0][uom]"
                            />
											</td>
											<td>
                        <input class="form-control unit_price"
                            type="number"
                            min="0"
                            value="0"
                            id="unit_price_0"
                            name="lines[0][unit_price]"
                            onchange="calculatePrice()"
                            />
											</td>
											
											<td>
												<input class="form-control sub_total"
													type="number"
													min="0"
													value="0"
													id="sub_total_0"
													name="lines[0][sub_total]" 
													/>
											</td>
											<td>
												<button class="btn btn-sm btn-clean btn-icon btn-delete-row"
													type="button"
													title="Delete">
													<p class="m-0 font-weight-bold">-</p>
												</button>
											</td>
										</tr>
									</table>
                  <!-- <table class="table">
                    <thead>
                      <tr>
                        <td class="font-weight-bold">Product SKU</td>
                        <td class="font-weight-bold">Name</td>
                        <td class="font-weight-bold">Unit Price</td>
                        <td class="font-weight-bold">Quantity</td>
                        <td class="font-weight-bold">Sub Total</td>
                        <td class="font-weight-bold">Option</td>
                        <hr>
                      </tr>
                    </thead>
                    <tbody id="detail-product-table">
                    </tbody>
                  </table> -->
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

@section('scripts')
<script type="text/javascript">

function calculatePrice() {
      let grandTotal = $('#grand_total');
      let subTotal = $('.sub_total');
      let inputQuantity = $('.quantity');
      let inputUnitprice = $('.unit_price');
      let subTotalPrice;
      let totalProductPrice = 0;

      for (var i = 0; i < inputQuantity.length; i++) {
          inputQuantity[i].addEventListener('change', function(event){
          let unitPrice = $(this).parent().siblings().children('.unit_price').val();
          let subTotal = $(this).parent().siblings().children('.sub_total');
          let result = parseInt(unitPrice) * event.target.value;
          subTotal.val(result);
          calsubtotal();
        });
      }
      for (var i = 0; i < inputUnitprice.length; i++) {
          inputUnitprice[i].addEventListener('change', function(event){
          let quantity = $(this).parent().siblings().children('.quantity').val();
          let subTotal = $(this).parent().siblings().children('.sub_total');
          let result = parseInt(quantity) * event.target.value;
          subTotal.val(result);
          calsubtotal();
        });
      }
      calsubtotal();
    }
    function calsubtotal() {
      let grandTotal = $('#grand_total');
      let subTotal = $('.sub_total');
      let totalProductPrice = 0;
      for (var i = 0; i < subTotal.length; i++) {
        subTotalPrice = subTotal[i].value;
        
        totalProductPrice += parseInt(subTotalPrice);
        grandTotal.val(totalProductPrice);
      }
    }
    
  $(function(){    
    
   
    let productRaw;

  

    function drawTable(productRaw){
      console.log(productRaw);
      let refId = 'id' + (new Date()).getTime();
      let product = productRaw;
      let table = document.querySelector('#detail-product-table');
      let firstRow = document.createElement("tr");
      let nextRow = document.createElement("tr");
      let productSKU = document.createElement("td");
      let productName = document.createElement("td");
      let productPrice = document.createElement("td");
      let productQuantity = document.createElement("td");
      let productSubTotal = document.createElement("td");
      let inputProduct = document.createElement('input');
      let inputQty = document.createElement('input');
      let inputName = document.createElement('input');
      let removeContainer = document.createElement('td')
      let remove = document.createElement('a');

      remove.className = "btn btn-danger btn-rounded btn-sm remove-product m-1 text-light";
      remove.innerHTML = "Remove this product";
      remove.dataset.ref = `${refId}`;
      removeContainer.appendChild(remove);
      // productSKU.innerHTML = product.sku;
      productSKU.innerHTML = "";
      // productSKU.innerHTML = document.getElementById("product_name").value;
      // console.log(productSKU,"aaaaaaaaaaa");
      inputName.type="hidden";
      inputName.className="form-control";
      // inputName.name = `product_id[${product.id}]`;
      // inputName.value = product.id;
      // productName.innerHTML = product.name;
      // productName.appendChild(inputName);
      // productPrice.innerHTML = product.unit_price;
      // productPrice.className = "unit-price";
      inputQty.type="number";
      inputQty.className="input-quanity form-control";
      // inputQty.name = `quantity[${product.id}]`;
      // inputQty.value = product.quantity ?? 0;
      inputQty.min = 0;
      // productQuantity.appendChild(inputQty);
      // productSubTotal.innerHTML = product.sub_total ?? 0;
      productSubTotal.className = "sub-total";
      firstRow.className = `${refId}`;
      firstRow.appendChild(productSKU);
      firstRow.appendChild(productName);
      firstRow.appendChild(productPrice);
      firstRow.appendChild(productQuantity);
      firstRow.appendChild(productSubTotal);
      firstRow.appendChild(removeContainer);
      table.appendChild(firstRow.cloneNode(true));
          
      let inputQuantity = $('.input-quanity');
      for (var i = 0; i < inputQuantity.length; i++) {
          inputQuantity[i].addEventListener('change', function(event){
          let unitPrice = $(this).parent().siblings('.unit-price').text().trim();
          let subTotal = $(this).parent().siblings('.sub-total');
          let result = +unitPrice * event.target.value;
          subTotal.text(result);
          calculatePrice();
        });
      }
      calculatePrice();
    }

    function deleteRow(event) {
			if($("#product_table tr").length === 2) {
				alert("You cannot delete the last row!");
				return;
			}
			$(event.target).closest("tr").remove();
			calculatePrice();
		}

    function addProductRow(data = null) {
			let oldRow = $("#product_table tr:last-child").first();
			let newRow = oldRow.clone();
			let curRowNum = newRow.find("td:first-child").html();
			newRow.find("td:first-child").html((parseInt(curRowNum) + 1));
      newRow.find("td:nth-child(2) input").attr("id", "product_name_"+curRowNum)
				.attr("name", "lines["+curRowNum+"][product_name]")
				.val("");
      newRow.find("td:nth-child(3) input").attr("id", "quantity_"+curRowNum)
        .attr("name", "lines["+curRowNum+"][quantity]")
        .attr("onchange","calculatePrice()")
				.val(0);
        newRow.find("td:nth-child(4) input").attr("id", "uom_"+curRowNum)
				.attr("name", "lines["+curRowNum+"][uom]")
				.val("");
      newRow.find("td:nth-child(5) input").attr("id", "unit_price_"+curRowNum)
        .attr("name", "lines["+curRowNum+"][unit_price]")
        .attr("onchange","calculatePrice()")
				.val(0);
			
			newRow.find("td:nth-child(6) input").attr("id", "sub_total_"+curRowNum)
				.attr("name", "lines["+curRowNum+"][sub_total]")
				.val(0);
      $("#product_table").append(newRow);

			if(data !== null && data.product_name) {
				newRow.find("td:nth-child(2) input").val(data.product_name);
				newRow.find("td:nth-child(3) input").val(data.quantity);
				newRow.find("td:nth-child(4) input").val(data.uom);
				newRow.find("td:nth-child(5) input").val(data.unit_price);
				newRow.find("td:nth-child(6) input").val(data.sub_total);
			}
			$(".btn-delete-row").prop("onclick", null).off("click");
			$(".btn-delete-row").on('click', deleteRow);
			calculatePrice();
		}
		$(".btn-add-row").on('click', addProductRow);


    function remove_last_row(){
      let oldRow = $("#product_table tr:nth-child(2)");
      oldRow.remove();
    }

    function getinvoiceDetails(id){
        let invoiceDetailURL = window.location.origin + "/invoices/details/";
        let pruductDetailURL = window.location.origin + "/product/details/";
        let invoiceDetails;
        let productList = [];
        let productRaw = [];

        // request invoice detail
        $.ajax({
          url: invoiceDetailURL + id,
          success: function(invoiceDetails){
            invoiceDetails = invoiceDetails;
            // productGrouping
            // invoiceDetails.map(invoiceDetail => {
            //   if(!productList.includes(invoiceDetail.product_id)){
            //     productList.push(invoiceDetail.product_id);
            //   }
            // }
            // );

            
            // create model
            productList.forEach(productId => {
              $.ajax({
                url: pruductDetailURL + productId,
                success: function(product){
                  let newProduct = {
                    id: product.id,
                    name: product.name,
                    sku: product.sku,
                    unit_price: product.unit_price,
                  }
                  let thisInvoiceDetail = invoiceDetails.filter(invoice => {
                    return invoice.product_id == productId;
                  });
                  console.log(thisInvoiceDetail);
                  thisInvoiceDetail.forEach(invoiceDetail => {
                    // let newProductDetail = {};
                    // newProduct.id = invoiceDetail.product_id,
                    newProduct.invoice_id = invoiceDetail.invoice_id,
                    newProduct.quantity = invoiceDetail.quantity,
                    newProduct.sub_total = invoiceDetail.sub_total
                  })

                  // draw table
                  drawTable(newProduct);
                },
                error: function(){
                  return;
                }
              });

            });
          },
          error: function(data){
            return;
          }
        });
    }

    calculatePrice();

    $('#unit_price').on('change', function(){
      calculatePrice();
    });

    $('#quantity').on('change', function(){
      calculatePrice();
    });
    $('.subTotal').on('change keyup', function(){
      calculatePrice();
    });

    $('#transport_cost').on('change', function(){
      calculatePrice();
    });

    $('#shipping_cost').on('change', function(){
      calculatePrice();
    });

    $('#productModal').on('show.bs.modal', function(){
      $("#product_id").empty().trigger('change')
      drawTable();
    })

    $('body').on('click', '#add-product', function () {
        // let productId = $('#product_id').val();
        // let productURL = window.location.origin + "/product/selected/" + productId;
        // $('#productModal').modal('hide');
        // $.ajax({
        //   url: productURL,
        //   success: function(product){
        //     drawTable(product); 
        //   }
        // });
        
    });
    
    $('body').on('click', '.remove-product', function(){
      let ref = $(this).data('ref');
      let elements = $("."+ref);
      elements.remove();
      setTimeout(()=>{
        calculatePrice();
      }, 500)
    });

    $('#partner_id').select2({
      placeholder: "Search for partner...",
      minimumInputLength: 1,
      ajax: {
        url: "{{route('partner-select')}}",
        dataType: 'json',
        delay: 250,
        data: function(params){
          return {
            q: $.trim(params.term)
          }
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
      }
    });

    $('#product_id').select2({
      placeholder: "Search for product...",
      minimumInputLength: 1,
      ajax: {
        url: "{{route('product-select')}}",
        dataType: 'json',
        delay: 250,
        data: function(params){
          return {
            q: $.trim(params.term)
          }
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
        cache: true
      },
      dropdownParent: $('#productModal'),
      width: '100%',
      allowClear: true
    });

    @if(isset($invoice))
      @php
        $partner = \App\Models\Partner::find($invoice->partner_id);
      @endphp
      let partner = {
          id: '{{ $partner->id }}',
          text: '{{$partner->name }}'
      };
      let partnerOption = new Option(partner.text, partner.id, false, false);
      $('#partner_id').append(partnerOption).trigger('change');
      let invoiceId = '{{$invoice->id}}';
      let invoice_lines;
      @foreach ($invoice->invoice_lines as $key => $lines)
        // colecting data
        invoice_lines =({
          product_name : "{{$lines['product_name']}}",
          unit_price: "{{$lines['price']}}",
          uom: "{{$lines['uom']}}",
          quantity: "{{$lines['quantity']}}",
          sub_total : "{{$lines['sub_total']}}",
        });
        addProductRow(invoice_lines);
        console.log(invoice_lines);
      @endforeach
      remove_last_row();
      // getinvoiceDetails(invoiceId);
    @endif

    @if(old('partner_id'))
      @php
      $partner = \App\Models\Partner::find(old('partner_id'));
      @endphp
      let partner = {
          id: '{{ $partner->id }}',
          text: '{{$partner->name }}'
      };
      let partnerOption = new Option(partner.text, partner.id, false, false);
      $('#partner_id').append(partnerOption).trigger('change');
    @endif

    @if(old('lines'))
      let productIds = [];
      let validProductIds = [];
      let invoice_lines = [];

      @foreach(old('lines') as $key => $value)
        // colecting data
        invoice_lines.push({
          product_name : "{{$value['product_name']}}",
          unit_price: "{{$value['unit_price']}}",
          uom: "{{$value['uom']}}",
          quantity: "{{$value['quantity']}}",
          sub_total : "{{$value['sub_total']}}",
        });
      @endforeach
      
      // product grouping
      // productIds.forEach(id => {
      //   if(!validProductIds.includes(id)){
      //     validProductIds.push(id);
      //   }
      // });

      // creating model
      validProductIds.forEach(id => {
        $.ajax({
          url: pruductDetailURL + id,
          success: function(product){
            let newProduct = {
              id: product.id,
              name: product.name,
              sku: product.sku,
              photo: product.photo,
            };

            let newProductDetail = {
              id: product.id,
              name: product.name,
              unit_price: product.unit_price,
              sku: product.sku,
            }
            productDetails.forEach(productDetail => {
              if(productDetails.id == product.id){
                newProductDetail.quantity = productDetail.quantity;
                newProductDetail.sub_total = productDetail.quantity * product.unit_price;
              }
            })
            // productDetails.push(newProductDetail);
            newProduct = {
              ...newProductDetail,
            };

            // draw table
            drawTable(newProduct);
          },
          error: function(){
            return;
          }
        });
      })
      calculatePrice();
    @endif
})
</script>
@endsection