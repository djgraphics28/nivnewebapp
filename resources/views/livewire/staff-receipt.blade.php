<div>
    <!-- Main content -->
   <div class="content">
       <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card card-primary card-outline">
                   <div class="card-header">
                  <button wire:click.prevent="add()" class="btn btn-primary float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Receipt</button>
                   </div>
                   <div class="card-body">
                       @if (session()->has('message'))
                           <div class="alert alert-success">
                               {{ session('message') }}
                           </div>
                       @endif
                           <div class="form-group">
                               <input wire:model.prevent="searchTerm" type="text" class="col-md-6 form-control float-right mb-1" placeholder="Search here">
                           </div>
                           <div class="table-responsive">
                           <h6 class="card-title">Receipt Datatables</h6>
                           <table class="table table-bordered table-hover">
                               <thead>
                                   <tr>
                                        <th>#</th>
                                        <th>OR Number</th>
                                        <th>OR Date</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        {{-- <th width="500px">List of Products</th> --}}
                                        <th>Customer</th>
                                        <th>Salesman</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @forelse ($samples as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->or_number }}</td>
                                        <td>{{ $data->or_date }}</td>
                                        <td class="text-right">&#8369;{{ number_format($data->amount, 2) }}</td>
                                        <td>{{ $data->description }}</td>
                                        {{-- <td>
                                            <table class="table table-sm table-condensed table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Description</th>
                                                        <th>Quantity</th>
                                                        <th>UnitPrice</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                @php
                                                    $total = 0;
                                                    $total_amount = 0;
                                                @endphp
                                                @foreach ($data->items as $item)
                                                    @php
                                                        $total += $item->qty;
                                                        $total_amount += $item->amount * $item->qty;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $item->product->product_name }}</td>
                                                        <td>{{ $item->product->description }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td class="text-right">&#8369;{{ $item->amount }}</td>
                                                        <td class="text-right">&#8369;{{ number_format(($item->amount * $item->qty),2)}}</td>
                                                    </tr>
                                                @endforeach
                                                    <tr>
                                                        <th colspan="2">Total</th>
                                                        <th {{ $total }}</th>
                                                        <th></th>
                                                        <th class="text-right">&#8369;{{ number_format($total_amount, 2) }}</th>
                                                    </tr>
                                            </table>

                                        </td> --}}
                                        <td>{{ $data->customer->customer_name }}</td>
                                        <td>{{ $data->employee->firstname }}</td>
                                        <td>{{ $data->is_active == 1 ? "Active" : "Inactive" }}</td>
                                        <td>
                                            {{-- <a class="btn btn-success btn-sm" href="/staff/receipts/items/{{ $data->id }}"> <i class="fa fa-plus" aria-hidden="true"></i> Product</a> --}}
                                            {{-- <button title="Enter Products" class="btn btn-success btn-sm" wire:click.prevent="addProduct({{ $data->id }})"> <i class="fa fa-plus" aria-hidden="true"></i></button> --}}
                                            <button class="btn btn-warning btn-sm" wire:click.prevent="edit({{ $data->id }})"> <i class="fa fa-edit" aria-hidden="true"></i></button>
                                            <button class="btn btn-danger btn-sm" wire:click.prevent="alertConfirm({{ $data->id }})"> <i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                   @empty
                                    <tr>
                                        <td colspan="10"><center>no result found</center></td>
                                    </tr>
                                   @endforelse
                               </tbody>
                               <tfoot>
                                   <tr>
                                        <th>#</th>
                                        <th>OR Number</th>
                                        <th>OR Date</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        {{-- <th>List of Products</th> --}}
                                        <th>Customer</th>
                                        <th>Salesman</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                   </tr>
                               </tfoot>
                           </table>

                           {{ $samples->links() }}
                       </div>
                   </div>
               </div>
           </div>
           <!-- /.col-md-6 -->
       </div>
       <!-- /.row -->
       </div><!-- /.container-fluid -->
   </div>
   <!-- /.content -->

   <!-- Add Receipt Modal -->
    <div class="modal fade" id="addReceiptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add New Receipt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">OR Number</label>
                            <input type="number" wire:model.defer="or_number" class="form-control @error('or_number') is-invalid @enderror">
                            @error('or_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">OR Date</label>
                            <input type="date" class="form-control @error('or_date') is-invalid @enderror" wire:model.defer="or_date">
                            @error('or_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Salesman</label>
                            <select class="form-control @error('salesman') is-invalid @enderror" wire:model.defer="salesman">
                                <option value="">--Choose--</option>
                                @foreach ($salesmans as $data)
                                    <option value="{{ $data->id }}">{{ $data->firstname }}</option>
                                @endforeach
                            </select>
                            @error('salesman')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Customer</label>
                            <select class="form-control @error('customer') is-invalid @enderror" wire:model.defer="customer">
                                <option value="">--Choose--</option>
                                @foreach ($customers as $data)
                                    <option value="{{ $data->id }}">{{ $data->customer_name }}</option>
                                @endforeach
                            </select>
                            @error('customer')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    {{-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" wire:model.defer="amount">
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ProductName</th>
                            <th>Quantity</th>
                            <th>UnitPrice</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inputs as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <select class="form-control @error('product_id.'.$value) is-invalid @enderror"  wire:model="product_id.{{ $value }}">
                                    <option value="">-- choose ---</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name." - ".$product->description ." - UNIT > (".$product->unit.") "}}</option>
                                    @endforeach
                                </select>
                                @error('product_id.'.$value)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model="quantity.{{ $value }}" class="form-control @error('quantity.'.$value) is-invalid @enderror">
                                @error('quantity.'.$value)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model="product_amount.{{ $value }}" class="form-control @error('product_amount.'.$value) is-invalid @enderror">
                                @error('product_amount.'.$value)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                            <td>
                                <button class="btn btn-danger" wire:click.prevent="removeItem({{ $key }})">Remove</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <hr>
                <button class="btn btn-success" wire:click.prevent="addItem({{ $i }})">Add Product</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="submit()" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
   <!-- Modal -->

    <!-- EDIT Receipt Modal -->
    <div class="modal fade" id="editReceiptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Receipt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">OR Number</label>
                            <input type="number" wire:model.defer="or_number" class="form-control @error('or_number') is-invalid @enderror">
                            @error('or_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">OR Date</label>
                            <input type="date" class="form-control @error('or_date') is-invalid @enderror" wire:model.defer="or_date">
                            @error('or_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Salesman</label>
                            <select class="form-control @error('salesman') is-invalid @enderror" wire:model.defer="salesman">
                                <option value="">--Choose--</option>
                                @foreach ($salesmans as $data)
                                    <option value="{{ $data->id }}">{{ $data->firstname }}</option>
                                @endforeach
                            </select>
                            @error('salesman')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Customer</label>
                            <select class="form-control @error('customer') is-invalid @enderror" wire:model.defer="customer">
                                <option value="">--Choose--</option>
                                @foreach ($customers as $data)
                                    <option value="{{ $data->id }}">{{ $data->customer_name }}</option>
                                @endforeach
                            </select>
                            @error('customer')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="row">
                    {{-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" wire:model.defer="amount">
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ProductName</th>
                            <th>Quantity</th>
                            <th>UnitPrice</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inputs as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <select class="form-control @error('product_id.'.$value) is-invalid @enderror"  wire:model="product_id.{{ $value }}">
                                    <option value="">-- choose ---</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name." - ".$product->description ." - UNIT > (".$product->unit.") "}}</option>
                                    @endforeach
                                </select>
                                @error('product_id.'.$value)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model="quantity.{{ $value }}" class="form-control @error('quantity.'.$value) is-invalid @enderror">
                                @error('quantity.'.$value)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                            <td>
                                <input type="number" wire:model="product_amount.{{ $value }}" class="form-control @error('product_amount.'.$value) is-invalid @enderror">
                                @error('product_amount.'.$value)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                            <td>
                                <button class="btn btn-danger" wire:click.prevent="removeItem({{ $key }})">Remove</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <hr>
                <button class="btn btn-success" wire:click.prevent="addItem({{ $i }})">Add Product</button>

                <hr>

                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>UnitPrice</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receiptItems as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->product_name }}</td>
                                <td>{{ $item->product->description }}</td>
                                <td>{{ $item->qty }}</td>
                                <td><p class="text-right">{{ $item->amount }}</p></td>
                                <td>
                                    <button title="Edit Items" class="btn btn-warning btn-sm" wire:click.prevent="editReceiptProduct({{ $item->id }})"> <i class="fas fa-edit"></i></button>
                                    <button title="Delete Items" class="btn btn-danger btn-sm" wire:click.prevent="alertConfirm({{ $item->id }})"> <i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-success">Update</button>
            </div>
        </div>
        </div>
    </div>
    {{-- Modal edit --}}

    <div class="modal fade" id="editItemsReceiptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Items</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Product</label>
                    <select class="form-control" wire:model.defer="product_id">
                        <option value="">--choose---</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name." - ".$product->description ." - UNIT > (".$product->unit.") "}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Quantity</label>
                    <input type="text" class="form-control" wire:model.defer="quantity">
                </div>
                <div class="form-group">
                    <label for="">UnitPrice</label>
                    <input type="text" class="form-control" wire:model.defer="unitprice">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success" wire:click.prevent="updateItems()">Update</button>
            </div>
          </div>
        </div>
      </div>
</div>


@push('scripts')
{{-- <script>
    $(document).ready(function () {
        $('#select2-dropdown').select2();
        // $('#select2-dropdown').on('change', function (e) {
        //     var data = $('#select2-dropdown').select2("val");
        //     @this.set('customersData', data);
        // });
    });
</script> --}}
@endpush

@livewire('staff-receipt-item')

