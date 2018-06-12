<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Scripts -->
        <script src="{{ asset('js/jquery-3.3.1.min.js') }}" defer></script>
        <script src="{{ asset('js/anypicker.js') }}"></script>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/anypicker-font.css') }}" />

        <!-- Styles -->
        <link href="{{ asset('css/anypicker.css') }}" rel="stylesheet">
        <link href="{{ asset('css/anypicker-ios.css') }}" rel="stylesheet">

    </head>
    <body>
       <div class="col-md-12">    
         <table class="input-cont">
            <tr>

                <td>Time : (iOS)</td>

            </tr>

            <tr>

                <td>
                    <input type="text" id="ip-ios" readonly>
                </td>
        
            </tr>
        </table>
      </div>
      <script type="text/javascript">
          
                $("#ip-ios").AnyPicker(
                {
                    mode: "datetime",
                
                    dateTimeFormat: "hh:mm aa",

                    theme: "iOS" // "Default", "iOS", "Android", "Windows"
                });
            
      </script>
    </body>
</html>


