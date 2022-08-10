<?php

namespace App\Traits;



use Illuminate\Http\Request;


trait ImageTrait
{
    public function saveImage($image, $path = null)
    {

        $name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path() . '/images/rooms', $name);
        return $name;
    }

    public function saveImages($image, $path = null)
    {


        // $name = $image->getClientOriginalName();
        $name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path() . '/images/rooms', $name);
        $images[] = $name;

        return $images;
    }

    public function deleteImage($image)
    {
        $image_path = public_path() . '/images/rooms/' . $image;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    public function deleteImages($images)
    {
        foreach ($images as $image) {
            $image_path = public_path() . '/images/rooms/' . $image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
    }

    public function updateImage($oldImage, $image)
    {
        $this->deleteImages($oldImage);
        return $this->saveImage($image);
    }
}
