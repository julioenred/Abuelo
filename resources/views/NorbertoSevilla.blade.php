@extends('Template')

@section('inside')

    <div class="inside">
        <header id="inside" class="carousel slide">
              <!-- Wrapper for Slides -->
              <div class="carousel-inner">
                  <div class="item active">
                      <!-- Set the first background image using inline CSS below. -->
                      <div class="fill bg1"></div>
                      <div class="carousel-caption">
                          
                      </div>
                  </div>
                  <div class="item">
                      <!-- Set the second background image using inline CSS below. -->
                      <div class="fill bg2"></div>
                      <div class="carousel-caption">
                          
                      </div>
                  </div>
                  <div class="item">
                      <!-- Set the third background image using inline CSS below. -->
                      <div class="fill bg3"></div>
                      <div class="carousel-caption">
                          
                      </div>
                  </div>
                  <div class="item">
                      <!-- Set the third background image using inline CSS below. -->
                      <div class="fill bg4"></div>
                      <div class="carousel-caption">
                          
                      </div>
                  </div>
                  <div class="item">
                      <!-- Set the third background image using inline CSS below. -->
                      <div class="fill bg5"></div>
                      <div class="carousel-caption">
                          
                      </div>
                  </div>
                  <div class="item">
                      <!-- Set the third background image using inline CSS below. -->
                      <div class="fill bg6"></div>
                      <div class="carousel-caption">
                          
                      </div>
                  </div>
                  <div class="item">
                      <!-- Set the third background image using inline CSS below. -->
                      <div class="fill bg7"></div>
                      <div class="carousel-caption">
                          
                      </div>
                  </div>
                  <div class="item">
                      <!-- Set the third background image using inline CSS below. -->
                      <div class="fill bg8"></div>
                      <div class="carousel-caption">
                          
                      </div>
                  </div>
                  <div class="item">
                      <!-- Set the third background image using inline CSS below. -->
                      <div class="fill bg9"></div>
                      <div class="carousel-caption">
                          
                      </div>
                  </div>
                  <div class="item">
                      <!-- Set the third background image using inline CSS below. -->
                      <div class="fill bg10"></div>
                      <div class="carousel-caption">
                          
                      </div>
                  </div>
              </div>
        </header>
    </div>
    

@endsection

@section('sidebar')
  @for ($i = 0 ; $i < count( $AlbumsWithPictures ); $i++)
    <div class="album">

      @if ( $AlbumsWithPictures[$i][0]->Type !== 'Album' )

        <div class="album-sheet">
            <div class="album-sheet-title">
                <span>{{ $AlbumsWithPictures[$i][0]->Name }}</span><span>·</span><a href="#" title="">Ver Todos</a>
            </div>
            <div class="pictures">
              <?php 
                if ( count( $AlbumsWithPictures[$i] ) > 4 ) 
                {
                  $Count = 4;
                }
                else
                {
                  $Count = count( $AlbumsWithPictures[$i] );
                }
              ?>
              @for ($j = 0; $j < $Count ; $j++)
                <li><img src="{{ $AlbumsWithPictures[$i][$j]->Url_Croped }}" alt="" data-toggle="modal" data-target="#modal-{{ $AlbumsWithPictures[$i][$j]->Id_Picture }}"></li>

                <!-- Large modal -->

                <div id='modal-{{ $AlbumsWithPictures[$i][$j]->Id_Picture }}' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                      <div class="modal-img">
                        <img class='img-responsive' src="{{ $AlbumsWithPictures[$i][$j]->Url }}" alt="">
                      </div>
                      
                      <div class="modal-text">
                          <div class="modal-title">
                            {{ $AlbumsWithPictures[$i][$j]->Title }}
                          </div>
                          <div class="modal-description">
                            {{ $AlbumsWithPictures[$i][$j]->Description }}
                          </div>
                      </div>
                      
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
                
              @endfor
            </div>
        </div>
      @endif
    </div>
    @endfor

     
@endsection

@section('modals')
  <!-- Large modal -->

  <div id='modal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-img">
          <img class='img-responsive' src="/img/carousel-2.jpg" alt="">
        </div>
        
        <div class="modal-text">
            <div class="modal-title">
              TITULO
            </div>
            <div class="modal-description">
              Unas lineas para describir el cuadro
            </div>
        </div>
        
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
@stop

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
        

