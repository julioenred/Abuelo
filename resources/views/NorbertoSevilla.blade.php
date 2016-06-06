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

    <div class="album">
        <div class="album-sheet">
            <div class="album-sheet-title">
                <span>HERVÁS</span><span>·</span><a href="#" title="">Ver Todos</a>
            </div>
            <div class="pictures">
                <li><img src="/img/carousel-1.jpg" alt=""></li>
                <li><img src="/img/carousel-2.jpg" alt=""></li>
                <li><img src="/img/carousel-1.jpg" alt=""></li>
                <li><img src="/img/carousel-2.jpg" alt=""></li>
            </div>
        </div>

        <div class="album-sheet">
            <div class="album-sheet-title">
                <span>HERVÁS</span><span>·</span><a href="#" title="">Ver Todos</a>
            </div>
            <div class="pictures">
                <li><img src="/img/carousel-1.jpg" alt=""></li>
                <li><img src="/img/carousel-2.jpg" alt=""></li>
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
          $('#inside').carousel(
          {
              interval: 3500, 
              pause: "false"
          })
        });


    </script>

@endsection
        

