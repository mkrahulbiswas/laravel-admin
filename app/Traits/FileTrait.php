<?php

namespace app\Traits;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

trait FileTrait
{
    public static function picUrl2($data)
    {
        [
            'fileName' => $fileName,
            'storage' => $storage,
        ] = $data;

        $finalData = [];

        if ($fileName == '' || $fileName == 'NA') {
            $picture = config('constants.baseUrl') . config('constants.avatar') . 'no_image.png';
        } else {
        }

        // dd(asset('') .  storage_path() . $fileName);
        // dd(config('constants.baseUrl'));
        // dd(public_path());
        // dd(public_path('storage'));

        foreach ($storage['for'] as $tempOne) {
            if ($tempOne == 'public') {
                $filePath = Storage::disk($tempOne)->url($storage['path'] . $fileName);
            }
            if ($tempOne == 'local') {
                $filePath = Storage::disk($tempOne)->path($storage['path'] . $fileName);
            }

            $finalData[$tempOne] = [
                'path' => $filePath
            ];
        }

        dd($finalData);

        // if ($imgType == 'adminPic') {
        //     $url = config('constants.baseUrl') . config('constants.adminPic');
        // } else {
        //     return false;
        // }

        // if ($pic != 'NA') {
        //     if (strpos($pic, 'https') !== false) {
        //         $picture = $pic;
        //     } else {
        //         $picture = $url . $pic;
        //     }
        // }

        return $picture;
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
                foreach ($storage['for'] as $tempOne) {
                    if (Storage::disk($tempOne)->makeDirectory($storage['path'], 0775, true)) {
                        reCreateFileName:
                        $fileName = time() . '_' . mt_rand() . '_' . mt_rand() . '.' . $image->getClientOriginalExtension();
                        if (Storage::disk($tempOne)->exists($storage['path'] . $fileName)) {
                            goto reCreateFileName;
                        } else {
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
                                        if (Storage::disk($tempOne)->delete($file['previous'])) {
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






    public static function picUrl($pic, $imgType, $platform)
    {
        //echo $pic;exit();
        $avatarUrl = config('constants.baseUrl') . config('constants.avatar');
        $avatar = 'no_image.png';

        if ($imgType == 'adminPic') {
            $url = config('constants.baseUrl') . config('constants.adminPic');
            $avatar = 'admin_avatar.png';
        } else if ($imgType == 'bannerPic') {
            $url = config('constants.baseUrl') . config('constants.bannerPic');
            $avatar = 'no_image.png';
        } else if ($imgType == 'bigLogoPic') {
            $url = config('constants.baseUrl') . config('constants.bigLogoPic');
            $avatar = 'no_image.png';
        } else if ($imgType == 'smallLogoPic') {
            $url = config('constants.baseUrl') . config('constants.smallLogoPic');
            $avatar = 'no_image.png';
        } else if ($imgType == 'favIconPic') {
            $url = config('constants.baseUrl') . config('constants.favIconPic');
            $avatar = 'no_image.png';
        } else if ($imgType == 'adminUsers') {
            $url = config('constants.baseUrl') . Config::get('constants.storage.adminUsers.path');
            $avatar = 'admin_avatar.png';
        } else {
            return false;
        }

        if ($pic != 'NA') {
            if (strpos($pic, 'https') !== false) {
                $picture = $pic;
            } else {
                $picture = $url . $pic;
            }
        } else {
            if ($platform == 'backend') {
                $picture = $avatarUrl . $avatar;
            } elseif ($platform == 'web') {
                $picture = $avatarUrl . $avatar;
            } elseif ($platform == 'app') {
                $picture = $avatarUrl . $avatar;
            } else {
                $picture = 'NA';
            }
        }

        return $picture;
    }

    public function uploadPicture($image, $previousImg, $platform, $imgType)
    {
        try {
            $image = $image;
            // $input['imagename'] = md5($image->getClientOriginalName() . microtime()) . "." . $image->getClientOriginalExtension();
            if ($platform == 'backend') {
                $input['imagename'] = time() . '_' . mt_rand() . '_' . mt_rand() . '.' . $image->getClientOriginalExtension();

                if ($imgType == 'adminPic') {
                    // $largeWidth = '200';
                    // $largeHeight = '200';
                    // $largePicPath = config('constants.adminPic');
                    // $smallPicPath = '';
                    // Image::make($image->getRealPath())->resize($largeWidth, $largeHeight)->save($largePicPath . $input['imagename']);
                    $largePicPath = config('constants.adminPic');
                    // $largePicPath = str_replace('public/', '', config('constants.adminPic'));
                    // dd($largePicPath);
                    $smallPicPath = '';
                    $image->move($largePicPath, $input['imagename']);
                } else if ($imgType == 'adminUsers') {
                    $largePicPath =  Config::get('constants.storage.adminUsers.path');
                    $smallPicPath = '';
                    $image->move($largePicPath, $input['imagename']);
                } else {
                }
            } elseif ($platform == 'web') {
                $input['imagename'] = time() . '_' . mt_rand() . '_' . mt_rand() . '.' . $image->getClientOriginalExtension();
                // if ($imgType == 'customerPic') {
                //     $largeWidth = '300';
                //     $largeHeight = '300';
                //     $largePicPath = config('constants.customerPic');
                //     $smallPicPath = '';
                //     Image::make($image->getRealPath())->resize($largeWidth, $largeHeight)->save($largePicPath . $input['imagename']);
                // }
            } elseif ($platform == 'app') {
                $input['imagename'] = time() . '_' . mt_rand() . '_' . mt_rand() . '.png';
                if ($imgType == 'customersPic') {
                    // $largePicPath = config('constants.employeePic');
                    $largePicPath = str_replace('public/', '', config('constants.customersPic'));
                    $smallPicPath = '';
                } else if ($imgType == 'degreeImagePic') {
                    $largePicPath = str_replace('public/', '', config('constants.degreeImagePic'));
                    $smallPicPath = '';
                }

                file_put_contents(($largePicPath . $input['imagename']), base64_decode(str_replace(' ', '+', $image)));
            }

            if (!empty($largePicPath)) {
                if (!file_exists($largePicPath . $input['imagename'])) {
                    return false;
                }
            }

            if (!empty($smallPicPath)) {
                if (!file_exists($largePicPath . $input['imagename'])) {
                    return false;
                }
            }

            if (!empty($previousImg)) {
                if ($previousImg == 'NA') {
                    return $input['imagename'];
                } else {
                    if (unlink($largePicPath . $previousImg)) {
                        if ($smallPicPath != '') {
                            unlink($smallPicPath . $previousImg);
                        }
                        return $input['imagename'];
                    } else {
                        return false;
                    }
                }
            } else {
                return $input['imagename'];
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
