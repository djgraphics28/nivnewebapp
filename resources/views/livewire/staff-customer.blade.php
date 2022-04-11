<div>
    <!-- Main content -->
   <div class="content">
       <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card card-primary card-outline">
                   <div class="card-header">
                  <button wire:click.prevent="addNew()" class="btn btn-primary float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Customer</button>
                   </div>
                   <div class="card-body">
                       @if (session()->has('message'))
                           <div class="alert alert-success">
                               {{ session('message') }}
                           </div>
                       @endif
                    <div class="row">
                       <div class="col-md-2">
                        <label for="">Sort by Province</label>
                        <select class="form-control" wire:model.prevent="sortByProvince">
                             <option value="">All</option>
                             @foreach ($provinces as $data)
                                 <option value="{{ $data->province_code }}">{{ $data->province_description }}</option>
                             @endforeach
                         </select>
                    </div>
                    <div class="col-md-2">
                        <label for="">Sort by City/Municipality</label>
                         <select class="form-control" wire:model.prevent="sortByCity">
                             <option value="">All</option>
                             @if (!is_null($sortByProvince))
                                @foreach ($cities as $data)
                                    <option value="{{ $data->city_municipality_code }}">{{ $data->city_municipality_description }}</option>
                                @endforeach
                            @endif
                         </select>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Rows per Page</label>
                            <select class="form-control" wire:model.prevent="perPage">
                                <option value="">Per Page</option>
                                <option value="5">5 per page</option>
                                <option value="10">10 per page</option>
                                <option value="15">15 per page</option>
                                <option value="50">50 per page</option>
                                <option value="100">100 per page</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="">Search Name</label>
                        <input wire:model.prevent="searchTerm" type="text" class="form-control" placeholder="Search here">
                    </div>
                   </div>
<hr>
                           <div class="table-responsive">
                                <h6 class="card-title">Customer Datatables</h6>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                    <th>#</th>
                                                    <th>CustomerName</th>
                                                    <th>Address</th>
                                                    <th>Channel</th>
                                                    <th>Contact</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($customers as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->city->city_municipality_description ?? NULL }}, {{ $data->province->province_description ?? NULL }}</td>
                                                    <td>{{ $data->channel }}</td>
                                                    <td>{{ $data->contact_number }}</td>
                                                    <td>{{ $data->email }}</td>
                                                    <td>{{ $data->is_active == 1 ? "Active" : "Inactive" }}</td>
                                                    <td>
                                                        <button class="btn btn-warning" wire:click.prevent="edit({{ $data->id }})"> Edit</button>
                                                        <button class="btn btn-danger" wire:click.prevent="confirmation({{ $data->id }})"> Delete</button>
                                                    </td>
                                                </tr>

                                            @empty
                                                <tr>
                                                    <td class="center" colspan="7">No Record found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                    <th>#</th>
                                                    <th>CustomerName</th>
                                                    <th>Address</th>
                                                    <th>Channel</th>
                                                    <th>Contact</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                {{ $customers->links() }}
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
               <h5 class="modal-title" id="formModalLabel">Add New Customer</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>

           </div>
           <div class="modal-body">

               <div class="form-group">
                   <label for="">Customer Name</label>
                   <input type="text" wire:model.defer="customer_name" class="form-control @error('customer_name') is-invalid @enderror" placeholder="Enter Customer Name">
                   @error('customer_name')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                   @enderror
               </div>

                <div class="form-group">
                    <label for="">Channel</label>
                    <select wire:model.defer="channel" class="form-control @error('channel') is-invalid @enderror">
                        <option value="">Choose</option>
                        <option value="Grocery">Grocery</option>
                        <option value="Super Market">Super Market</option>
                        <option value="Sari-Sari Store">Sari-Sari Store</option>
                    </select>
                    @error('channel')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

               <div class="form-group">
                    <label for="">Province</label>
                    <select type="text" wire:model="selectedProvince" class="form-control @error('selectedProvince') is-invalid @enderror">
                        <option value="">--choose--</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->province_code }}">{{ $province->province_description }}</option>
                        @endforeach
                    </select>
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Municipality/City</label>
                    <select type="text" wire:model="city" class="form-control @error('city') is-invalid @enderror">
                        <option value="">--choose--</option>
                        @if (!is_null($selectedProvince))
                            @foreach($cities as $city)
                                <option value="{{ $city->city_municipality_code }}">{{ $city->city_municipality_description }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('address')
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
                    <label for="">Email Address</label>
                    <input type="text" wire:model.defer="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email Address">
                    @error('email')
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
    <!-- Form Modal -->

</div>
