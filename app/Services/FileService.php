<?php


namespace App\Services;

use Storage;

class FileService
{
    protected $AWS_FILE;

    /**
     *  Function construct
     */
    public function __construct()
    {
        $this->AWS_FILE = env('AWS_FILE');
    }

    /**
     * @description function is to image information in storage
     * @param $parent: parent model
     * @param \Illuminate\Http\Request $request
     * @param $key: photo
     */
    public function handleUploadedFile($parent, $request, $key)
    {
//        if ($request->hasFile($key)) {
//            if ($image = $parent->image) {
//                $this->deleteFileS3($image, $parentName);
//                $parent->image()->delete();
//            }
//
//            $filename = $this->createImageS3($request, $key, $parentName);
//            $parent->image()->save($this->storeImageToDB($filename));
//        }
    }

    /**
     * @description function is save file in storage S3
     *
     * @param \Illuminate\Http\Request $request
     * @param $parentName: name's parent model
     * @param $key: the photo
     * @return String filename
     */
    public function createFileS3($request, $key)
    {
        $file = $request->file($key);
        $fileName = str_replace(' ', '-', $file->getClientOriginalName());
        $filenameHash = substr(hash('md5', date("mdYhms")), 0, 10) . '-' . $fileName;

        $uploadDir = $this->AWS_FILE . '/uploads/documents/';
        $fullpath = $uploadDir . $filenameHash;
        Storage::put($fullpath, file_get_contents($file), 'public');

        return $filenameHash;
    }

    /**
     * Create image to database,
     *
     * @param $filenameHash
     */
    public function storeFileToDB($filenameHash)
    {
//        $image = new Image();
//        $image->url = $filenameHash;
//        return $image;
    }

    /**
     * Delete image in S3 storage
     *
     * @param $file
     * @param $parentName
     */
    public function deleteFileS3($file)
    {
        $fullSrc = $this->AWS_FILE . '/uploads/documents/' . $file->url;
        if (Storage::disk('s3')->exists($fullSrc)) {
            Storage::disk('s3')->delete($fullSrc);
        }
    }

    /**
     * Get image URL form S3 storage
     *
     * @param $file
     * @return File url
     */
    public function getFileUrlS3($file)
    {
        $parent = $this->getMorphClassName($file);

        $fullSrc = '/uploads/' . $parent . '/' . $file->url;
        if (Storage::disk('s3')->exists($fullSrc)) {
            return Storage::disk('s3')->url($fullSrc);
        }

        return null;
    }
}
