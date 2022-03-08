<div>
    <!-- Main content -->
   <div class="content">
       <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card card-primary card-outline">
                   <div class="card-header">
                  <a href="{{ route('staff.stocks.productin') }}" class="btn btn-primary float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Enter Product Stocks</a>
                   </div>
                   <div class="card-body">
                       @if (session()->has('message'))
                           <div class="alert alert-success">
                               {{ session('message') }}
                           </div>
                       @endif
                        {{--
                         --}}
                         {{-- <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-2 mb-2">
                                    <select class="form-control" wire:model.prevent="sortBySupplier">
                                        <option value="">Sort by Supplier</option>
                                        @foreach ($suppliers as $data)
                                            <option value="{{ $data->id }}">{{ $data->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-1 mb-2">
                                    <select class="form-control" wire:model.prevent="perPage">
                                        <option value="">Per Page</option>
                                        <option value="5">5 per page</option>
                                        <option value="10">10 per page</option>
                                        <option value="15">15 per page</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 mb-2">
                                    <input wire:model.prevent="searchTerm" type="text" class="form-control" placeholder="Search here">
                                </div>
                            </div>
                         </div> --}}

                         <div class="row">
                            <div class="col-md-2">
                                <label for="">Sort by Supplier</label>
                                <select class="form-control" wire:model.prevent="sortBySupplier">
                                    <option value="">All</option>
                                    @foreach ($suppliers as $data)
                                        <option value="{{ $data->id }}">{{ $data->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-md-2">
                                <label for="">Sort by Category</label>
                                 <select class="form-control" wire:model.prevent="sortByCategory">
                                     <option value="">All</option>
                                     @foreach ($categories as $data)
                                         <option value="{{ $data->id }}">{{ $data->category_name }}</option>
                                     @endforeach
                                 </select>
                            </div> --}}
                            {{-- <div class="col-md-2">
                                 <label for="">Sort by Unit</label>
                                 <select class="form-control" wire:model.prevent="sortByUnit">
                                     <option value="">All</option>
                                     <option value="PIECE">PIECE</option>
                                     <option value="CASE">CASE</option>
                                     <option value="BOX">BOX</option>
                                 </select>
                             </div> --}}
                            <div class="col-md-2">
                                 <label for="">Rows per Page</label>
                                 <select class="form-control" wire:model.prevent="perPage">
                                     <option value="">Per Page</option>
                                     <option value="5">5 per page</option>
                                     <option value="10">10 per page</option>
                                     <option value="15">15 per page</option>
                                 </select>
                            </div>
                            <div class="col-md-8">
                                 <label for="">Search by StockCode</label>
                                 <input wire:model.prevent="searchTerm" type="text" class="form-control" placeholder="Search here">
                            </div>
                        </div>

                        <hr>

                           <div class="table-responsive">
                           <h6 class="card-title">Products Datatables</h6>
                           <table class="table table-bordered table-hover table-sm">
                               <thead>
                                   <tr>
                                        <th>#</th>
                                        <th>Stock Code</th>
                                        <th>ProductName</th>
                                        <th>Description</th>
                                        <th>Unit</th>
                                        <th>Qty</th>
                                        <th>Price/Case|Box</th>
                                        <th>Price/Piece</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        {{-- <th>Branch</th> --}}
                                        <th>Supplier</th>
                                        <th>Expr.Date</th>
                                        <th>DateDelivered</th>
                                        <th>EnterBy</th>
                                        <th>UpdateBy</th>
                                        <th>Action</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @forelse ($stocks as $data)
                                       <tr>
                                           <td>{{ $data->id }}</td>
                                           <td>{{ $data->stock_code }}</td>
                                           <td>{{ $data->product->product_name }}</td>
                                           <td>{{ $data->product->description }}</td>
                                           <td>{{ $data->product->unit }}</td>
                                           <td>{{ $data->qty }}</td>
                                           <td>{{ $data->price }}</td>
                                           <td>{{ $data->price_per_pcs }}</td>
                                           <td>{{ $data->product->brand->brand_name }}</td>
                                           <td>{{ $data->product->category->category_name }}</td>
                                           {{-- <td>{{ $data->branch->branch_name }}</td> --}}
                                           <td>{{ $data->supplier->supplier_name }}</td>
                                           <td>{{ $data->expr_date}}</td>
                                           <td>{{ $data->date_delivered}}</td>
                                           <td>{{ $data->created_by}}</td>
                                           <td>{{ $data->updated_by}}</td>
                                           <td>
                                               <button class="btn btn-warning" wire:click.prevent="edit({{ $data->id }})"> Edit</button>
                                               <button class="btn btn-danger" wire:click.prevent="confirmation({{ $data->id }})"> Delete</button>
                                           </td>
                                       </tr>
                                   @empty
                                       <tr>
                                           <td colspan="16">No Record Found</td>
                                       </tr>
                                   @endforelse
                               </tbody>
                               <tfoot>
                                   <tr>
                                        <th>#</th>
                                        <th>Stock Code</th>
                                        <th>ProductName</th>
                                        <th>Description</th>
                                        <th>Unit</th>
                                        <th>Qty</th>
                                        <th>Price/Case|Box</th>
                                        <th>Price/Piece</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        {{-- <th>Branch</th> --}}
                                        <th>Supplier</th>
                                        <th>Expr.Date</th>
                                        <th>DateDelivered</th>
                                        <th>EnterBy</th>
                                        <th>UpdateBy</th>
                                        <th>Action</th>
                                   </tr>
                               </tfoot>
                           </table>
                       </div>{{-- responsive div --}}

                       {{ $stocks->links() }}
                   </div>
               </div>
           </div>
           <!-- /.col-md-6 -->
       </div>
       <!-- /.row -->
       </div><!-- /.container-fluid -->
   </div>
   <!-- /.content -->
    <!-- Form Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
        <form action="" wire:submit.prevent="submit">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="formModalLabel">Edit Product Stock</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>

             </div>
             <div class="modal-body">
                 <div class="form-group">
                     <label for="">Supplier</label>
                     <select wire:model.prevent="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                         <option value="">Choose</option>
                         @foreach ($suppliers as $data)
                             <option value="{{ $data->id }}">{{ $data->supplier_name }}</option>
                         @endforeach
                     </select>
                     @error('supplier_id')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label for="">Enter Quantity</label>
                     <input type="number" wire:model.prevent="qty" class="form-control @error('qty') is-invalid @enderror">
                     @error('qty')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                 {{-- <div class="form-group">
                     <label for="">Enter Stock Code</label>
                     <input type="text" wire:model.prevent="stock_code" class="form-control @error('stock_code') is-invalid @enderror">
                     @error('stock_code')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div> --}}

                 <div class="form-group">
                     <label for="">Supplier Price Per Case/Box</label>
                     <input type="number" wire:model.prevent="price" class="form-control @error('price') is-invalid @enderror">
                     @error('price')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label for="">Enter Selling Price Per Case/Box</label>
                     <input type="number" wire:model.prevent="selling_price" class="form-control @error('selling_price') is-invalid @enderror">
                     @error('selling_price')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label for="">Enter Price per Pcs</label>
                     <input type="number" wire:model.prevent="price_per_pcs" class="form-control @error('price_per_pcs') is-invalid @enderror">
                     @error('price_per_pcs')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label for="">Enter Selling Price per Pcs</label>
                     <input type="number" wire:model.prevent="selling_per_pcs" class="form-control @error('selling_per_pcs') is-invalid @enderror">
                     @error('selling_per_pcs')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                 {{-- <div class="form-group">
                     <label for="">Enter Price per Pcs</label>
                     <input type="number" wire:model.prevent="price_per_pcs" class="form-control @error('price_per_pcs') is-invalid @enderror">
                     @error('price_per_pcs')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div> --}}

                 <div class="form-group">
                     <label for="">Enter Delivery Date</label>
                     <input type="date" wire:model.prevent="date_delivered" class="form-control @error('date_delivered') is-invalid @enderror">
                     @error('date_delivered')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label for="">Enter Expiration Date</label>
                     <input type="date" wire:model.prevent="expr_date" class="form-control @error('expr_date') is-invalid @enderror">
                     @error('expr_date')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                 </div>
                 <div class="form-group">
                    <label for="">Classification</label>
                    <select wire:model.prevent="classification" class="form-control @error('classification') is-invalid @enderror">
                        <option value="">Choose</option>
                        <option value="non-promo">Non Promo</option>
                        <option value="promo">Promo</option>
                    </select>
                    @error('classification')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click.prevent="cancel">Cancel</button>

                     <button wire:click.prevent="update" class="btn btn-primary">Update</button>

             </div>
         </div>
        </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="confirmationModalLabel">Delete Product</h5>
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
</div>
