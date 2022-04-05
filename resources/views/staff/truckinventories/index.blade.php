@extends('staff.layouts.master')

@section('title','Staff Truck Invetories')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Truck Inventory</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Truck Inventory</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
  <!-- /.content-header -->



@livewire('staff-truck-inventory')

@endsection

@section('js-bot')
<script>
    //add stock Modal
      window.addEventListener('show-add-tracking-modal', event => {
          $('#TrackingModal').modal('show');
      })

      window.addEventListener('hide-add-tracking-modal', event => {
          $('#TrackingModal').modal('hide');
      })

      window.addEventListener('show-items-tracking-modal', event => {
          $('#itemsTrackingModal').modal('show');
      })

      window.addEventListener('hide-items-tracking-modal', event => {
          $('#itemsTrackingModal').modal('hide');
      })

      window.addEventListener('show-add-loading-modal', event => {
          $('#addNewLoadingModal').modal('show');
      })

      window.addEventListener('hide-add-loading-modal', event => {
          $('#addNewLoadingModal').modal('hide');
      })

      window.addEventListener('swal:modal', event => {
          swal({
              title: event.detail.message,
              text: event.detail.text,
              icon: event.detail.type,
          });
      });

      window.addEventListener('swal:confirm', event => {
          swal({
                  title: event.detail.message,
                  text: event.detail.text,
                  icon: event.detail.type,
                  buttons: true,
                  dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                      window.livewire.emit('remove');
                  }
          });
      });
</script>
@endsection
