<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WIMS</title>
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{ asset('styles/app.css') }}">

    <style>
        .whole, .frac {
            font-size: 12px;
        }
        .frac {
            display: inline-block;
            position: relative;
            vertical-align: middle;
            letter-spacing: 0.001em;
            text-align: center;
        }
        .frac > span {
            display: block;
            padding: 0 0.1em;
        }
        /*.numerator {
            padding: 0;
            margin: 0;
            background-color: red;
        }*/
        .frac span.bottom {
            border-top: thin solid black;
            padding: 0;
        }
        .frac span.symbol {
            display: none;
        } 
    </style>

</head>
<body class="hold-transition sidebar-mini " style="background:#F0F0F2" >

    <div id="loading-container" class="loading-container d-none">
        <div class="loading">
            <i class="fas fa-fw fa-spinner fa-pulse fa-4x"></i>
            <div class="text-center mt-2">Loading</div>
        </div>
    </div>

    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="{{ asset('assets/defaults/logo.png') }}" alt="Logo" height="60" width="60">
    </div>
    <div class="wrapper">


        <x-toast :type="session('flash')"></x-toast>

        @include('panel._includes.navbar')
        @include('panel._includes.sidebar')

        <div class="content-wrapper" style="background:#EDEDF0">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"></h1>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Starter Page</li>
                            </ol>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

        </div>



        <aside class="control-sidebar control-sidebar-dark">

            <div class="p-3">
                <a href="{{ route('logout') }}">Logout</a>
            </div>

        </aside>

        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline">
                v0.1
            </div>

            <strong>Copyright &copy; {{ date('Y') }} <a href="https://wasisoft.com">WasiSoft Technology</a>.</strong> All rights reserved.
        </footer>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css"/>
 
   <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>

    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="{{asset('js/payment.js')}}"></script>
    <script src="{{asset('js/account.js')}}"></script>
    <script src="{{asset('js/addexpense.js')}}"></script>
    @if(session()->has('flash'))
    <script>

        
{{--        Toast.fire({
            icon: 'warning',
            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        }) --}}


            $('.toast').toast('show');


        
    </script> 
    @endif

    @section('script')

    <script>

        $('#bari_category_id').change(function(){
           $.ajax({
                url: baseURL + `categories/${ $(this).val() }/sub-categories/product`,
            })
            .done(function(res) {
               
                $('#form_feild').empty();
                $('#form_feild').append(`

                   <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="">
                          Product Name <span class="text-danger">*</span>
                        </label>
                     <x-forms.input name="bri_product_name"></x-forms.input>
                    </div>
                   </div>

                   <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="">
                          Product Size <span class="text-danger">*</span>
                        </label>
                     <x-forms.input name="size"></x-forms.input>
                    </div>
                   </div>

                   <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="">
                          Per Product Rate/Price  <span class="text-danger">*</span>
                        </label>
                     <x-forms.input name="rate"></x-forms.input>
                    </div>
                   </div>
                   <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="">
                           Product Image  <span class="text-danger">*</span>
                        </label>
                     <input type="file" class="form-control" name="image" />
                    </div>
                   </div>

                    `);
                $.each(res.categories, function(index, val) {
                   
                    
                var string = 
                    `
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="">
                                    Total ${val.sub_category_name} <span class="text-danger">*</span>
                                </label>
                                <x-forms.input name="bri_quentity[]" ></x-forms.input>
                                 <input type="hidden" name="sub_category_id[]" value="${val.id}">
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="">
                                     ${val.sub_category_name} Sizes<span class="text-danger">*</span>
                                </label>
                                 
                      `;
                     
                     string=string+`
                       <select class="form-control" name="bri_product_id[]" id="sdsd">
                       `;
                        for(var val2 of res.product)
                        {
                          
                         if(val.id===val2.sub_category_id)
                          {

                          
                          string = string + `
                       
                         <option value="${val2.id}">${val2.product_name}</option>   
                              
                                `; 
                            }
                         } 
                  
                     
                       string = string + `
    
                         </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="">
                                     ${val.sub_category_name} <span class="text-danger">*</span>
                                </label>
                                <x-forms.input name="category_name[]"  value="${val.sub_category_name}" readonly></x-forms.input>
                            </div>
                        </div>
                       `;
                      
                     $('#form_feild').append(string);
// dfdf
                
                });

                

            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
                  
         })


        
           
      
     
        var baseURL = "{{ url("") }}" + "/";

        $('form:not(#_ajaxRequest)').submit(function() {
            
            var btn = $('#_btnSave, #_btnUpdate');

            btn.prop('disabled', 'true');
            btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ');

        });

        function confirmDelete() {

            var cf = confirm('Are You Sure?');

            if (cf) {

                return true;

            } else {

                return false;
                
            }
            
        }

        function updateImageSrc(imageSelectInputId, previewImgTagId) {
            
            const [file] = imageSelectInputId.files;

            if (file) {
                previewImgTagId.src = URL.createObjectURL(file);
            }

        }

        $(window).on('unload', function() {
           


        });

    </script>
   

   @show
    
</body>
</html>
