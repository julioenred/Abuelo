<!DOCTYPE html>
<html>
    <head>
        <title>Norberto Sevilla</title>

        <meta name="viewport" content="initial-scale=1">

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.1.1/normalize.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-hQpvDQiCJaD2H465dQfA717v7lu5qHWtDbWNPvaTJ0ID5xnPUlVXnKzq7b8YUkbN" crossorigin="anonymous">
        <link href="/css/style.css" rel="stylesheet" type="text/css">
        <link href="/css/responsive.css" rel="stylesheet" type="text/css">

        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    </head>
    <body>

        <div class="container">
            
            <div class="menu-admin col-xs-2">
                <li class='btn btn-primary'><a href="/pictures" title=""><i class="fa fa-photo" aria-hidden="true"></i> Fotos</a></li>
                <li class='btn btn-primary'><a href="/albums" title=""><i class="fa fa-folder-open-o" aria-hidden="true"></i> Albumes</a></li>
                <li class='btn btn-danger'><i class="fa fa-power-off" aria-hidden="true"></i> Salir</li><br><br>
                <li class='btn btn-success' data-toggle="modal" data-target="#subirfoto"><i class="fa fa-upload" aria-hidden="true"></i> Subir Foto</li>
                <li class='btn btn-success' data-toggle="modal" data-target="#crearalbum"><i class="fa fa-folder" aria-hidden="true"></i> Crear Album</li>
            </div>

            <div class="col-xs-1"></div>
                


            

            {{-- MAIN --}}
            <div class="col-xs-9">
                @section('main')

                    

                @show
            </div>

        </div>

        {{-- MODALS --}}

        @section('modals')

            {{-- MODAL SUBIR FOTO --}}

            <div class="modal fade" id="subirfoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Subir Foto</h4>
                  </div>
                  <div class="modal-body">
                        
                    {{ Form::open(array('url' => '/uploadpicture', 'files' => true)) }} 
                        <h4>Elige un título para la foto (opcional)</h4>
                        <input class='form-control' type="text" name="Title" value="" placeholder="Ej: Fuente chiquita">

                        <h4>Redacta un texto que describa la foto (opcional)</h4>
                        <textarea class='form-control' name="Description"></textarea>

                        <h3>Es posible que quieras añadir la foto a un album. Si no existe el album todavía, créalo antes de subir la foto.</h3>
                        <h4>Elige un album</h4>

                        <select class="form-control" name='Album'>
                            @foreach ($Albums as $element)
                                <option value='{{ $element->id }}'>{{ $element->Name }}</option>
                            @endforeach
                        </select> 

                        <h4 class='mtop20'>Selecciona una imagen</h4>
                        {{ Form::file('File', array("class" => "") )}}
                        <br>

                        <input type="submit" class='btn btn-primary mtop20' value="Subir Foto">
                    {{ Form::close() }}
                  </div>
                  
                </div>
              </div>
            </div>

            {{-- MODAL CREAR ALBUM --}}

            <div class="modal fade" id="crearalbum" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Crear Album</h4>
                  </div>
                  <div class="modal-body">
                        
                    {{ Form::open(array('url' => '/createalbum', 'files' => true)) }} 

                        <h4 class='mtop20'>Nombre del album</h4>
                        <input class='form-control' type="text" name="Name" value="" placeholder="Ej: Hervás">
                        <br>

                        <input type="submit" class='btn btn-primary mtop20' value="Crear Album">
                    {{ Form::close() }}
                  </div>
                  
                </div>
              </div>
            </div>
        @show

        {{-- JS --}}

        @section('js')
           

        @show
        
    </body>
</html>
