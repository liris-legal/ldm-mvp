<?php


namespace App\Services;

use Storage;

class FileService
{
    /**
     *  AWS URL
     * @var string
     */
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
        $filenameHash = substr(hash('md5', date("mdYhms")), 0, 15) . '-' . $fileName;

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
        if (Storage::exists($fullSrc)) {
            Storage::delete($fullSrc);
        }
    }

    /**
     * @function getFileUrlS3
     * @description Get file URL form S3 storage
     *
     * @param $fileName
     * @return String url
     */
    public function getFileUrlS3($fileName)
    {
        $fullSrc = $this->awsFile . '/uploads/documents/' . $fileName;
        if (Storage::exists($fullSrc)) {
            return Storage::url($fullSrc);
        }

        return null;
    }
}
