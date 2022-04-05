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
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Start</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="">End</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Search Tracking Number here</label>
                                    <input wire:model.prevent="searchTerm" type="text" class="form-control" placeholder="Search Tracking Number here">
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <h6 class="card-title">Trucking Datatables</h6>
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Tracking Number</th>
                                                <th>Date of Tracking</th>
                                                <th>Salesman</th>
                                                <th>Vehicle</th>
                                                <th></th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($truckinventories as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->tracking_number }}</td>
                                                    <td>{{ $data->date_load }}</td>
                                                    <td>{{ $data->employee->firstname }}</td>
                                                    <td>{{ $data->vehicle }}</td>
                                                    <td>
                                                        <table class="table table-sm table-condensed table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date Load</th>
                                                                    <th>No. of Items Load</th>
                                                                    <th>Date Return</th>
                                                                    <th>No. of Items Return</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>

                                                            @foreach ($data->tracking_dates as $item)
                                                                <tr>
                                                                    <td><button wire:click.prevent="showItems({{ $item->id }})" title="click here to show list of items" class="btn btn-primary">{{ $item->date_load  }}</td>
                                                                    <td></td>
                                                                    <td><button title="click here to show list of items" {{ $item->date_return ? '' : 'disabled' }} class="btn btn-warning">{{ $item->date_return ?  $item->date_return : '0000-00-00'}}</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <button title="Edit Items" class="btn btn-warning btn-sm" wire:click.prevent="edit({{ $item->id }})"> <i class="fas fa-edit"></i></button>
                                                                        <button title="Delete Items" class="btn btn-danger btn-sm" wire:click.prevent="alertConfirm({{ $item->id }})"> <i class="fas fa-trash"></i></button>
                                                                    </td>

                                                                </tr>
                                                            @endforeach

                                                        </table>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success" wire:click.prevent="addNewLoading({{ $data->id }})"> Add</button>
                                                        <button class="btn btn-warning" wire:click.prevent="edit({{ $data->id }})"> Edit</button>
                                                        <button class="btn btn-danger" wire:click.prevent="confirmation({{ $data->id }})"> Delete</button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7"><center>No Record Found</center></td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Tracking Number</th>
                                                <th>Date of Tracking</th>
                                                <th>Salesman</th>
                                                <th>Vehicle</th>
                                                <th></th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                            {{ $truckinventories->links() }}
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

<!-- Tracking Modal -->
<div class="modal fade" id="TrackingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="trackingModalLabel">Tracking</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
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
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Salesman</label>
                            <select class="form-control @error('salesman') is-invalid @enderror" wire:model.defer="salesman">
                                <option value="">Choose</option>
                                @foreach ($salesmans as $data)
                                    <option value="{{ $data->id }}">{{ $data->firstname. " "  .$data->lastname }}</option>
                                @endforeach
                            </select>
                          @error('salesman')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                     </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Date</label>
                       <input type="date" wire:model.defer="date_load" class="form-control @error('date_load') is-invalid @enderror">
                         @error('date_load')
                             <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                         @enderror
                    </div>
                </div>

                <hr>

                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ProductName</th>
                            <th>Quantity</th>
                            {{-- <th>Price/Case</th>
                            <th>Price/Pcs</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inputs as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <select class="form-control"  wire:model="product_id.{{ $value }}">
                                    <option value="">-- choose ---</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name." - ".$product->description ." - UNIT > (".$product->unit.") "}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" wire:model="quantity.{{ $value }}" class="form-control">
                            </td>
                            {{-- <td>
                                <input type="number" wire:model="price_per_case.{{ $value }}" class="form-control">
                            </td>
                            <td>
                                <input type="number" wire:model="price_per_pcs.{{ $value }}" class="form-control">
                            </td> --}}
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
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" wire:click.prevent="submit()">Save changes</button>
        </div>
      </div>
    </div>
</div>



<!-- Tracking Modal -->
<div class="modal fade" id="itemsTrackingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="trackingModalLabel">Items for Tracking No.: {{ $tracking_number." | Date Load: ". $tracking_date ." | Salesman: ". $salesman}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Price/Case</th>
                            <th>Price/Piece</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($truckItems as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->products->product_name }}</td>
                                <td>{{ $item->products->description }}</td>
                                <td>{{ $item->products->unit }}</td>
                                <td>{{ $item->load_quantity }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" wire:click.prevent="submit()">Save changes</button>
        </div>
      </div>
    </div>
</div>

<!-- add new loading Modal -->
<div class="modal fade" id="addNewLoadingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="trackingModalLabel">Add new Loading for Tracking No.: {{ $tracking_number." | Salesman: ". $salesman}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group">
                <label for="">Date</label>
               <input type="date" wire:model.defer="date_load" class="form-control @error('date_load') is-invalid @enderror">
                 @error('date_load')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                 @enderror
            </div>
          </div>
          <div class="row">
            <hr>

                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ProductName</th>
                            <th>Quantity</th>
                            {{-- <th>Price/Case</th>
                            <th>Price/Pcs</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inputs as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <select class="form-control"  wire:model="product_id.{{ $value }}">
                                    <option value="">-- choose ---</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name." - ".$product->description ." - UNIT > (".$product->unit.") "}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" wire:model="quantity.{{ $value }}" class="form-control">
                            </td>
                            {{-- <td>
                                <input type="number" wire:model="price_per_case.{{ $value }}" class="form-control">
                            </td>
                            <td>
                                <input type="number" wire:model="price_per_pcs.{{ $value }}" class="form-control">
                            </td> --}}
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
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" wire:click.prevent="saveNewItemsToTracking()">Save changes</button>
        </div>
      </div>
    </div>
</div>

</div>
