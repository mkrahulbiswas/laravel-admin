<?php

namespace app\Traits;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait FileTrait
{
    public static function getFile($data)
    {
        try {
            [
                'fileName' => $fileName,
                'storage' => $storage,
            ] = $data;
            $finalData = $filePath = [];
            foreach ($storage['for'] as $tempOne) {
                if ($fileName == '' || $fileName == 'NA') {
                    $filePath = [
                        'asset' => Config::get('constants.baseUrl') . Config::get('constants.avatar') . 'no_image.png',
                        'get' => '',
                        'url' => '',
                    ];
                } else {
                    if (Storage::disk($tempOne)->exists($storage['path'] . $fileName)) {
                        if ($tempOne == 'public') {
                            if ($storage['type'] == Config::get('constants.storage')['adminUsers']['type']) {
                            }
                            $asset = asset("storage") . '/' . $storage['path'] . $fileName;
                            $get = Storage::disk($tempOne)->get($storage['path'] . $fileName);
                            $url = Storage::disk($tempOne)->url($storage['path'] . $fileName);
                        } elseif ($tempOne == 'local') {
                            if ($storage['type'] == Config::get('constants.storage')['adminUsers']['type']) {
                            }
                            $asset = asset("storage") . '/' . $storage['path'] . $fileName;
                            $get = Storage::disk($tempOne)->get($storage['path'] . $fileName);
                            $url = Storage::disk($tempOne)->url($storage['path'] . $fileName);
                        } else {
                            if ($storage['type'] == Config::get('constants.storage')['adminUsers']['type']) {
                            }
                            $asset = '';
                            $get = '';
                            $url = Storage::disk($tempOne)->url($storage['path'] . $fileName);
                        }
                        $filePath = [
                            'asset' => $asset,
                            'get' => $get,
                            'url' => $url,
                        ];
                    } else {
                        $filePath = [
                            'asset' => Config::get('constants.baseUrl') . Config::get('constants.avatar') . 'no_image.png',
                            'get' => '',
                            'url' => '',
                        ];
                    }
                }
                $finalData[$tempOne] = [
                    'fullPath' => $filePath,
                    'fileName' => $fileName
                ];
                $filePath = [];
            }
            return $finalData;
        } catch (Exception $e) {
            return [
                'fullPath' => [
                    'asset' => Config::get('constants.baseUrl') . Config::get('constants.avatar') . 'no_image.png',
                    'get' => '',
                    'url' => '',
                ],
                'fileName' => $fileName
            ];
        }
    }

    public static function uploadFile($data)
    {
        try {
            [
                'file' => $file,
                'platform' => $platform,
                'storage' => $storage,
            ] = $data;
            $uploadType = 'normal';

            if (!empty($storage['path'])) {
                $fileContent = $file['current'];
                $fileName = time() . '_' . strtotime(date('y-m-d')) . '_' . mt_rand() . '.' . $fileContent->getClientOriginalExtension();
                foreach ($storage['for'] as $tempOne) {
                    if (Storage::disk($tempOne)->makeDirectory($storage['path'], 0775, true)) {
                        if ($platform == 'backend') {
                            if ($storage['type'] == Config::get('constants.storage')['adminUsers']['type']) {
                            } else {
                            }
                        } elseif ($platform == 'web') {
                            if ($storage['type'] == Config::get('constants.storage')['adminUsers']['type']) {
                            } else {
                            }
                        } elseif ($platform == 'app') {
                            if ($storage['type'] == Config::get('constants.storage.testFile.type')) {
                                $tempFileContent = self::customizeImage([
                                    'maxSize' => 20,
                                    // 'maxSize' => 5120,
                                    'fileContent' => $fileContent,
                                    'fileName' => $fileName,
                                    'for' => 'sizeReduce'
                                ]);
                                $fileContent = $tempFileContent['fileContent'];
                                $uploadType = 'processed';
                            } else {
                            }
                        }
                        $uploadSuccess = $uploadType == 'normal' ?
                            Storage::disk($tempOne)->putFileAs($storage['path'], $fileContent, $fileName) :
                            Storage::disk($tempOne)->put($storage['path'] . $fileName, (string) $fileContent);
                        if ($uploadSuccess) {
                            if (!empty($file['previous'])) {
                                if ($file['previous'] == 'NA') {
                                    $response = [
                                        'type' => true,
                                        'name' => $fileName
                                    ];
                                } else {
                                    if (Storage::disk($tempOne)->delete($storage['path'] . $file['previous'])) {
                                        $response = [
                                            'type' => true,
                                            'name' => $fileName
                                        ];
                                    } else {
                                        $response = [
                                            'type' => false,
                                            'msg' => __('messages.fileUploadMsg.fileDelete.failed'),
                                        ];
                                    }
                                }
                            } else {
                                $response = [
                                    'type' => true,
                                    'name' => $fileName
                                ];
                            }
                        } else {
                            $response = [
                                'type' => false,
                                'msg' => __('messages.fileUploadMsg.fileSave.failed'),
                            ];
                        }
                    } else {
                        $response = [
                            'type' => false,
                            'msg' => __('messages.fileUploadMsg.createFolder.failed'),
                        ];
                    }
                }
            } else {
                $response = [
                    'type' => false,
                    'msg' => __('messages.fileUploadMsg.folderPath.failed'),
                ];
            }
            return $response;
        } catch (Exception $e) {
            return [
                'type' => false,
                'msg' => __('messages.serverErrMsg'),
            ];
        }
    }

    private static function customizeImage($data)
    {
        try {
            $tempPath = Config::get('constants.tempFilePath') . '/' . $data['fileName'];
            if ($data['for'] == 'sizeReduce') {
                if (intval($data['fileContent']->getSize() / 1024) >= $data['maxSize']) {
                    $data['fileContent']->move(Config::get('constants.tempFilePath'), $data['fileName']);
                    $manager = new ImageManager(new Driver());
                    $fileContent = $manager->read($tempPath)
                        // ->resize(800, 800, function ($constraint) {
                        //     $constraint->aspectRatio();
                        //     $constraint->upsize();
                        // })
                        // ->scale(40, 40, function ($constraint) {
                        //     $constraint->aspectRatio();
                        //     $constraint->upsize();
                        // })
                        ->encodeByExtension($data['fileContent']->getClientOriginalExtension(), 75);
                    if (file_exists($tempPath)) {
                        unlink($tempPath);
                    }
                    return [
                        'type' => true,
                        'fileContent' => $fileContent,
                    ];
                }
            } else {
                if (file_exists($tempPath)) {
                    unlink($tempPath);
                }
                return [
                    'type' => false,
                    'msg' => __('messages.serverErrMsg'),
                ];
            }
        } catch (\Throwable $th) {
            return [
                'type' => false,
                'msg' => __('messages.serverErrMsg'),
            ];
        }
    }
}
