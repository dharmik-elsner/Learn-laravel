@extends('layouts.myapp')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fc;
        margin: 0;
        padding: 0;
    }
    h1 {
        text-align: center;
        color: #4a90e2;
        font-size: 48px;
        margin-top: 50px;
        font-weight: bold;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
    }
    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #4a90e2;
        color: white;
        font-size: 16px;
    }
    td {
        font-size: 14px;
        color: #555;
    }
    input, select {
        padding: 8px;
        width: 100%;
        margin-top: 5px;
    }
    .form-check {
        margin-top: 5px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Website Details') }}</div>

                <div class="card-body" style="font-size: large; text-align: center; color:white;background-color: #4a90e2;">
                    {{ __('<==~~Website Form~~==>') }}
                </div>

                <div class="card-footer">
                    <form action="/save-website" method="post" id="website-form">
                        @csrf
                        <table>
                            <tr>
                                <td>
                                    <label for="website_name">Website URL:</label>
                                    <input type="text" id="website_name" name="website_name" required value="@if(isset($website)){{ $website->website_name }}@endif"  @if(isset($website))readonly @endif>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="da_score">DA Score (1–100):</label>
                                    <input type="number" id="da_score" name="da_score" min="1" max="100" required value="@if(isset($website)){{ $website->da_score }}@endif">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="publishing_time">Publishing Time (Count):</label>
                                    <input type="number" id="publishing_time" name="publishing_time" min="1" required value="@if(isset($website)){{ $website->publishing_time }}@endif">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="example_website_name">Example_Website URL:</label>
                                    <input type="text" id="example_website_name" name="example_website_name" required value="@if(isset($website)){{ $website->example_website_name }}@endif">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Category:</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="normal" name="category[]" value="Normal" @if(isset($website) && str_contains($website->category, 'Normal')) checked @endif>
                                        <label class="form-check-label" for="normal">Normal</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="fc" name="category[]" value="FC" @if(isset($website) && str_contains($website->category, 'FC')) checked @endif>
                                        <label class="form-check-label" for="fc">FC</label>
                                    </div>
                                </td>
                            </tr>
                            @if(isset($website) && str_contains($website->category, 'Normal'))
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        document.getElementById("normal_prices").style.display = "table-row";
                                    });
                                </script>
                            @endif
                            <!-- Normal price fields -->
                            <tr id="normal_prices" style="display:none;">
                                <td>
                                    <label>Normal Prices:</label>
                                    <input type="number" id="normal_guest" name="normal_guest" placeholder="Normal Guest Post Price" min="1" value="@if(isset($website)){{ $website->normal_guest_price }}@endif">
                                    <input type="number" id="normal_link" name="normal_link" placeholder="Normal Link Insert Price" min="1" style="margin-top:10px;" value="@if(isset($website)){{ $website->normal_link_price }}@endif">
                                </td>
                            </tr>

                            @if(isset($website) && str_contains($website->category, 'FC'))
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        document.getElementById("fc_prices").style.display = "table-row";
                                    });
                                </script>
                            @endif

                            <!-- FC price fields -->
                            <tr id="fc_prices" style="display:none;">
                                <td>
                                    <label>FC Prices:</label>
                                    <input type="number" id="fc_guest" name="fc_guest" placeholder="FC Guest Post Price" min="1" value="@if(isset($website)){{ $website->fc_guest_price }}@endif">
                                    <input type="number" id="fc_link" name="fc_link" placeholder="FC Link Insert Price" min="1" style="margin-top:10px;" value="@if(isset($website)){{ $website->fc_link_price }}@endif">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    @if(isset($website))
                                    <input type="hidden" name="bool" value="updated">
                                    <input type="submit" value="Update" class="btn btn-primary">
                                    @else
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#normal').change(function(){
        if($(this).is(':checked')){
            $('#normal_prices').show();
        } else {
            $('#normal_prices').hide();
            $('#normal_guest, #normal_link').val('');
        }
    });

    $('#fc').change(function(){
        if($(this).is(':checked')){
            $('#fc_prices').show();
        } else {
            $('#fc_prices').hide();
            $('#fc_guest, #fc_link').val('');
        }
    });

    $('#website-form').submit(function(e){
        let url = $('#website_name').val();
        let regex = /^(https?:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;

        if(!regex.test(url)){
            e.preventDefault();
            toastr.error("Please enter a valid Website URL starting with http/https");
            return false;
        }


        let mainUrl = $('#website_name').val().trim();
        let exampleUrl = $('#example_website_name').val().trim();

        if(!exampleUrl.startsWith(mainUrl + "/")){
            e.preventDefault();
            toastr.error("Example URL must start with " + mainUrl + "/");
            return false;
        }

        if(exampleUrl === mainUrl || exampleUrl === mainUrl + "/"){
            e.preventDefault();
            toastr.error("Example URL must include a path (e.g. " + mainUrl + "/post)");
            return false;
        }


        if(!$("input[name='category[]']:checked").length){
            e.preventDefault();
            toastr.error("Please select at least one category");
            return false;
        }
        if($('#normal').is(':checked')){
            let ng = $('#normal_guest').val();
            let nl = $('#normal_link').val();
            if(ng === "" && nl === ""){
                e.preventDefault();
                toastr.error("For Normal category, please enter Guest Post or Link Insert Price (at least one).");
                return false;
            }
        }
        if($('#fc').is(':checked')){
            let fg = $('#fc_guest').val();
            let fl = $('#fc_link').val();
            if(fg === "" && fl === ""){
                e.preventDefault();
                toastr.error("For FC category, please enter Guest Post or Link Insert Price (at least one).");
                return false;
            }
        }

        return true;
    });
});
</script>
@endsection
