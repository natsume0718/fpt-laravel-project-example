<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    const BASE_UPLOAD_FOLDER = 'images/';

    protected $storageDisk;

    /**
     * Service constructor.
     *
     */
    public function __construct()
    {
        $this->storageDisk = Storage::disk(config('common.images.driver_to_upload'));
    }

    /**
     * @param  UploadedFile  $image
     * @param  null  $description
     * @return array|bool
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function storeImage(UploadedFile $image, $description = null)
    {
        $uploadFolder = $this->getUploadFolder();
        $imageName = $this->getUniqueImagePath(
            $image->getClientOriginalExtension()
        );

        $path = $image->storeAs($uploadFolder, $imageName, config('common.images.driver_to_upload'));

        if ($path) {
            $path = config('common.upload.folder_to_upload') . '/' . $path;

            return $path;
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getUploadFolder()
    {
        return self::BASE_UPLOAD_FOLDER . date('Y') . '/' . date('m') . '/' . date('d');
    }

    /**
     * @param $originalExtension
     * @return string
     */
    protected function getUniqueImagePath($originalExtension)
    {
        return Str::uuid()->toString() . '-' . time() . '.' . $originalExtension;
    }
}
