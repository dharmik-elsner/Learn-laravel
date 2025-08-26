@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<style> body { font-family: Arial, sans-serif; background-color: #f4f7fc; margin: 0; padding: 0; } h1 { text-align: center; color: #4a90e2; font-size: 48px; margin-top: 50px; font-weight: bold; }  table { width: 100%; border-collapse: collapse; margin-top: 30px; } th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; } th { background-color: #4a90e2; color: white; font-size: 16px; } td { font-size: 14px; color: #555; } .action-buttons { display: flex; gap: 10px; } .action-buttons button { padding: 8px 16px; border: none; cursor: pointer; font-size: 14px; border-radius: 4px; transition: background-color 0.3s; } .action-buttons .update-btn { background-color: #007bff; color: white; } .action-buttons .update-btn:hover { background-color: #0056b3; } .action-buttons .delete-btn { background-color: #f44336; color: white; } .action-buttons .delete-btn:hover { background-color: #d32f2f; } </style>
    
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update the User information') }}</div>

                <div class="card-body" style="font-size: large; text-align: center; color:white;background-color: #4a90e2;">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('<==~~User Details~~==>') }}
                </div>

                <div class="card-footer">
                    <form action="/update" method="post" id="update-form">    
                        @csrf
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <table>
                            <tr>
                                <td>
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" value="{{ $data->email }}" readonly>   
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="newname">Name:</label>
                                    <input type="text" id="name" name="name" value="{{ $data->name }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="role">Role:</label>
                                    <!-- Radio buttons for Role -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="buyer" value="Buyer" {{ $data->role == 'Buyer' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="buyer">
                                            Buyer
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="seller" value="Seller" {{ $data->role == 'Seller' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="seller">
                                            Seller
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" name="submit" id="submit" value="Update">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
