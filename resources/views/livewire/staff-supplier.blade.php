<div>
    <!-- Main content -->
   <div class="content">
       <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card card-primary card-outline">
                   <div class="card-header">
                  <button wire:click.prevent="addNew()" class="btn btn-primary float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Supplier</button>
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
                           <h6 class="card-title">Suppliers Datatables</h6>
                           <table class="table table-bordered table-hover">
                               <thead>
                                   <tr>
                                       <th>#</th>
                                       <th>SupplierName</th>
                                       <th>Email</th>
                                       <th>Contact#</th>
                                       <th>Address</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($suppliers as $data)
                                       <tr>
                                           <td>{{ $data->id }}</td>
                                           <td>{{ $data->supplier_name }}</td>
                                           <td>{{ $data->email }}</td>
                                           <td>{{ $data->contact_number }}</td>
                                           <td>{{ $data->address }}</td>
                                           <td>{{ $data->is_active == 1 ? "Active" : "Inactive" }}</td>
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
                                        <th>SupplierName</th>
                                        <th>Email</th>
                                        <th>Contact#</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                   </tr>
                               </tfoot>
                           </table>

                           {{ $suppliers->links() }}
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
               <h5 class="modal-title" id="formModalLabel">Add New Supplier</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>

           </div>
           <div class="modal-body">

                {{-- <div class="form-group">
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
                </div> --}}

               <div class="form-group">
                   <label for="">Supplier Name</label>
                   <input type="text" wire:model.defer="supplier_name" class="form-control @error('supplier_name') is-invalid @enderror" placeholder="Enter Supplier Name">
                   @error('supplier_name')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                   @enderror
               </div>

               <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" wire:model.defer="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email Address">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Contact Number</label>
                    <input type="text" wire:model.defer="contact_number" class="form-control @error('contact_number') is-invalid @enderror" placeholder="Enter Contact Number">
                    @error('contact_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" wire:model.defer="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address">
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

               <div class="form-group">
                   <label for="">Status</label>
                   <select wire:model.defer="is_active" class="form-control @error('is_active') is-invalid @enderror">
                       <option value="">Choose</option>
                       <option value="1">Active</option>
                       <option value="0">Inactive</option>
                   </select>
                   @error('is_active')
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
           <h5 class="modal-title" id="confirmationModalLabel">Delete Supplier</h5>
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
