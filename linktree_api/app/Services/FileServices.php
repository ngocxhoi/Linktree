<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

// use Image;

class FileServices
{
  public function updateImage($model, $request)
  {
    $file = $request->file('image');
    $image = (new ImageManager(new Driver))->read($file);
    ;

    if (!empty($model->image)) {
      $currentImage = public_path() . $model->image;

      if (
        file_exists($currentImage)
        && $currentImage != public_path() . '/user-placeholder.png'
        && $currentImage != public_path() . '/link-placeholder.png'
      ) {
        unlink($currentImage);
      }
    }

    $extension = $file->getClientOriginalExtension();

    $image->crop(
      $request->width,
      $request->height,
      $request->left,
      $request->top
    );

    $name = '/images' . '/' . time() . '.' . $extension;
    $image->save(public_path() . $name);
    $model->image = $name;

    return $model;
  }
}