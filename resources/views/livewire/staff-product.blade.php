<div>
    <!-- Main content -->
   <div class="content">
       <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card card-primary card-outline">
                   <div class="card-header">
                  <button wire:click.prevent="addNew()" class="btn btn-primary float-left"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Product</button>
                  <button wire:click.prevent="addNew()" class="btn btn-success float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Bulk Stocks</button>
                   </div>
                   <div class="card-body">
                       @if (session()->has('message'))
                           <div class="alert alert-success">
                               {{ session('message') }}
                           </div>
                       @endif

                       <div class="row">
                        <div class="col-md-2">
                            <label for="">Sort by Brand</label>
                            <select class="form-control" wire:model.prevent="sortByBrand">
                                 <option value="">All</option>
                                 @foreach ($brands as $data)
                                     <option value="{{ $data->id }}">{{ $data->brand_name }}</option>
                                 @endforeach
                             </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">Sort by Category</label>
                             <select class="form-control" wire:model.prevent="sortByCategory">
                                 <option value="">All</option>
                                 @foreach ($categories as $data)
                                     <option value="{{ $data->id }}">{{ $data->category_name }}</option>
                                 @endforeach
                             </select>
                        </div>
                        <div class="col-md-2">
                             <label for="">Sort by Unit</label>
                             <select class="form-control" wire:model.prevent="sortByUnit">
                                 <option value="">All</option>
                                 <option value="PIECE">PIECE</option>
                                 <option value="CASE">CASE</option>
                                 <option value="BOX">BOX</option>
                             </select>
                         </div>
                        <div class="col-md-2">
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
                        <div class="col-md-4">
                             <label for="">Search by SKU or Product Name</label>
                             <input wire:model.prevent="searchTerm" type="text" class="form-control" placeholder="Search here">
                        </div>
                    </div>

                    <hr>
                           <div class="table-responsive">
                                <h6 class="card-title">Products Datatables</h6>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>SKU/Product #</th>
                                                <th>ProductName</th>
                                                <th>Description</th>
                                                <th>Unit</th>
                                                <th>Brand</th>
                                                <th>Category</th>
                                                <th>Price/Case</th>
                                                <th>Price/Pcs</th>
                                                <th>Available Stocks</th>
                                                <th>Low Level Alert</th>
                                                {{-- <th>Branch</th> --}}
                                                <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $data)
                                            <tr class="{{ $data->stocks <= $data->stockalert ? 'table-danger' : ''}}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img style="width: 50px;" src="{{ Storage::disk('photo')->url($data->image_url) }}" alt=""></td>
                                                <td>{{ $data->sku }}</td>
                                                <td>{{ $data->product_name }}</td>
                                                <td>{{ $data->description }}</td>
                                                <td>{{ $data->unit }}</td>
                                                <td>{{ $data->brand->brand_name }}</td>
                                                <td>{{ $data->category->category_name }}</td>
                                                <td>{{ $data->activePrice->price_per_case ?? NULL }}</td>
                                                <td>{{ $data->activePrice->price_per_pcs ?? NULL }}</td>
                                                <td>{{ $data->stocks }}</td>
                                                <td>{{ $data->stockalert ? $data->stockalert : "" }}</td>
                                                {{-- <td width="50px"><input wire:model="stockalert" type="text" class="form-control" value="{{ $data->stockalert }}"></td> --}}
                                                {{-- <td width="50px"><input type="text" class="form-control"></td> --}}
                                                {{-- <td>{{ $data->branch->branch_name }}</td> --}}
                                                <td>
                                                    <button title="Add New Stock" class="btn btn-success btn-sm" wire:click.prevent="addNewStock({{ $data->id }})"> <i class="fas fa-plus"></i></button>
                                                    <button title="Edit Product" class="btn btn-warning btn-sm" wire:click.prevent="edit({{ $data->id }})"> <i class="fas fa-edit"></i></button>
                                                    <button title="View Stock History" class="btn btn-primary btn-sm" wire:click.prevent="showStocksHistory({{ $data->id }})"> <i class="fas fa-eye"></i></button>
                                                    <button title="Set/Edit Pricing" class="btn btn-info btn-sm" wire:click.prevent="setPrice({{ $data->id }})"> <i class="fas fa-dollar-sign"></i></button>
                                                    <button title="Delete Product" class="btn btn-danger btn-sm" wire:click.prevent="alertConfirm({{ $data->id }})"> <i class="fas fa-trash"></i></button>
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
                                                <th>Image</th>
                                                <th>SKU/Product #</th>
                                                <th>ProductName</th>
                                                <th>Description</th>
                                                <th>Unit</th>
                                                <th>Brand</th>
                                                <th>Category</th>
                                                <th>Price/Case</th>
                                                <th>Price/Pcs</th>
                                                <th>Available Stocks</th>
                                                <th>Low Level Alert</th>
                                                {{-- <th>Branch</th> --}}
                                                <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                       </div><!-- responsive div -->
                       {{ $products->links() }}
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
   <div class="modal fade" id="formProductModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" wire:ignore.self>
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
                {{-- <div class="form-group">
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
                </div> --}}
                @if ($image_url)
                    {{-- Photo Preview: --}}
                    <img width="200px" src="{{ $image_url->temporaryUrl() }}">
                @endif
                <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" wire:model.defer="image_url" class="form-control">

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
                    <label for="">Price/Case</label>
                    <input type="number" class="form-control @error('price_per_case') is-invalid @enderror" wire:model.defer="price_per_case">
                    @error('price_per_case')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Price/Piece</label>
                    <input type="number" class="form-control @error('price_per_pcs') is-invalid @enderror" wire:model.defer="price_per_pcs">
                    @error('price_per_pcs')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Number of Stocks</label>
                    <input type="number" class="form-control @error('stocks') is-invalid @enderror" wire:model.defer="stocks">
                    @error('stocks')
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
                <label for="">Enter Stock Low Level Alert</label>
                <input type="number" wire:model.prevent="stockalert" class="form-control @error('expr_date') is-invalid @enderror">
                @error('stockalert')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            {{-- <div class="form-group">
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

   {{-- StockHistory Modal --}}
   <div class="modal fade" id="stocks-history-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Stocks History</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-stripped">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>StockCode</th>
                      <th>Qty</th>
                      <th>Date Delivered</th>
                      <th>Expiration Date</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($hisProd as $data )
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->stock_code }}</td>
                        <td>{{ $data->qty }}</td>
                        <td>{{ $data->date_delivered }}</td>
                        <td>{{ $data->expr_date }}</td>
                    </tr>
                @endforeach
              </tbody>
          </table>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Send message</button> --}}
        </div>
      </div>
    </div>
  </div>
   {{-- StockHistory Modal --}}

   {{-- Add New Stock Modal --}}
   <div class="modal fade" id="addNewStockmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Stock to {{ $product_name }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">Supplier</label>
                <select class="form-control @error('supplier_id') is-invalid @enderror" wire:model.defer="supplier_id">
                    <option value="">-- Choose --</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                    @endforeach
                </select>

                @error('supplier_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Quantity</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" wire:model.defer="quantity">
                @error('quantity')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Date</label>
                <input type="date" class="form-control @error('date_in') is-invalid @enderror" wire:model.defer="date_in">
                @error('date_in')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" wire:click.prevent="saveNewStock()">Save</button>
        </div>
      </div>
    </div>
  </div>
   {{-- Add New Stock Modal --}}

   {{-- Set Price Modal --}}
   <div class="modal fade" id="setPriceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Set New Price to {{ $product_name }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="form-group">
                <label for="">Price/Case</label>
                <input type="number" class="form-control @error('price_per_case') is-invalid @enderror" wire:model.defer="price_per_case">
                @error('price_per_case')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Price/Piece</label>
                <input type="number" class="form-control @error('price_per_pcs') is-invalid @enderror" wire:model.defer="price_per_pcs">
                @error('price_per_pcs')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Date Priced</label>
                <input type="date" class="form-control @error('date_priced') is-invalid @enderror" wire:model.defer="date_priced">
                @error('date_priced')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <hr>

            <h3>Price Histories</h3>
            <table class="table table-condensed table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Price/Case</th>
                        <th>Price/Piece</th>
                        <th>Date Priced</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($price_histories as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->price_per_case }}</td>
                            <td>{{ $data->price_per_pcs }}</td>
                            <td>{{ $data->date_priced }}</td>
                            <td>{{ $data->is_active == TRUE ? "Active" : "Not Active"}}</td>
                            <td>
                                <button title="Edit Price" class="btn btn-warning btn-sm" wire:click.prevent="editPrice({{ $data->id }})"> <i class="fas fa-edit"></i></button>
                                <button title="Delete Price" class="btn btn-danger btn-sm" wire:click.prevent="deletePrice({{ $data->id }})"> <i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" wire:click.prevent="setPriceSubmit()">Save</button>
        </div>
      </div>
    </div>
  </div>
   {{-- Set Price Modal --}}

</div>
