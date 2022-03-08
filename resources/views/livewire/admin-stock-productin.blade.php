<div>
    <!-- Main content -->
   <div class="content">
       <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card card-primary card-outline">
                   <div class="card-header">
                  {{-- <button wire:click.prevent="addNew()" class="btn btn-primary float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Product</button> --}}
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
                           <h6 class="card-title">Products Datatables</h6>
                           <table class="table table-bordered table-hover">
                               <thead>
                                   <tr>
                                        <th>#</th>
                                        <th>ProductName</th>
                                        <th>SKU/Product #</th>
                                        <th>Unit</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Branch</th>
                                        <th>Action</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($products as $data)
                                       <tr>
                                           <td>{{ $loop->iteration }}</td>
                                           <td>{{ $data->product_name }}</td>
                                           <td>{{ $data->sku }}</td>
                                           <td>{{ $data->unit }}</td>
                                           <td>{{ $data->brand->brand_name }}</td>
                                           <td>{{ $data->category->category_name }}</td>
                                           <td>{{ $data->branch->branch_name }}</td>
                                           <td>
                                               <button class="btn btn-primary" wire:click.prevent="selectProduct({{ $data->id }})"><i class="fas fa-hand-pointer"></i> Select</button>

                                           </td>
                                       </tr>
                                   @endforeach
                               </tbody>
                               <tfoot>
                                   <tr>
                                        <th>#</th>
                                        <th>ProductName</th>
                                        <th>SKU/Product #</th>
                                        <th>Unit</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Branch</th>
                                        <th>Action</th>
                                   </tr>
                               </tfoot>
                           </table>

                           {{ $products->links() }}
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

   <!-- Form Modal -->
   <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" wire:ignore.self>
       <div class="modal-dialog" role="document">
       <form action="" wire:submit.prevent="submit">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Enter Product Stock</h5>
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

                <div class="form-group">
                    <label for="">Enter Stock Code</label>
                    <input type="text" wire:model.prevent="stock_code" class="form-control @error('stock_code') is-invalid @enderror">
                    @error('stock_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Enter Supplier Price</label>
                    <input type="number" wire:model.prevent="price" class="form-control @error('price') is-invalid @enderror">
                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Enter Selling Price</label>
                    <input type="number" wire:model.prevent="selling_price" class="form-control @error('selling_price') is-invalid @enderror">
                    @error('selling_price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click.prevent="cancel">Cancel</button>

                    <button wire:click.prevent="submit" class="btn btn-primary">Save</button>

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
