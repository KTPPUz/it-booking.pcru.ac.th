<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class ImageController extends Controller
{
    public function showImage()
    {
        $path = public_path('img/pcru.png');

        if (!file_exists($path)) {
            abort(404, 'Image not found');
        }

        return Response::file($path);
    }
}