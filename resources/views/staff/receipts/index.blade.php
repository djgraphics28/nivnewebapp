@extends('staff.layouts.master')

@section('title','Staff Receipts')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Receipts</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Receipts</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  @section('js-bot')
  <script>
      //add stock Modal
        window.addEventListener('show-add-product-receipt-modal', event => {
            $('#productReceiptModal').modal('show');
        })

        window.addEventListener('hide-add-product-receipt-modal', event => {
            $('#productReceiptModal').modal('hide');
        })

        window.addEventListener('show-receipt_product-modal', event => {
            $('#receiptProductEditModal').modal('show');
        })

        window.addEventListener('hide-receipt_product-modal', event => {
            $('#receiptProductEditModal').modal('hide');
        })

        window.addEventListener('show-add-receipt-modal', event => {
            $('#addReceiptModal').modal('show');
        })

        window.addEventListener('hide-add-receipt-modal', event => {
            $('#addReceiptModal').modal('hide');
        })

        // //add equipment Modal
        // window.addEventListener('show-add-equipment-modal', event => {
        //     $('#addEquipmentModal').modal('show');
        // })

        // window.addEventListener('hide-add-equipment-modal', event => {
        //     $('#addEquipmentModal').modal('hide');
        // })

        // //view stock Modal
        // window.addEventListener('show-view-stock-modal', event => {
        //     $('#viewStockModal').modal('show');
        // })

        // window.addEventListener('hide-view-stock-modal', event => {
        //     $('#viewStockModal').modal('hide');
        // })

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

@livewire('staff-receipt')

@endsection
