<div>
    <!-- Form Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
        <form action="" wire:submit.prevent="submit">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Add New Tracking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
             <div class="row" wire:ignore.self>
                 <div class="col-md-3">
                     <div class="form-group">
                         <label for="">Vehicle</label>
                         <select wire:model.defer="vehicle" class="form-control @error('vehicle') is-invalid @enderror" id="select2bs4">
                              <option value="">Choose</option>
                              <option value="Truck 1">Truck 1</option>
                              <option value="Truck 2">Truck 2</option>
                              <option value="Van 1">Van 1</option>
                              <option value="Van 2">Van 2</option>
                          </select>
                          @error('vehicle')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                     </div>
                 </div>
                 <div class="col-md-3">
                     <div class="form-group">
                         <label for="">Salesman</label>
                         <select wire:model.defer="salesman" class="form-control @error('salesman') is-invalid @enderror">
                              <option value="">Choose</option>
                          </select>
                          @error('vehicle')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                     </div>
                 </div>
                 <div class="col-md-3">
                     <div class="form-group">
                         <label for="">Vehicle</label>
                         <select wire:model.defer="vehicle" class="form-control @error('vehicle') is-invalid @enderror">
                              <option value="">Choose</option>
                              <option value="Truck 1">Truck 1</option>
                              <option value="Truck 2">Truck 2</option>
                              <option value="Van 1">Van 1</option>
                              <option value="Van 2">Van 2</option>
                          </select>
                          @error('vehicle')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                     </div>
                 </div>

             </div>

             <hr>
             <h4>Add Product</h4>
             <div class="row">
                 <div class="col-md-3">
                     <div class="form-group">
                         <label for="">Choose Product</label>
                        <input type="text" class="form-control" placeholder="Choose Product">
                     </div>

                 </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Enter Quantity</label>
                       <input type="text" class="form-control" placeholder="Choose Product">
                    </div>

                </div>
             </div>

            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click.prevent="cancel">Cancel</button>
                @if ($updateMode == true)
                    <button wire:click.prevent="update" class="btn btn-success">Update</button>
                @else
                    <button wire:click.prevent="submit" class="btn btn-primary">Save</button>
                @endif --}}

            </div>

        </div>
        </form>
        </div>
    </div>
</div>
