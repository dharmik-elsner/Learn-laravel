@extends('layouts.myapp')

@section('content')
    
    <!-- Load jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Then load DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Optionally, include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">


    @if(session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif

    @if(session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    <div class="container" >
        <div class="row justify-content-center" >
            <div class="col-md-8" style="width:fit-content;">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard for Seller to Manage Websites') }}</div>

                    <div class="card-body" style="font-size: large; text-align: center; color:white;background-color: #4a90e2;">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('<==~~Website List~~==>') }}
                    </div>

                    <div class="card-footer" style="width: fit-content;">
                        <table id="sellerdata" class="display">
                            <thead>
                                <tr>
                                    <th>Website Name</th>
                                    <th>DA Score</th>
                                    <th>Publishing Time</th>
                                    <th>Example Website</th>
                                    <th>Category</th>
                                    <th>Normal Guest Price</th>
                                    <th>Normal Link Price</th>
                                    <th>FC Guest Price</th>
                                    <th>FC Link Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded by DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#sellerdata').DataTable({
                //processing: true,
                paging: true,
                pageLength: 15,
                lengthMenu: [5,10,15,20,25,30,50],
                serverSide: true,
                ajax: "{{ route('seller.data') }}",  // URL to fetch data from
                columns: [
                    { data: 'website_name' },
                    { data: 'da_score' },
                    { data: 'publishing_time' },
                    { data: 'example_website_name' },
                    { data: 'category' , orderable: false },
                    { data: 'normal_guest_price' },
                    { data: 'normal_link_price' },
                    { data: 'fc_guest_price' },
                    { data: 'fc_link_price' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                initComplete: function () {//code to stop search on keyup

                    var table = this.api();
                    $('#sellerdata_filter input')
                        .unbind()
                        .bind('keypress', function (e) {
                            if (e.keyCode === 13) { // Enter key
                                table.search(this.value).draw();
                            }
                        });
                        

                    // var api = this.api();
                    // $('#sellerdata input')
                    //     .unbind()
                    //     .bind('keypress', function (e) {
                    //         if (e.keyCode === 13) { // Enter key
                    //             api.search(this.search.value).draw();
                    //         }
                    //     });
                }
            });
        });
    </script>

@endsection
