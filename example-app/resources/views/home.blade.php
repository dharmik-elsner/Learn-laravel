@extends('layouts.app')

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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard for Admin to Manage Users') }}</div>

                    <div class="card-body" style="font-size: large; text-align: center; color:white;background-color: #4a90e2;">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('<==~~User List~~==>') }}
                    </div>

                    <div class="card-footer">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background-color: coral;" >Delete</button>
                                            </form>,
                                            <form action="{{ route('updatepage', $user->id) }}" method="GET" style="display:inline;">
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
