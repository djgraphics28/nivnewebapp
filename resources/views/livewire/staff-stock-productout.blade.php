<div>
    <!-- Main content -->
   <div class="content">
       <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card card-primary card-outline">
                   <div class="card-header">
                  <button wire:click.prevent="add()" class="btn btn-primary float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Tracking</button>
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

                            <h6 class="card-title">Tracking Datatables</h6>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tracking No.</th>
                                        <th>Salesman</th>
                                        <th>Vehicle</th>
                                        <th>Total Products</th>
                                        <th>Total Items Load</th>
                                        <th>Total Items Return</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($productouts as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->tracking_number }}</td>
                                            <td>{{ $data->employee->firstname ." ". $data->employee->lastname}}</td>
                                            <td>{{ $data->vehicle }}</td>
                                            <td>{{ $data->product_tracking_count }}</td>
                                            <td>{{ $data->product_tracking_sum_qty }}</td>
                                            <td>{{ $data->product_tracking_sum_return_qty }}</td>
                                            <td>
                                                <button class="btn btn-success btn-sm" wire:click.prevent="addProduct({{ $data->id }})"> <i class="fa fa-plus" aria-hidden="true"></i> Load</button>
                                                <button class="btn btn-danger btn-sm" wire:click.prevent="stockReturn({{ $data->id }})"> Return</button>
                                                {{-- <button class="btn btn-primary" title="Download Delivery Receipt" wire:click.prevent="edit({{ $data->id }})"> <i class="fa fa-download" aria-hidden="true"></i></button> --}}
                                                <a href="/staff/generate-delivery-receipt/{{ $data->id  }}" class="btn btn-primary btn-sm"><i class="fa fa-print" aria-hidden="true"></i></a>
                                                <button class="btn btn-warning btn-sm" wire:click.prevent="edit({{ $data->id }})"> <i class="fa fa-edit" aria-hidden="true"></i></button>
                                                <button class="btn btn-danger btn-sm" wire:click.prevent="confirmation({{ $data->id }})"> <i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="center" colspan="6">No Record found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tracking No.</th>
                                        <th>Salesman</th>
                                        <th>Vehicle</th>
                                        <th>Total Products</th>
                                        <th>Total Items Load</th>
                                        <th>Total Items Return</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>


                        </div>
               </div>
           </div>
           <!-- /.col-md-6 -->
       </div>
       <!-- /.row -->
       </div><!-- /.container-fluid -->
   </div>
   <!-- /.content -->

  {{-- @livewire('staff-stocks-productout-modal') --}}

   <!-- Form Modal -->
   <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
    <form action="" wire:submit.prevent="submit">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModalLabel">Add New Tracking</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <div class="modal-body">
                 <div class="form-group">
                     <label for="">Vehicle</label>
                     <select wire:model.defer="vehicle" class="form-control @error('vehicle') is-invalid @enderror" id="select2bs4">
                          <option value="">Choose</option>
                          <option value="Truck 1">Truck 1</option>
                          <option value="Truck 2">Truck 2</option>
                          <option value="Van 1">Van 1</option>
                          <option value="Van 2">Van 2</option>
                      </select>
                      @error('vehicle')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                 </div>
                 <div class="form-group">
                    <label for="">Salesman</label>
                        <select class="form-control @error('salesman') is-invalid @enderror" wire:model.defer="salesman">
                            <option value="">Choose</option>
                            @foreach ($employees as $data)
                                <option value="{{ $data->id }}">{{ $data->firstname. " "  .$data->lastname }}</option>
                            @endforeach
                        </select>
                      @error('salesman')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                 </div>
                 <div class="form-group">
                     <label for="">Date</label>
                    <input type="date" wire:model.defer="date" class="form-control @error('date') is-invalid @enderror">
                      @error('date')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                 </div>

         {{-- <hr>
         <h4>Add Product</h4>
         <div class="row">
             <div class="col-md-3">
                 <div class="form-group">
                     <label for="">Choose Product</label>
                    <input type="text" class="form-control" placeholder="Choose Product">
                 </div>

             </div>
             <div class="col-md-3">
                <div class="form-group">
                    <label for="">Enter Quantity</label>
                   <input type="text" class="form-control" placeholder="Choose Product">
                </div>

            </div>
         </div> --}}

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click.prevent="cancel">Cancel</button>
            @if ($updateMode == true)
                <button wire:click.prevent="update" class="btn btn-success">Update</button>
            @else
                <button wire:click.prevent="submit" class="btn btn-primary">Save</button>
            @endif

        </div>

    </div>
    </form>
    </div>
</div>

   <!-- Return Modal -->
   <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true" wire:ignore.self>
       <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="returnModalLabel">Return Stocks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    {{-- <div class="d-flex">
                        <button class="btn btn-primary float-right">Enter Other Return</button>
                    </div> --}}
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ProductName</th>
                                    <th>Description</th>
                                    <th>Unit</th>
                                    <th>No. of Items Return</th>
                                    <th>No. in Pieces</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->product->product_name }}</td>
                                        <td>{{ $item->product->description }}</td>
                                        <td>{{ $item->return_unit }}</td>
                                        <td>{{ $item->return_qty ." ".$item->return_unit."(s)"}}</td>
                                        <td>{{ $item->pieces_qty ." pcs"}}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" wire:click.prevent="enterReturnQty({{ $item->id }})"> <i class="fa fa-edit" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
       </div>
   </div>

   <!-- Confirmation Modal -->
   <div class="modal fade" id="confirmationModaltracking" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Delete Tracking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <h3>Are you sure you want to delete this?</h3>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button wire:click.prevent="delete()" type="button" class="btn btn-danger">Yes, Delete it.</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
  <!-- Form Modal -->
  <div class="modal fade" id="returnQty" tabindex="-1" role="dialog" aria-labelledby="returnQtyLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
    <form action="" wire:submit.prevent="submitReturnQty">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModalLabel">Return Stocks</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Unit</label>
               <select wire:model.defer="return_unit" class="form-control @error('return_unit') is-invalid @enderror">
                   <option value="">Choose</option>
                   <option value="BOX">BOX</option>
                   <option value="CASE">CASE</option>
                   <option value="PIECE">PIECE</option>
               </select>
                @error('return_unit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Enter Quantity <span>({{ $return_unit }})</span></label>
                <input type="number" wire:model.defer="return_qty" class="form-control @error('return_qty') is-invalid @enderror">
                @error('return_qty')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Enter Quantity (pieces)</label>
                <input type="number" wire:model.defer="pieces_qty" class="form-control @error('pieces_qty') is-invalid @enderror">
                @error('pieces_qty')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Enter Return Date</label>
                <input type="date" wire:model.defer="date_return" class="form-control @error('date_return') is-invalid @enderror">
                @error('date_return')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click.prevent="cancel">Cancel</button>

            <button wire:click.prevent="submitReturnQty" class="btn btn-primary">Save</button>


        </div>

    </div>
    </form>
    </div>
</div>


</div>
</div>
@livewire('staff-stock-add-product-to-tracking')
