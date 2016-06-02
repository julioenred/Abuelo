@extends('Template')

@section('main')

    

@endsection

@section('sidebar')

    <div class="album">
        <div class="album-sheet">
            <div class="album-sheet-title">
                <span>HERVÁS</span><span>·</span><a href="#" title="">Ver Todos</a>
            </div>
            <div class="pictures">
                <li><img src="/img/carousel-1.jpg" alt=""></li>
                <li><img src="/img/carousel-2.jpg" alt=""></li>
            </div>
                
            
        </div>
    </div>
@endsection

{{-- JS --}}

@section('js')
    @parent
    <script type="text/javascript">
        $( document ).ready(function() 
        {
          $('#myCarousel').carousel(
          {
              interval: 3500, 
              pause: "false"
          })
        });


    </script>

@endsection
        

