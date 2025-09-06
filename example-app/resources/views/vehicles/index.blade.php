<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <table id="vehiclesTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Model</th>
                <th>Brand</th>
                <th>Year</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded by DataTables -->
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#vehiclesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('vehicles.data') }}",  // URL to fetch data from
                columns: [
                    { data: 'id' },
                    { data: 'model' },
                    { data: 'brand' },
                    { data: 'year' },
                    { data: 'created_at' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
</body>
</html>
