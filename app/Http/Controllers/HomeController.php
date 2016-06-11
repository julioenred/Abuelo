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
                    ->join('Albums', 'Pictures.Id_Album', '=', 'Albums.id')
                    ->where('Albums.id' , '=' , $Id )
                    ->get();
        

        if ( empty( $Albums ) ) 
        {
            $Albums = DB::table('Albums')->where('Albums.id' , '=' , $Id )
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
        //dd($File->getClientOriginalExtension());
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

            $Img = time() . '-' . $File->getClientOriginalName();
            $File->move($Path, $Img);
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

    public function CropPicture()
    {
        
           //dd($_POST);
           $Picture = json_decode( Request::input('Picture') );
           //dd($Picture->Mime);
           $UrlAux = explode('/', trim($Picture->Url) );
           //dd($UrlAux);
           $targ_w = 150;
           $targ_h = 84.75; 
           $jpeg_quality = 70;
           $src = public_path( $Picture->Url );
           $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
           //dd($this->UploadPictureExt);

           if( $Picture->Mime == 'GIF' || $Picture->Mime == 'gif' )
            {
                $img_r = imagecreatefromgif( $src );
            }

            if($Picture->Mime == 'jpg' || $Picture->Mime == 'JPG' || $Picture->Mime == 'jpeg' || $Picture->Mime == 'JPEG')
            {
                $img_r = imagecreatefromjpeg( $src );
            }

            if($Picture->Mime == 'png' || $Picture->Mime == 'PNG')
            {
                $img_r = imagecreatefrompng( $src );
            }

           imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
           //header('Content-type: image/jpeg');
           $Url_Local_Croped = public_path( 'img/' . $Picture->Id_Album . '/croped-' . $UrlAux[3] );
           $Url_Http_Croped  = '/img/' . $Picture->Id_Album . '/croped-' . $UrlAux[3];
           //dd($Url_Croped);
           

           imagejpeg($dst_r,  $Url_Local_Croped , $jpeg_quality);

           Pictures::where('id', $Picture->id )->update( [ 'Url_Croped' => $Url_Http_Croped ] );

           return $this->ViewAlbumsAdmin();
           
        
    }

   
}
