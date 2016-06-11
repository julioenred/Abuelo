@extends('TemplateAdmin')

@section('main')

    @for ($i = 0 ; $i < count( $AlbumsWithPictures ); $i++)
        <div class="album-admin">

            {{-- TITLE ALBUM --}}

            

            @if ( $AlbumsWithPictures[$i][0]->Type === 'Album' )

                <div class="fotos">{{ $AlbumsWithPictures[$i][0]->Name }}</div>

            @else
                <p> {{ $AlbumsWithPictures[$i][0]->Name }} </p>
            
                {{-- PICTURES ALBUM --}}
                <div class="fotos">
                    @for ($j = 0; $j < count( $AlbumsWithPictures[$i] ); $j++)
                        <li>
                            <img src="{{ $AlbumsWithPictures[$i][$j]->Url_Croped }}" alt=""><br>
                            <a class='btn btn-danger' href="#" data-toggle="tooltip" data-placement="top" title="Borrar: no hay marcha atrás"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </li>
                    @endfor
                </div>

            @endif
            

        </div>
    @endfor

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
        

