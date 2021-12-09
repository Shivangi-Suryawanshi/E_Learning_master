<?php


use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\VideoController;
use Illuminate\Contracts\Filesystem\Filesystem;

$this->app->when(PhotoController::class)
    ->needs(Filesystem::class)
    ->give(function () {
        return Storage::disk('local');
    });

$this->app->when([VideoController::class, UploadController::class])
    ->needs(Filesystem::class)
    ->give(function () {
        return Storage::disk('s3');
    });

class LiveStreamController extends Controller
{
    public function on_publish(Request $request) {
        if ($request->name == "mystream") {
            return response('Good', 200)->header('Content-Type', 'text/plain');
        } else {
            return response('No', 400)->header('Content-Type', 'text/plain');
        }
    }
}

