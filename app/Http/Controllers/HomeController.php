<?php

namespace App\Http\Controllers;
use DB;
use Input;

use App\Albums;
use App\Pictures;


use App\Http\Requests;
use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{
    
    protected $PictureForCrop;
    protected $PictureForCropJson;

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

    public function Test()
    {
        // dd('hola');
        return $this->RenderView('AlbumsAdmin' , null , $Url = 'hola');
    }

    public function ViewPicturesAdmin()
    {
        return $this->RenderView( 'PicturesAdmin' );
    }

    public function ViewAlbumsAdmin()
    {
        return $this->RenderView( 'AlbumsAdmin' );
    }

    public function ViewCropPictureByImg( $Url )
    {
        $this->PictureForCrop = DB::table('Pictures')->where('Url' , '=' , $Url)->first();
        //dd($this->PictureForCrop);
        $this->PictureForCropJson = json_encode( $this->PictureForCrop );
        return $this->RenderView('CropPicture');

    }

    public function RenderView( $View )
    {
   
        return view( $View , [
                                'Albums'             => $this->GetAlbums(),
                                'AlbumsWithPictures' => $this->GetAlbumsWithPictures(),
                                'PicturesWithAlbums' => $this->GetPicturesWithAlbums(),
                                'PictureForCrop'     => $this->PictureForCrop,
                                'PictureForCropJson' => $this->PictureForCropJson,
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
                    ->join('Albums', 'Pictures.Id_Album', '=', 'Albums.Id_Album')
                    ->where('Albums.Id_Album' , '=' , $Id )
                    ->get();
        

        if ( empty( $Albums ) ) 
        {
            $Albums = DB::table('Albums')->where('Albums.Id_Album' , '=' , $Id )
                    ->get();

                    //dd($Albums);

            $Albums[0]->Type = 'Album';

        }
        //dd($Albums);

        return $Albums;
    }

    public function GetAlbumsWithPictures()
    {
        $AlbumsWhitPictures = [];
        $Albums = $this->GetAlbums();

        // dd( $Albums );

        foreach ($Albums as $key => $value) 
        {
            $AlbumsWhitPictures[ $key ] = $this->GetAlbumsByIdWithPictures( $Albums[ $key ]->Id_Album );
        }

        //dd( $AlbumsWhitPictures );

        return $AlbumsWhitPictures;
    }

    public function GetPicturesWithAlbums()
    {
        $Pictures = DB::table('Pictures')
                    ->join('Albums', 'Pictures.Id_Album', '=', 'Albums.Id_Album')
                    ->get();

        // dd($Pictures);

        return $Pictures;
    }

    public function CreateAlbum()
    {
        $Name  = ucfirst( strtolower( Request::input( 'Name' ) ) );
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

        
        return redirect( '/albums' );
    }

    public function UploadPicture()
    {
        
        $Title       = Request::input( 'Title' );
        $Description = Request::input( 'Description' );
        $Album       = Request::input( 'Album' );
        $File        = Request::file( 'File' );

        if ( $File == null ) 
        {
            return 'tienes que seleccionar una foto';
        }

        $Directory = 'public/img/' . $Album . '/';
        $Path = base_path( $Directory );
        $File = Request::file( 'File' );
        //dd(getimagesize($File->getPathname()));
        $Mime = $File->getClientOriginalExtension();
        //dd($Mime);

        if ( $Mime != 'jpg' and $Mime != 'JPG' and $Mime != 'jpeg' and $Mime != 'JPEG' and $Mime != 'png' and $Mime != 'PNG' and $Mime != 'gif' and $Mime != 'GIF' ) 
        {
            
            echo 'el archivo debe ser una foto';
        }
        else
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

            //dd($File->getClientOriginalExtension());
            $temporal = 'temporal-' . time() . '-' . $File->getClientOriginalName();
            $temporal = str_replace(" ", "-", $temporal);
            $Size = getimagesize($File->getPathname());

            $Img = time() . '-' . $File->getClientOriginalName();
            $Img = str_replace(" ", "-", $Img);

            $File->move($Path, $temporal);

            

            if ( $this->getPosition( $Size ) === 'horizontal') 
            {
                $Proportion = $this->resizeMaxWidth( $Size , 600 );
            }
            else
            {
                $Proportion = $this->resizeMaxHeight( $Size , 600 );
            }

            $this->resizeImagen( $Size, $Path, $temporal, $Proportion['MaxWidth'], $Proportion['MaxHeight'],  $Img);

            $Url = '/img/' . $Album . '/' . $Img;

            Pictures::create([
                                'Title'       => $Title,
                                'Description' => $Description,
                                'Url'         => $Url,
                                'Mime'        => $Mime,
                                'Id_Album'    => $Album,
                             ]);

            //dd($Url);
            return $this->ViewCropPictureByImg( $Url );
        }
  
    }

    public function getPosition( $Picture )
    {
        $Width  = $Picture[0];
        $Height = $Picture[1];

        if ( $Width > $Height or $Width === $Height ) 
        {
            return 'horizontal';
        }
        else
        {
            return 'vertical';
        }
    }

    public function resizeMaxWidth( $Picture , $MaxWidth )
    {
        $Width  = $Picture[0];
        $Height = $Picture[1];

        $Prop = $MaxWidth * 100 / $Width;

        $MaxHeight = $Prop / 100 * $Height;

        $Proportion['MaxWidth']  = $MaxWidth;
        $Proportion['MaxHeight'] = $MaxHeight;

        return $Proportion;
    }

    public function resizeMaxHeight( $Picture , $MaxHeight )
    {
        $Width  = $Picture[0];
        $Height = $Picture[1];

        $Prop = $MaxHeight * 100 / $Height;

        $MaxWidth = $Prop / 100 * $Width;

        $Proportion['MaxWidth']  = $MaxWidth;
        $Proportion['MaxHeight'] = $MaxHeight;

        return $Proportion;
    }

    public function resizeImagen( $Picture, $ruta, $nombre, $ancho, $alto, $nombreN )
    {

        # $Picture: dimensiones originales de la foto
        # $ruta: Ruta de la imagen (Ej: vergfer\ferfe\fwef\)
        # $nombre: Nombre original de la imagen
        # $alto: Alto deseado
        # $alto: Ancho deseado
        # $nombreN: Nombre de la nueva imagen reducida
        # $extension: Extension de la imagen

        $WidthOriginal  = $Picture[0];
        $HeightOriginal = $Picture[1];

        $rutaImagenOriginal = $ruta . $nombre;
        $extension = explode('/' , mime_content_type( $rutaImagenOriginal ) );

        //dd($extension[1]);

        if( $extension[1] == 'GIF' || $extension[1] == 'gif' )
        {
            $img_original = imagecreatefromgif( $rutaImagenOriginal );
        }

        if($extension[1] == 'jpg' || $extension[1] == 'JPG' || $extension[1] == 'jpeg' || $extension[1] == 'JPEG')
        {
            $img_original = imagecreatefromjpeg( $rutaImagenOriginal );
        }

        if($extension[1] == 'png' || $extension[1] == 'PNG')
        {
            $img_original = imagecreatefrompng( $rutaImagenOriginal );
        }

        $tmp = imagecreatetruecolor( $ancho, $alto );
        imagecopyresampled( $tmp, $img_original, 0, 0, 0, 0, $ancho, $alto, $WidthOriginal, $HeightOriginal );
        imagedestroy( $img_original );
        $calidad = 100;

       
        imagejpeg( $tmp, $ruta . $nombreN, $calidad ); #Guardar imagen nueva y bajar calidad
        

        
        unlink( $ruta . $nombre ); #Eliminar imagen grande

    }

    

    public function CropPicture()
    {
        
           //dd($_POST);
           $Picture = json_decode( Request::input('Picture') );
           //dd($Picture->Mime);
           $UrlAux = explode('/', trim($Picture->Url) );
           //dd($Picture);
           $targ_w = 150;
           $targ_h = 84.75; 
           $jpeg_quality = 70;
           $src = public_path( substr( $Picture->Url , 1 ) );
           $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
           //dd($src);

           
            $img_r = imagecreatefromjpeg( $src );
            

           imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
           //header('Content-type: image/jpeg');
           $Url_Local_Croped = public_path( 'img/' . $Picture->Id_Album . '/croped-' . $UrlAux[3] );
           $Url_Http_Croped  = '/img/' . $Picture->Id_Album . '/croped-' . $UrlAux[3];
           //dd($Url_Croped);
           

           imagejpeg($dst_r,  $Url_Local_Croped , $jpeg_quality);

           Pictures::where('Id_Picture', $Picture->Id_Picture )->update( [ 'Url_Croped' => $Url_Http_Croped ] );

           return $this->ViewAlbumsAdmin();
           
        
    }

   
}
