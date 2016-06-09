@extends('TemplateAdmin')

@section('main')

    <div class="fotos">
        @foreach ($PicturesWithAlbums as $element)
            <li>
              <img src="/img/carousel-1.jpg" alt=""><br>
              <i class="fa fa-folder-open-o" aria-hidden="true"></i> {{ $element->Name }}
              <a class='btn btn-danger' href="#" data-toggle="tooltip" data-placement="top" title="Borrar: no hay marcha atrás"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            </li>
        @endforeach
    </div>

@endsection


{{-- JS --}}

@section('js')
    <script>
      $( document ).ready(function() 
      {
        $(function () 
        {
          $('[data-toggle="tooltip"]').tooltip();
        });
      });

    </script>

@endsection
        

