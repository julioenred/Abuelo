<?php

namespace App\Http\Controllers;
use DB;
use Input;

use App\Albums;


use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function ViewPicturesAdmin()
    {
        return $this->RenderView( 'PicturesAdmin' );
    }

    public function ViewAlbumsAdmin()
    {
        return $this->RenderView( 'AlbumsAdmin' );
    }

    public function RenderView( $View )
    {
        return view( $View , [
                                'Albums'             => $this->GetAlbums(),
                                'AlbumsWithPictures' => $this->GetAlbumsWithPictures(),
                                'PicturesWithAlbums' => $this->GetPicturesWithAlbums(),
                             ]);
    }

    public function GetAlbums()
    {
        $Albums = DB::table('Albums')->get();

        // dd( $Albums );
        return $Albums;
    }

    public function GetAlbumsByIdWithPictures( $Id )
    {
        $Albums = DB::table('Pictures')
                    ->join('Albums', 'Pictures.Id_Album', '=', 'Albums.id')
                    ->where('Albums.id' , '=' , $Id )
                    ->get();

        // dd($Albums);

        return $Albums;
    }

    public function GetAlbumsWithPictures()
    {
        $AlbumsWhitPictures = [];
        $Albums = $this->GetAlbums();

        // dd( $Albums );

        foreach ($Albums as $key => $value) 
        {
            $AlbumsWhitPictures[ $key ] = $this->GetAlbumsByIdWithPictures( $Albums[ $key ]->id );
        }

        //dd( $AlbumsWhitPictures );

        return $AlbumsWhitPictures;
    }

    public function GetPicturesWithAlbums()
    {
        $Pictures = DB::table('Pictures')
                    ->join('Albums', 'Pictures.Id_Album', '=', 'Albums.id')
                    ->get();

        // dd($Pictures);

        return $Pictures;
    }

    public function CreateAlbum( Request $Request )
    {
        $Name  = ucfirst( strtolower( $Request->input( 'Name' ) ) );
        $Exist = DB::table( 'Albums' )->select( 'Name' )->where( 'Name' , '=' , $Name )->first();

        // dd( $Name );

        if ( empty( $Exist ) ) 
        {
            if ( $Name != '' and $Name != ' ' ) 
            {
                Albums::create([
                                  'Name' => $Name
                               ]);
            }
        }

        
        return redirect( '/albumes' );
    }

    public function resizeImagen($ruta, $nombre, $alto, $ancho, $nombreN, $extension)
    {

        # $ruta: Ruta de la imagen (Ej: vergfer\ferfe\fwef\)
        # $nombre: Nombre original de la imagen
        # $alto: Alto deseado
        # $alto: Ancho deseado
        # $nombreN: Nombre de la nueva imagen reducida
        # $extension: Extension de la imagen

        $rutaImagenOriginal = $ruta . $nombre;

        $datosexif = exif_read_data ($rutaImagenOriginal); //Obtencion de datos EXIF

        if( $extension == 'GIF' || $extension == 'gif' )
        {
            $img_original = imagecreatefromgif( $rutaImagenOriginal );
        }

        if($extension == 'jpg' || $extension == 'JPG' || $extension == 'jpeg' || $extension == 'JPEG')
        {
            $img_original = imagecreatefromjpeg( $rutaImagenOriginal );
        }

        if($extension == 'png' || $extension == 'PNG')
        {
            $img_original = imagecreatefrompng( $rutaImagenOriginal );
        }

        $max_ancho = $ancho;
        $max_alto = $alto;
        list( $ancho, $alto ) = getimagesize( $rutaImagenOriginal );
        $x_ratio = $max_ancho / $ancho;
        $y_ratio = $max_alto / $alto;

        if( ( $ancho <= $max_ancho ) && ( $alto <= $max_alto ) )
        {//Si ancho 
            $ancho_final = $ancho;
            $alto_final = $alto;
        } 
        elseif ( ( $x_ratio * $alto ) < $max_alto )
        {
            $alto_final = ceil( $x_ratio * $alto );
            $ancho_final = $max_ancho;
        } 
        else
        {
            $ancho_final = ceil( $y_ratio * $ancho );
            $alto_final = $max_alto;
        }

        $tmp = imagecreatetruecolor( $ancho_final, $alto_final );
        imagecopyresampled( $tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto );
        imagedestroy( $img_original );
        $calidad = 70;

        if( ! empty( $datosexif['Orientation'] ) ) 
        { 
            switch( $datosexif['Orientation'] ) 
            {
                case 8:
                    $tmp = imagerotate($tmp,90,0);
                    break;
                case 3:
                    $tmp = imagerotate($tmp,180,0);
                    break;
                case 6:
                    $tmp = imagerotate($tmp,-90,0);
                    break;
            }
        } // Analizamos la orientacion vieja y giramos la imagen nueva

        imagejpeg( $tmp, $ruta . $nombreN, $calidad ); #Guardar imagen nueva y bajar calidad
        unlink( $ruta . $nombre ); #Eliminar imagen grande

    }

    public function subirFoto()
    {
          $directory = 'public/img/' . Auth::user()->id . '-' . Auth::user()->Usuario.'/';
          $path = base_path( $directory );

          // $this->pintar($path);

          if ( ! file_exists ( $path ) ) 
          {
               
                mkdir( $path );
                
          }
          else
          {
                if ( ! is_dir( $path ) ) 
                {
                      mkdir( $path );
                }
          }

          $file = Input::file('file');
          $mime = explode("/", $file->getMimeType() );
          //var_dump($file);

          if ( $mime[1] != 'jpg' and $mime[1] != 'JPG' and $mime[1] != 'jpeg' and $mime[1] != 'JPEG' and $mime[1] != 'png' and $mime[1] != 'PNG' and $mime[1] != 'gif' and $mime[1] != 'GIF' ) 
          {
            return View::make('errorMsg', array(

                        'Idioma'            => $this->getLanguage(),
                        'User'              => $this->verUsuario( Auth::user()->id),
                        'display'           => ['breaks' => 'active', 'contactos' => '', 'fotos' => ''],  
                        'Usuario'           => Auth::user()->Usuario,
                        'Foto_Perfil'       => Auth::user()->Url_Foto_Perfil,
                        'SobreTi'           => Auth::user()->Sobre_Ti,
                        'Grupos'            => $this->grupos(),
                        'Comentarios'       => $this->verComentariosMuro(),
                        'Consejos'          => $this->verConsejosSeguidores(),
                        'BREAKS'            => 'BREAKS',
                        'linkBreaks'        => '/inicio',  
                        'nConsejos'         => $this->nMisConsejos(),
                        'nContactos'        => $this->nContactos(),
                        'nFotos'            => $this->nFotos( Auth::user()->id ),
                        'IDF'               => $this->IDF( Auth::user()->id ),
                        'Usuarios'          => $this->getSuggestedUsersFor( Auth::user()->id ),
                        'TopSAS'            => $this->getTopSASUsers(),
                        'nNotificacionesNL' => $this->nNotificacionesNL(),
                        'nMensajesNL'       => $this->nMensajesNL(),
                        'grafico'           => $this->grafico( Auth::user()->id ),
                        'seUnioHace'        => $this->seUnioHace( Auth::user()->id ),
                        'Actividades'       => $this->getActividadesRecientes(),
                        'Vista'             => 'success',
                        'Mensaje'           => 'El archivo que quieres adjuntar no está permitido. Debe ser un archivo del siguiente tipo: jpg, jpeg, png o gif. Puedes volver a intentarlo ;)',  
                    
                                       
                                       )
                       );
          }
          else
          {

                $nFotos = DB::table('Fotos')->first();
                $aux = $nFotos->Numero_Fotos;
                $aux++;
                // $this->pintar( $aux );
                DB::table('Fotos')->where('id', $nFotos->id)->update( ['Numero_Fotos' => $aux] ); 

                // $this->pintar($filename);
                $temporal = 'temporal-album-' . Auth::user()->id . '-' . $file->getClientOriginalName();
                $temporal = str_replace(" ", "-", $temporal);

                $file->move($path, $temporal);

                $fotoAlbum = $aux . '.' . $mime[1];
                $fotoAlbum = str_replace(" ", "-", $fotoAlbum);

                $this->resizeImagen( $path, $temporal, 425, 425,  $fotoAlbum, $mime[1]);

                $url = '/fotos/' . Auth::user()->id;

                return Redirect::to( $url );
          }
    }

    public function uploadImage()
    {
        
        $Album = Input::get('Album');
        $Directory = 'public/img/' . $Album . '/';
        $Path = base_path( $Directory );
        $File = Input::file('File');
        $Mime = explode("/", $File->getMimeType() );

        if ( $Mime[1] != 'jpg' and $Mime[1] != 'JPG' and $Mime[1] != 'jpeg' and $Mime[1] != 'JPEG' and $Mime[1] != 'png' and $Mime[1] != 'PNG' and $Mime[1] != 'gif' and $Mime[1] != 'GIF' ) 
        {
            if ( ! file_exists ( $Path ) ) 
            {
                 
                  mkdir( $Path );
                  
            }
            else
            {
                  if ( ! is_dir( $Path ) ) 
                  {
                        mkdir( $Path );
                  }
            }

            $Img = time() . '-' . $File->getClientOriginalName();
            $File->move($Path, $Img);

            Pictures::create([
                                'Title'       => nput::get('Title'),
                                'Description' => $nput::get('Description'),
                                'Url'         => '/img/' . $Album . $Img,
                            ]);

        }
        else
        {
            echo 'el archivo debe ser una foto';
        }
        
    }

    public function cropImagen()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
           // dd($_POST);
           $targ_w = 150;
           $targ_h = 84.75; 
           $jpeg_quality = 90;
           $src = 'img/carousel-1.jpg';
           $img_r = imagecreatefromjpeg($src);
           $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
           imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
           header('Content-type: image/jpeg');
           imagejpeg($dst_r, null, $jpeg_quality);
           exit;
        }
    }
}
