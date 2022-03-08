<div>
    <!-- Main content -->
   <div class="content">
       <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card card-primary card-outline">
                   <div class="card-header">
                  <button wire:click.prevent="addNew()" class="btn btn-primary float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Product</button>
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
                                               <button class="btn btn-warning" wire:click.prevent="edit({{ $data->id }})"> Edit</button>
                                               <button class="btn btn-danger" wire:click.prevent="confirmation({{ $data->id }})"> Delete</button>
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
               <h5 class="modal-title" id="formModalLabel">Add New Product</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>

           </div>
           <div class="modal-body">

                <div class="form-group">
                    <label for="">Branch</label>
                    <select wire:model.defer="branch_id" class="form-control @error('branch_id') is-invalid @enderror">
                        <option value="">Choose</option>
                        @foreach ($branches as $data)
                            <option value="{{ $data->id }}">{{ $data->branch_name }}</option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

               <div class="form-group">
                   <label for="">Product Name</label>
                   <input type="text" wire:model.defer="product_name" class="form-control @error('product_name') is-invalid @enderror" placeholder="Enter Product Name">
                   @error('product_name')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                   @enderror
               </div>

               <div class="form-group">
                    <label for="">SKU/Product #</label>
                    <input type="text" wire:model.defer="sku" class="form-control @error('sku') is-invalid @enderror" placeholder="Enter SKU">
                    @error('sku')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Description</label>
                    <input type="text" wire:model.defer="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description">
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

               <div class="form-group">
                   <label for="">Unit</label>
                   <select wire:model.defer="unit" class="form-control @error('unit') is-invalid @enderror">
                       <option value="">Choose</option>
                       <option value="PIECE">PIECE</option>
                       <option value="CASE">CASE</option>
                       <option value="BOX">BOX</option>
                   </select>
                   @error('unit')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                   @enderror
               </div>

               <div class="form-group">
                    <label for="">Brand</label>
                    <select wire:model.defer="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                        <option value="">Choose</option>
                        @foreach ($brands as $data)
                            <option value="{{ $data->id }}">{{ $data->brand_name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Category</label>
                    <select wire:model.defer="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">Choose</option>
                        @foreach ($categories as $data)
                            <option value="{{ $data->id }}">{{ $data->category_name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Upload Photo</label>
                    <input type="file" wire:model.defer="image_url" class="form-control @error('image_url') is-invalid @enderror">
                    @error('image_url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
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

   <!-- Confirmation Modal -->
   <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true" wire:ignore.self>
       <div class="modal-dialog" role="document">
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
