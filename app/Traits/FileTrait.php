<?php

namespace app\Traits;

use Exception;
use Image;

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
                } elseif ($imgType == 'bannerPic') {
                    $largePicPath = config('constants.bannerPic');
                    $smallPicPath = '';
                    $image->move($largePicPath, $input['imagename']);
                } elseif ($imgType == 'bigLogoPic') {
                    $largePicPath = config('constants.bigLogoPic');
                    $smallPicPath = '';
                    $image->move($largePicPath, $input['imagename']);
                } elseif ($imgType == 'smallLogoPic') {
                    $largePicPath = config('constants.smallLogoPic');
                    $smallPicPath = '';
                    $image->move($largePicPath, $input['imagename']);
                } elseif ($imgType == 'favIconPic') {
                    $largePicPath = config('constants.favIconPic');
                    $smallPicPath = '';
                    $image->move($largePicPath, $input['imagename']);
                } elseif ($imgType == 'productPic') {
                    // $largePicPath = config('constants.productPic');
                    // $smallPicPath = '';
                    // $image->move($largePicPath, $input['imagename']);

                    $largeWidth = '400';
                    $largeHeight = '450';
                    $largePicPath = config('constants.productPic');
                    $smallPicPath = '';
                    Image::make($image->getRealPath())->resize($largeWidth, $largeHeight)->save($largePicPath . $input['imagename']);
                } elseif ($imgType == 'clientPic') {
                    $largePicPath = config('constants.clientPic');
                    $smallPicPath = '';
                    $image->move($largePicPath, $input['imagename']);
                } elseif ($imgType == 'cmsPagesPic') {
                    $largePicPath = config('constants.cmsPagesPic');
                    $smallPicPath = '';
                    $image->move($largePicPath, $input['imagename']);
                } elseif ($imgType == 'aboutPic') {
                    $largePicPath = config('constants.aboutPic');
                    $smallPicPath = '';
                    $image->move($largePicPath, $input['imagename']);
                } else {
                }
            } elseif ($platform == 'web') {
                $input['imagename'] = time() . '_' . mt_rand() . '_' . mt_rand() . '.' . $image->getClientOriginalExtension();

                if ($imgType == 'customerPic') {
                    $largeWidth = '300';
                    $largeHeight = '300';
                    $largePicPath = config('constants.customerPic');
                    $smallPicPath = '';
                    Image::make($image->getRealPath())->resize($largeWidth, $largeHeight)->save($largePicPath . $input['imagename']);
                } elseif ($imgType == 'clientPic') {
                    $largePicPath = config('constants.clientPic');
                    $smallPicPath = '';
                    $image->move($largePicPath, $input['imagename']);
                }
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
