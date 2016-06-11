<!DOCTYPE html>
<html>
    <head>
        <title>Norberto Sevilla</title>

        <meta name="viewport" content="initial-scale=1">

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/css/Jcrop.css" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.1.1/normalize.min.css">
        <link href="/css/style.css" rel="stylesheet" type="text/css">
        <link href="/css/responsive.css" rel="stylesheet" type="text/css">

        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/js/Jcrop.js"></script>

    </head>
    <body>

        <div class="container">
          <img src="{{ $PictureForCrop->Url }}" id="target" class='img-responsive' />

          <form action="/crop" method="post" onsubmit="return checkCoords();">
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="hidden" name="Picture" value="{{ $PictureForCropJson }}">
             <input type="hidden" id="x" name="x" value='0' />
             <input type="hidden" id="y" name="y" value='0' />
             <input type="hidden" id="w" name="w" value='100' />
             <input type="hidden" id="h" name="h" value='56.5' />
             <input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
          </form>
          
        </div>
        
        

        <script type="text/javascript">
          $( document ).ready(function() 
          {
          
              $(function() {
                 $('#target').Jcrop({
                       aspectRatio:  16 / 9,
                       onSelect:     updateCoords,
                       minSize:      [ 100 , 56.5 ],
                       setSelect:    [ 0 , 0 , 100 , 56.5 ],
                 });
              });
               
             function updateCoords(c)
             {
                $('#x').val(c.x);
                $('#y').val(c.y);
                $('#w').val(c.w);
                $('#h').val(c.h);
             };

             function checkCoords()
             {
                if (parseInt($('#w').val()))
                   return true;
                alert('Please select a crop region then press submit.');
                return false;
             };
            
          });

        </script>

    </body>
</html>
