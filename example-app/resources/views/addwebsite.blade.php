@extends('layouts.myapp')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
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
    .error{
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }

</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if(isset($website))
                    <div class="card-header">{{ __('Edit Website Details') }}</div>
                @else
                    <div class="card-header">{{ __('Add Website Details') }}</div>
                @endif
                <div class="card-body" style="font-size: large; text-align: center; color:white;background-color: #4a90e2;">
                    {{ __('<==~~Website Form~~==>') }}
                </div>

                <div class="card-footer">
                    <form action="/save-website" method="post" id="website-form">
                        @csrf
                        <input type="hidden" name="id" value="@if(isset($website)){{ $website->id }}@endif">
                        <table>
                            <tr>
                                <td>
                                    <label for="website_name">Website URL:</label>
                                    <input type="text" id="website_name" name="website_name" value="@if(isset($website)){{ $website->website_name }}@endif"  @if(isset($website))readonly @endif>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="da_score">DA Score (1–100):</label>
                                    <input type="text" id="da_score" name="da_score" value="@if(isset($website)){{ $website->da_score }}@endif">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="publishing_time">Publishing Time (Count):</label>
                                    <input type="text" id="publishing_time" name="publishing_time" min="1" value="@if(isset($website)){{ $website->publishing_time }}@endif">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="example_website_name">Example_Website URL:</label>
                                    <input type="text" id="example_website_name" name="example_website_name"  value="@if(isset($website)){{ $website->example_website_name }}@endif">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label id="category_label">Category:</label>
                                        <div class="form-check">
                                            <label class="form-check-label" for="normal">Normal</label>
                                            <input type="checkbox" class="form-check-input" id="normal" name="category[]" value="Normal" @if(isset($website) && str_contains($website->category, 'Normal')) checked @endif>
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
                            <tr id="normal_prices" @if(isset($website) && str_contains($website->category, 'Normal')) style="display:table-row;" @else style="display:none;" @endif>
                                <td>
                                    <label id="normal_prices_label">Normal Prices:</label>
                                    <input type="text" id="normal_guest" name="normal_guest" placeholder="Normal Guest Post Price" min="1" value="@if(isset($website)){{ $website->normal_guest_price }}@endif">
                                    <input type="text" id="normal_link" name="normal_link" placeholder="Normal Link Insert Price" min="1" style="margin-top:10px;" value="@if(isset($website)){{ $website->normal_link_price }}@endif">
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
                            <tr id="fc_prices" @if(isset($website) && str_contains($website->category, 'FC')) style="display:table-row;" @else style="display:none;" @endif >
                                <td>
                                    <label id="fc_prices_label">FC Prices:</label>
                                    <input type="text" id="fc_guest" name="fc_guest" placeholder="FC Guest Post Price" min="1" value="@if(isset($website)){{ $website->fc_guest_price }}@endif">
                                    <input type="text" id="fc_link" name="fc_link" placeholder="FC Link Insert Price" min="1" style="margin-top:10px;" value="@if(isset($website)){{ $website->fc_link_price }}@endif">
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
    if(!$('#normal').is(':checked')){
        $('#normal_guest').val('');
        $('#normal_link').val('');
    }
    if(!$('#fc').is(':checked')){
        $('#fc_guest').val('');
        $('#fc_link').val('');
    }

    $('#normal').change(function(){
        if($(this).is(':checked')){
            $('#normal_prices').show();
        } else {
            $('#normal_prices').hide();
            // $('#normal_guest, #normal_link').val('');
        }
    });    

    $('#fc').change(function(){
        if($(this).is(':checked')){
            $('#fc_prices').show();
        } else {
            $('#fc_prices').hide();
            // $('#fc_guest, #fc_link').val('');
        }
    });

    //add method to handle the condition of catogory checkboxs & its price fields
    $.validator.addMethod("categoryPriceCheck", function(value, element) {
        if ($('#normal').is(':checked')) {
            return $('#normal_guest').val() !== '' || $('#normal_link').val() !== '';
        }
        if ($('#fc').is(':checked')) {
            return $('#fc_guest').val() !== '' || $('#fc_link').val() !== '';
        }
        return true; // If no category is checked, pass validation (handled by required rule)
    }, "Please fill at least one price field for the selected category.");

    $.validator.addMethod("url", function(value, element) {
        return this.optional(element) || /^(https?:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
    }, "Please enter a valid URL (starting with http/https)");

    $.validator.addMethod("example_url", function(value, element) {
        let mainUrl = $('#website_name').val().trim();
        if(value === mainUrl || value === mainUrl + "/"){
            return false; // Example URL must include a path
        }
        let path = value.substring(mainUrl.length);
        return this.optional(element) || /^\/[a-zA-Z0-9][\S]*$/.test(path);
    }, "Example URL must start with the main URL and include a path (e.g. /post)");



    $("#website-form").validate({
        rules: {
            website_name: {
                required: true,
                url: true
            },
            da_score: {
                required: true,
                number: true,
                min: 1,
                max: 100
            },
            publishing_time: {
                required: true,
                number: true,
                min: 1
            },
            example_website_name: {
                required: true,
                example_url: true,
            },
            'category[]': {
                required: true,
            },
            normal_guest: {
                categoryPriceCheck: true,
                number: true,
                min: 1
            },
            normal_link: {
                categoryPriceCheck: true,
                number: true,
                min: 1
            },
            fc_guest: {
                categoryPriceCheck: true,
                number: true,
                min: 1
            },
            fc_link: {
                categoryPriceCheck: true,
                number: true,
                min: 1
            }
        },
        messages: {
            website_name: {
                required: "Please enter the Website URL",
                url: "Please enter a valid URL (starting with http/https)"
            },
            da_score: {
                required: "Please enter the DA Score",
                number: "DA Score must be a number",
                min: "DA Score must be at least 1",
                max: "DA Score must be at most 100"
            },
            publishing_time: {
                required: "Please enter the Publishing Time",
                number: "Publishing Time must be a number",
                min: "Publishing Time must be at least 1"
            },
            example_website_name: {
                required: "Please enter the Example Website URL",
                url: "Please enter a valid URL (starting with http/https)"
            },
            'category[]': {
                required: "Please select at least one category"
            },
            normal_guest: {
                number: "Normal Guest Post Price must be a number",
                min: "Normal Guest Post Price must be at least 1"
            },
            normal_link: {
                number: "Normal Link Insert Price must be a number",
                min: "Normal Link Insert Price must be at least 1"
            },
            fc_guest: {
                number: "FC Guest Post Price must be a number",
                min: "FC Guest Post Price must be at least 1"
            },
            fc_link: {
                
                number: "FC Link Insert Price must be a number",
                min: "FC Link Insert Price must be at least 1"
            }
        },
        errorElement: "span",
        errorClass: "error",
        errorPlacement: function(error, element) {
            if(element.attr("name") == "category[]") {
                error.insertAfter("#category_label");
            } else if(element.attr("name") == "normal_guest" || element.attr("name") == "normal_link") {
                error.insertAfter("#normal_prices_label");
            } else if(element.attr("name") == "fc_guest" || element.attr("name") == "fc_link") {
                error.insertAfter("#fc_prices_label");
            } else {
                error.insertAfter(element);
            }
        }
    });


    // $('#website_name').blur(function(){
    //     $('.error').remove();
        
    //     let url = $(this).val();
    //     let regex = /^(https?:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;

    //     if(!regex.test(url)){
    //         $(this).after('<div class="error">Please enter a valid Website URL starting with http/https</div>');
    //     }
    // });

    // $('#da_score, #publishing_time').blur(function(){
    //     $('.error').remove();
        
    //     let val = $(this).val();
    //     let id = $(this).attr('id');

    //     if(id === 'da_score'){
    //         if(isNaN(val) || val < 1 || val > 100){
    //             $(this).after('<div class="error">DA Score must be a number between 1 and 100</div>');
    //         }
    //     } else if(id === 'publishing_time'){
    //         if(isNaN(val) || val < 1){
    //             $(this).after('<div class="error">Publishing Time must be a positive number</div>');
    //         }
    //     }
    // });

    // $('#example_website_name').blur(function(){
    //     $('.error').remove();
        
    //     let mainUrl = $('#website_name').val().trim();
    //     let exampleUrl = $(this).val().trim();

    //     if(!exampleUrl.startsWith(mainUrl + "/")){
    //         $(this).after('<div class="error">Example URL must start with main url:' + mainUrl + '/</div>');
    //         return;
    //     }

    //     if(exampleUrl === mainUrl || exampleUrl === mainUrl + "/"){
    //         $(this).after('<div class="error">Example URL must include a path (e.g. ' + mainUrl + '/post)</div>');
    //         return;
    //     }
    //     //check if example url conatains main url +'/ and some charter from 0-9 or a-z or A-Z only and after that any special charcter is allowed
    //     let path = exampleUrl.substring(mainUrl.length);
    //     let pathRegex = /^\/[a-zA-Z0-9][\S]*$/;
    //     if(!pathRegex.test(path)){
    //         $(this).after('<div class="error">Example URL path must start with a letter or number after / and can include any special character.</div>');
    //         return;
    //     }
    // });

    // $('#normal').change(function(){
    //     if($(this).is(':checked')){
    //         $('#normal_prices').show();
    //     } else {
    //         $('#normal_prices').hide();
    //         // $('#normal_guest, #normal_link').val('');
    //     }
    // });

    // $('#fc').change(function(){
    //     if($(this).is(':checked')){
    //         $('#fc_prices').show();
    //     } else {
    //         $('#fc_prices').hide();
    //         // $('#fc_guest, #fc_link').val('');
    //     }
    // });

    // $('#website-form').submit(function(e){
    //     let url = $('#website_name').val();
    //     let regex = /^(https?:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;

    //     if(!regex.test(url)){
    //         e.preventDefault();
    //         $('.error').remove();
    //         $('#website_name').after('<div class="error">Please enter a valid Website URL starting with http/https</div>');
    //         $('#website_name').focus();
    //         toastr.error("Please enter a valid Website URL starting with http/https");
    //         return false;
    //     }


    //     let mainUrl = $('#website_name').val().trim();
    //     let exampleUrl = $('#example_website_name').val().trim();

    //     if(!exampleUrl.startsWith(mainUrl + "/")){
    //         e.preventDefault();
    //         toastr.error("Example URL must start with main url: " + mainUrl + "/");
    //         return false;
    //     }

    //     if(exampleUrl === mainUrl || exampleUrl === mainUrl + "/"){
    //         e.preventDefault();
    //         toastr.error("Example URL must include a path (e.g. " + mainUrl + "/post)");
    //         return false;
    //     }

    //     if($('#da_score').val() < 1 || $('#da_score').val() > 100 || isNaN($('#da_score').val())){
    //         $('.error').remove();
    //         $('#da_score').after('<div class="error">DA Score must be a number between 1 and 100</div>');
    //         e.preventDefault();            
    //         toastr.error("DA Score must be a number between 1 and 100");
    //         return false;
    //     }
    //     if($('#publishing_time').val() < 1 || isNaN($('#publishing_time').val())){
    //         $('.error').remove();
    //         $('#publishing_time').after('<div class="error">Publishing Time must be a positive number</div>');
    //         e.preventDefault();            
    //         toastr.error("Publishing Time must be a positive number");
    //         return false;
    //     }

    //     if(!$("input[name='category[]']:checked").length){
    //         $('.error').remove();
    //         $('#category_label').after('<div class="error">Please select at least one category</div>');
    //         e.preventDefault();
    //         toastr.error("Please select at least one category");
    //         return false;
    //     }
        
    //     if($('#normal').is(':checked')){
    //         let ng = $('#normal_guest').val();
    //         let nl = $('#normal_link').val();
    //         if(ng === "" && nl === ""){
    //             $('.error').remove();
    //             $('#normal_prices_label').after('<div class="error">Please enter Guest Post Price or Link Insert Price</div>');
    //             e.preventDefault();
    //             toastr.error("For Normal category, please enter Guest Post or Link Insert Price (at least one).");
    //             return false;
    //         }
    //     }
    //     if($('#fc').is(':checked')){
    //         let fg = $('#fc_guest').val();
    //         let fl = $('#fc_link').val();
    //         if(fg === "" && fl === ""){
    //             $('.error').remove();
    //             $('#fc_prices_label').after('<div class="error">Please enter Guest Post Price or Link Insert Price</div>');
    //             e.preventDefault();
    //             toastr.error("For FC category, please enter Guest Post or Link Insert Price (at least one).");
    //             return false;
    //         }
    //     }
    // if(!$('#normal').is(':checked')){
            $('#normal_guest').val('');
            $('#normal_link').val('');
    // }
    // if(!$('#fc').is(':checked')){
    //         $('#fc_guest').val('');
    //         $('#fc_link').val('');
    // }
    //     return true;
});
</script>
@endsection
