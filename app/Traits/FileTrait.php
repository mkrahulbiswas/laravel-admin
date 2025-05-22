<?php

namespace app\Traits;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

trait FileTrait
{
    public static function picUrl($pic, $imgType, $platform)
    {
        //echo $pic;exit();
        $avatarUrl = config('constants.baseUrl') . config('constants.avatar');
        $avatar = 'no_image.png';
        if ($imgType == 'adminPic') {
            $url = config('constants.baseUrl') . config('constants.adminPic');
            $avatar = 'admin_avatar.png';
        } else if ($imgType == 'deliveryBoyPic') {
            $url = config('constants.baseUrl') . config('constants.deliveryBoyPic');
            $avatar = 'admin_avatar.png';
        } else if ($imgType == 'customersPic') {
            $url = config('constants.baseUrl') . config('constants.customersPic');
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
        } else if ($imgType == 'productPic') {
            $url = config('constants.baseUrl') . config('constants.productPic');
            $avatar = 'no_image.png';
        } else if ($imgType == 'clientPic') {
            $url = config('constants.baseUrl') . config('constants.clientPic');
            $avatar = 'no_image.png';
        } else if ($imgType == 'aboutPic') {
            $url = config('constants.baseUrl') . config('constants.aboutPic');
            $avatar = 'no_image.png';
        } else if ($imgType == 'cmsPagesPic') {
            $url = config('constants.baseUrl') . config('constants.cmsPagesPic');
            $avatar = 'no_image.png';
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

    public function uploadFile($data)
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
}
