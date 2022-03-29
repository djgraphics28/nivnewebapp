<div>
     <!-- Form Modal -->
     <div class="modal fade" id="formAddProductToTrackingModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <form action="" wire:submit.prevent="submit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Search Product to Add for the Tracking No. {{ $tracking_number ?? '' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ProductName</th>
                                    <th>Quantity</th>
                                    <th>Price/Case</th>
                                    <th>Price/Pcs</th>
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
                                    <td>
                                        <input type="number" wire:model="price_per_case.{{ $value }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" wire:model="price_per_pcs.{{ $value }}" class="form-control">
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
                        <h4>Product Entered</h4>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ProductName</th>
                                    <th>Description</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Price/Case</th>
                                    <th>Price/Pcs</th>
                                    <th>TotalAmount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($trackings as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->product->product_name }}</td>
                                        <td>{{ $data->product->description }}</td>
                                        <td>{{ $data->product->unit }}</td>
                                        <td>{{ $data->qty }}</td>
                                        <td>{{ $data->price_per_case }}</td>
                                        <td>{{ $data->price_per_pcs }}</td>
                                        <td>{{ $data->product->unit == "CASE" || $data->product->unit == "BOX"  ?  $data->price_per_case * $data->qty : $data->price_per_pcs * $data->qty }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" wire:click.prevent="edit({{ $data->id }})"> <i class="fa fa-edit" aria-hidden="true"></i></button>
                                            <button class="btn btn-danger btn-sm" wire:click.prevent="alertConfirm({{ $data->id }})"> <i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>no products</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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

    {{-- edit modal --}}
    <div class="modal fade" id="productTrackingModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
        <form action="" wire:submit.prevent="submit">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Edit Product Tracking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Product</label>
                    <select class="form-control @error('product_id') is-invalid @enderror"  wire:model.defer="product_id">
                        <option value="">-- choose ---</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name." - ".$product->description ." - UNIT > (".$product->unit.") "}}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>

                <div class="form-group">
                     <label for="">Quantity</label>
                     <input type="number" wire:model.defer="quantity" class="form-control @error('quantity') is-invalid @enderror" >
                     @error('quantity')
                         <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                     @enderror
                </div>

                <div class="form-group">
                    <label for="">Price/Case</label>
                    <input type="number" wire:model.defer="price_per_case" class="form-control @error('price_per_case') is-invalid @enderror" >
                    @error('price_per_case')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Price/Pcs</label>
                    <input type="number" wire:model.defer="price_per_pcs" class="form-control @error('price_per_pcs') is-invalid @enderror" >
                    @error('price_per_pcs')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Date</label>
                    <input type="date" wire:model.defer="date" class="form-control @error('date') is-invalid @enderror" placeholder="Enter OR Number">
                    @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click.prevent="cancel">Cancel</button>

                <button wire:click.prevent="update" class="btn btn-success">Update</button>


            </div>

        </div>
        </form>
        </div>
    </div>
    {{-- edit modal --}}

</div>
