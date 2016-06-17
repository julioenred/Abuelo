<?php

namespace App\Http\Controllers;
use DB;
use Input;

use App\Albums;
use App\Pictures;


use App\Http\Requests;
use Illuminate\Support\Facades\Request;

class PublicController extends Controller
{
    
    
    public function ViewIndex()
    {
        return $this->RenderView( 'Index' );
    }

    public function ViewNorbertoSevilla()
    {
        return $this->RenderView( 'NorbertoSevilla' );
    }

    public function ViewBiografia()
    {
        return $this->RenderView( 'Biografia' );
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


    

    

   
}
