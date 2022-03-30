<div>
    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                   <button wire:click.prevent="addNew()" class="btn btn-primary float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Products</button>
                    </div>
                    <div class="card-body">

                            <div class="form-group">
                                <input wire:model.prevent="searchTerm" type="text" class="col-md-6 form-control float-right mb-1" placeholder="Search here">
                            </div>
                            <div class="table-responsive">
                            <h6 class="card-title">Product Lists</h6>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                         <th>#</th>
                                         <th>ProductName</th>
                                         <th>Description</th>
                                         <th>Brand</th>
                                         <th>Category</th>
                                         <th>Stocks</th>
                                         <th>LowStockNumber</th>
                                         <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($supplier_products as $product)
                                        @forelse ($product->products as $prod)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $prod->product_name }}</td>
                                                <td>{{ $prod->description }}</td>
                                                <td>{{ $prod->brand->brand_name }}</td>
                                                <td>{{ $prod->category->category_name }}</td>
                                                <td>{{ $prod->stocks }}</td>
                                                <td>{{ $prod->stockalert }}</td>
                                                <td>
                                                    <button class="btn btn-warning" wire:click.prevent="edit({{ $prod->id }})"> Edit</button>
                                                    <button class="btn btn-danger" wire:click.prevent="confirmation({{ $prod->id }})"> Delete</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8"><center>No Record Found</center></td>
                                            </tr>
                                        @endforelse

                                    @endforeach
                                    {{-- @forelse ($supplier_products->products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <button class="btn btn-warning" wire:click.prevent="edit({{ $product->id }})"> Edit</button>
                                                <button class="btn btn-danger" wire:click.prevent="confirmation({{ $product->id }})"> Delete</button>
                                            </td>
                                        </tr>
                                     @empty

                                    @endforelse --}}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>ProductName</th>
                                        <th>Description</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Stocks</th>
                                        <th>LowStockNumber</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>

                            {{-- {{ $supplier_products->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


     <!-- Add Receipt Modal -->
     <div class="modal fade" id="addSupplierProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
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
</div>
