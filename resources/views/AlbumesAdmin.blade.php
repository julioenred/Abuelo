@extends('TemplateAdmin')

@section('main')

    <div class="album-admin">
      <p>Hervás</p>
      <div class="fotos">
          <li>
            <img src="/img/carousel-1.jpg" alt=""><br>
            
            <a class='btn btn-danger' href="#" data-toggle="tooltip" data-placement="top" title="Borrar: no hay marcha atrás"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
          </li>
          <li>
            <img src="/img/carousel-2.jpg" alt=""><br>
            
            <a class='btn btn-danger' href="#" title=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
          </li>
          <li>
            <img src="/img/carousel-1.jpg" alt=""><br>
            
            <a class='btn btn-danger' href="#" title=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
          </li>
          <li>
            <img src="/img/carousel-2.jpg" alt=""><br>
            
            <a class='btn btn-danger' href="#" title=""><i class="fa fa-trash-o" aria-hidden="true"></i></a>
          </li>
      </div>
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
        

