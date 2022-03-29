<div>
   <!-- Form Modal -->
   <div class="modal fade" id="productReceiptModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" wire:ignore.self>
       <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
       <form action="" wire:submit.prevent="submit">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="formModalLabel">Add Product to OR Number - {{ $or_number }} | Salesman : {{ $salesman }} | Customer : {{ $customer }}</h5>
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
                            <th>UnitPrice</th>
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
                                <input type="number" wire:model="amount.{{ $value }}" class="form-control">
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
                            <th>Amount</th>
                            <th>TotalAmount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receipt_products as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->product->product_name }}</td>
                                <td>{{ $data->product->description }}</td>
                                <td>{{ $data->product->unit }}</td>
                                <td>{{ $data->qty }}</td>
                                <td>{{ $data->amount }}</td>
                                <td>{{ $data->qty * $data->amount }}</td>

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

                <button wire:click.prevent="submit" class="btn btn-primary">Save</button>


           </div>

       </div>
       </form>
       </div>
   </div>

   <!-- Confirmation Modal -->
   <div class="modal fade" id="receiptProductEditModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true" wire:ignore.self>
       <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
           <h5 class="modal-title" id="confirmationModalLabel">Edit Product?</h5>
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
                    <label for="">Unit Price</label>
                    <input type="number" wire:model.defer="amount" class="form-control @error('amount') is-invalid @enderror" >
                    @error('amount')
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
       </div>
   </div>

</div>
