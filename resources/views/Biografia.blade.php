@extends('Template')

@section('inside')

    <div class="inside">
        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
    

@endsection

@section('sidebar')


@endsection

{{-- JS --}}

@section('js')
    @parent
    <script type="text/javascript">
        $( document ).ready(function() 
        {
          $('#inside').carousel(
          {
              interval: 3500, 
              pause: "false"
          })
        });


    </script>

@endsection
        

