<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery Receipt</title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
    <P class="text-center"><b>NIVNE MARKETING BINALONAN TRUCK INVENTORY</b></P>
    @foreach ($items as $item)
    <label for="">Tracking No.: <u>{{ $item->tracking_number }}</u></label>
    <label for=""> Salesman: <u>{{ $item->employee->firstname.' '.$item->employee->lastname }}</u></label>
    <label for=""> Vehicle: <u>{{ $item->vehicle }}</u></label>

    <label for=""> Date Load: <u>{{ $item->date_product_out }}</u></label>
    <label for=""> Date Return: <u>_______________</u></label>
    <table class="table table-bordered table-condensed table-sm text-sm-center small">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Description</th>
                <th>QTY</th>
                <th>Unit</th>
                <th>Loading</th>
                <th>Return</th>
            </tr>
        </thead>
        <tbody>
                @forelse ($item->product_tracking as $data)


                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->product->product_name }}</td>
                        <td>{{ $data->product->description }}</td>
                        <td></td>
                        <td>{{ $data->product->unit }}</td>
                        <td>{{ $data->qty }}</td>
                        <td>{{ $data->return_qty }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No Data</td>
                    </tr>
                @endforelse


            <tr></tr>
        </tbody>
    </table>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

</body>


</html>
