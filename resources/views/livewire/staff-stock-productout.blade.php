<div>
    <!-- Main content -->
   <div class="content">
       <div class="container-fluid">
       <div class="row">
           <div class="col-lg-12">
               <div class="card card-primary card-outline">
                   <div class="card-header">
                  <button wire:click.prevent="add()" class="btn btn-primary float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Tracking</button>
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

                                <h6 class="card-title">Tracking Datatables</h6>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tracking No.</th>
                                            <th>Salesman</th>
                                            <th>Vehicle</th>
                                            <th>Total Items</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>


                            </div>
               </div>
           </div>
           <!-- /.col-md-6 -->
       </div>
       <!-- /.row -->
       </div><!-- /.container-fluid -->
   </div>
   <!-- /.content -->

  @livewire('staff-stocks-productout-modal')

   <!-- Confirmation Modal -->
   <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true" wire:ignore.self>
       <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
           <h5 class="modal-title" id="confirmationModalLabel">Delete Tracking</h5>
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
</div>
