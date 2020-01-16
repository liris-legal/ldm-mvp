<?php


namespace App\Services;

use Storage;

class FileService
{
    protected $awsFile;

    /**
     *  Function construct
     */
    public function __construct()
    {
        $this->awsFile = env('AWS_FILE');
    }

    /**
     * @function createFileS3
     * @description Is save file in storage S3
     *
     * @param \Illuminate\Http\Request $request
     * @param $key: request name. ex: 'file'
     * @return String filename
     */
    public function createFileS3($request, $key)
    {
        $file = $request->file($key);
        $fileName = str_replace(' ', '-', $file->getClientOriginalName());
        $filenameHash = substr(hash('md5', date("mdYhms")), 0, 10) . '-' . $fileName;

        $uploadDir = $this->awsFile . '/uploads/documents/';
        $fullpath = $uploadDir . $filenameHash;
        Storage::put($fullpath, file_get_contents($file), 'public');

        return $filenameHash;
    }

    /**
     * @function deleteFileS3
     * @description Delete file in S3 storage
     *
     * @param $file
     */
    public function deleteFileS3($file)
    {
        $fullSrc = $this->awsFile . '/uploads/documents/' . $file->url;
        if (Storage::disk('s3')->exists($fullSrc)) {
            Storage::disk('s3')->delete($fullSrc);
        }
    }

    /**
     * @function getFileUrlS3
     * @description Get file URL form S3 storage
     *
     * @param $file
     * @return String url
     */
    public function getFileUrlS3($fileName)
    {
        $fullSrc = $this->awsFile . '/uploads/documents/' . $fileName;
        if (Storage::disk('s3')->exists($fullSrc)) {
            return Storage::disk('s3')->url($fullSrc);
        }

        return null;
    }
}
