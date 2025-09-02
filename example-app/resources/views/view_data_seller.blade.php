@extends('layouts.myapp')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style> body { font-family: Arial, sans-serif; background-color: #f4f7fc; margin: 0; padding: 0; } h1 { text-align: center; color: #4a90e2; font-size: 48px; margin-top: 50px; font-weight: bold; }  table { width: 100%; border-collapse: collapse; margin-top: 30px; } th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; } th { background-color: #4a90e2; color: white; font-size: 16px; } td { font-size: 14px; color: #555; } .action-buttons { display: flex; gap: 10px; } .action-buttons button { padding: 8px 16px; border: none; cursor: pointer; font-size: 14px; border-radius: 4px; transition: background-color 0.3s; } .action-buttons .update-btn { background-color: #007bff; color: white; } .action-buttons .update-btn:hover { background-color: #0056b3; } .action-buttons .delete-btn { background-color: #f44336; color: white; } .action-buttons .delete-btn:hover { background-color: #d32f2f; } </style>
    
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
                        <table>
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
                                @foreach ($websites as $website)
                                    <tr>
                                        <td>{{ $website->website_name }}</td>
                                        <td>{{ $website->da_score }}</td>
                                        <td>{{ $website->publishing_time }}</td>
                                        <td>{{ $website->example_website_name }}</td>
                                        <td>{{ $website->category }}</td>
                                        <td>{{ $website->normal_guest_price ?? '-'}}</td>
                                        <td>{{ $website->normal_link_price ?? '-'}}</td>
                                        <td>{{ $website->fc_guest_price ?? '-'}}</td>
                                        <td>{{ $website->fc_link_price ?? '-'}}</td>
                                        <td style="justify-content: center; display: flex;">
                                            <form action="{{ route('website.destroy', $website->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background-color: coral;" >Delete</button>
                                            </form>,
                                            <form action="{{ route('website.edit', $website->id) }}" method="GET" style="display:inline;">
                                                @csrf
                                                <button type="submit" style="background-color: lightblue;">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
