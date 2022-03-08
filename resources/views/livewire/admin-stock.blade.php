<div>
    <!-- Main content -->
   <div class="content">
       <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card card-primary card-outline">
                   <div class="card-header">
                  <a href="{{ route('admin.stocks.productin') }}" class="btn btn-primary float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Enter Product Stocks</a>
                   </div>
                   <div class="card-body">
                       @if (session()->has('message'))
                           <div class="alert alert-success">
                               {{ session('message') }}
                           </div>
                       @endif
                        {{--
                         --}}
                         <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-2 mb-2">
                                    <select class="form-control">
                                        <option value="">Sort by Supplier</option>
                                        @foreach ($suppliers as $data)
                                            <option value="{{ $data->id }}">{{ $data->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2 mb-2">
                                    <select class="form-control">
                                        <option value="">Sort by Product</option>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group  col-md-6 mb-2">
                                    <input wire:model.prevent="searchTerm" type="text" class="form-control" placeholder="Search here">
                                </div>
                            </div>
                         </div>



                           <div class="table-responsive">
                           <h6 class="card-title">Products Datatables</h6>
                           <table class="table table-bordered table-hover">
                               <thead>
                                   <tr>
                                        <th>#</th>
                                        <th>Stock Code</th>
                                        <th>ProductName</th>
                                        <th>Description</th>
                                        <th>Unit</th>
                                        <th>Qty</th>
                                        <th>SupplierPrice</th>
                                        <th>SellingPrice</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Branch</th>
                                        <th>Supplier</th>
                                        <th>Expr.Date</th>
                                        <th>DateDelivered</th>
                                        <th>EnterBy</th>
                                        <th>UpdateBy</th>
                                        <th>Action</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($stocks as $data)
                                       <tr>
                                           <td>{{ $loop->iteration }}</td>
                                           <td>{{ $data->stock_code }}</td>
                                           <td>{{ $data->product->product_name }}</td>
                                           <td>{{ $data->product->description }}</td>
                                           <td>{{ $data->product->unit }}</td>
                                           <td>{{ $data->qty }}</td>
                                           <td>{{ $data->price }}</td>
                                           <td>{{ $data->selling_price }}</td>
                                           <td>{{ $data->product->brand->brand_name }}</td>
                                           <td>{{ $data->product->category->category_name }}</td>
                                           <td>{{ $data->branch->branch_name }}</td>
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
                                   @endforeach
                               </tbody>
                               <tfoot>
                                   <tr>
                                        <th>#</th>
                                        <th>Stock Code</th>
                                        <th>ProductName</th>
                                        <th>Description</th>
                                        <th>Unit</th>
                                        <th>Qty</th>
                                        <th>SupplierPrice</th>
                                        <th>SellingPrice</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Branch</th>
                                        <th>Supplier</th>
                                        <th>Expr.Date</th>
                                        <th>DateDelivered</th>
                                        <th>EnterBy</th>
                                        <th>UpdateBy</th>
                                        <th>Action</th>
                                   </tr>
                               </tfoot>
                           </table>

                           {{ $stocks->links() }}
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

</div>
