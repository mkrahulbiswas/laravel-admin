<?php

namespace app\Traits;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
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
                        'asset' => config('constants.baseUrl') . config('constants.avatar') . 'no_image.png',
                        'get' => '',
                        'url' => '',
                    ];
                } else {
                    if (Storage::disk($tempOne)->exists($storage['path'] . $fileName)) {
                        if ($tempOne == 'public') {
                            if ($storage['type'] == Config::get('constants.storage')['adminUsers']['type']) {
                            }
                        } elseif ($tempOne == 'local') {
                            if ($storage['type'] == Config::get('constants.storage')['adminUsers']['type']) {
                            }
                        } else {
                            if ($storage['type'] == Config::get('constants.storage')['adminUsers']['type']) {
                            }
                        }

                        $filePath = [
                            'asset' => asset("storage") . '/' . $storage['path'] . $fileName,
                            'get' => Storage::disk($tempOne)->get($storage['path'] . $fileName),
                            'url' => Storage::disk($tempOne)->url($storage['path'] . $fileName),
                        ];
                    } else {
                        $filePath = [
                            'asset' => config('constants.baseUrl') . config('constants.avatar') . 'no_image.png',
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
                    'asset' => config('constants.baseUrl') . config('constants.avatar') . 'no_image.png',
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

            if (!empty($storage['path'])) {
                $image = $file['current'];
                $fileName = time() . '_' . strtotime(date('y-m-d')) . '_' . mt_rand() . '.' . $image->getClientOriginalExtension();
                foreach ($storage['for'] as $tempOne) {
                    if (Storage::disk($tempOne)->makeDirectory($storage['path'], 0775, true)) {
                        if ($platform == 'backend') {
                            if ($storage['type'] == Config::get('constants.storage')['adminUsers']['type']) {
                                // $largeWidth = '200';
                                // $largeHeight = '200';
                                // $storage = str_replace('public/', '', $storage['path']);
                                // $storage = $storage['path'];
                                // Image::make($image->getRealPath())->resize($largeWidth, $largeHeight)->save($storage . $fileName);

                                // $image = ImageManager::imagick()->read($image);
                                // $image->resize(200, 200);
                                // dd($image);

                                // Storage::disk('public')->putFileAs($storage['path'], $image, $fileName);

                                // $uploadedFile = $request->file('avatar');
                                // $path = Storage::disk($disk)->putFileAs('avatars', $uploadedFile, 'custom_avatar.jpg');

                                // $storage = $storage['path'];
                                // $image->move($storage, $fileName);
                            } else {
                            }
                        } elseif ($platform == 'web') {
                            // if ($imgType == 'customerPic') {
                            //     $largeWidth = '300';
                            //     $largeHeight = '300';
                            //     $storage = config('constants.customerPic');
                            //     Image::make($image->getRealPath())->resize($largeWidth, $largeHeight)->save($storage . $fileName);
                            // } elseif ($imgType == 'clientPic') {
                            //     $storage = config('constants.clientPic');
                            //     $image->move($storage, $fileName);
                            // }
                        } elseif ($platform == 'app') {
                            // $fileName = time() . '_' . mt_rand() . '_' . mt_rand() . '.png';
                            // if ($imgType == 'customersPic') {
                            //     // $storage = config('constants.employeePic');
                            //     $storage = str_replace('public/', '', config('constants.customersPic'));
                            // } else if ($imgType == 'degreeImagePic') {
                            //     $storage = str_replace('public/', '', config('constants.degreeImagePic'));
                            // }
                            // file_put_contents(($storage . $fileName), base64_decode(str_replace(' ', '+', $image)));
                        }
                        if (Storage::disk($tempOne)->putFileAs($storage['path'], $image, $fileName)) {
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
}
