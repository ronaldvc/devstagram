<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

require './vendor/autoload.php';
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');

        $nombreImagen = Str::uuid().".". $imagen->extension();

        $manager = new ImageManager(new Driver);
        $imagenServidor = $manager::imagick()->read($imagen);
        $imagenServidor->resize(1000,1000);

        $imagenPath = public_path('uploads'). '/' . $nombreImagen;

        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
