<?php

return [
    'adminLoginErr' => 'Invalid Username and Password.',
    'loginErr' => 'Invalid phone number and password.',
    'vErrMsg' => 'Validation failed.',
    'pinVError' => 'Please create your pin.',
    'blockMsg' => 'You account is disabled, please contact with admin',
    'serverErrMsg' => 'Something went wrong.',
    'successMsg' => 'Success.',
    'appVersionNotMatchMsg' => 'The app version is not match, please update the app.',
    'oldPassPinNotMatchMsg' => 'Oops!! the old :type is not matched, please try again.',
    'otpNotMatchMsg' => 'Oops!! the provided otp is not matched, please check again.',
    'otpNotTypeMsg' => 'Oops!! its looks like you are trying to change other type of action.',
    'otpNotVerifiedMsg' => 'Its look you are not verified OTP but try to change something.',
    'checkUserInvalidInputMsg' => 'Note you can not send both email & phone empty or filled. You have to give any one of them.',
    'alreadyUserCreateMsg' => 'User is already created, please login.',
    'inactiveUserMsg' => 'You account is blocked.',
    'incompleteUserMsg' => 'You account is not complete yet for login.',
    'fileUploadMsg' => [
        'fileDelete' => [
            'success' => 'Successfully file deleted.',
            'failed' => 'Sorry, we are unable to delete the file.',
        ],
        'fileSave' => [
            'success' => 'Successfully file saved.',
            'failed' => 'Sorry, we are unable to save the file.',
        ],
        'createFolder' => [
            'success' => 'Successfully folder created.',
            'failed' => 'Sorry, we are unable to create the folder.',
        ],
        'folderPath' => [
            'success' => 'Folder path is found.',
            'failed' => 'Sorry, there no folder path is mentioned in constant file.',
        ],
        'fileAvailable' => [
            'success' => 'File found.',
            'failed' => 'Sorry, there no file found in :type storage folder in path of ":path"',
        ]
    ],
    'notAllowMsg' => 'You cannot create sub role by using super admin.',
    'dataFoundMsg' => [
        'success' => 'List of :type found.',
        'failed' => 'Oops!! No :type found.',
    ],
    'saveMsg' => [
        'success' => ':type successfully saved.',
        'failed' => ':type failed to saved.',
    ],
    'updateMsg' => [
        'success' => ':type successfully updated.',
        'failed' => ':type failed to updated.',
    ],
    'setAccessMsg' => [
        'success' => ':type successfully set.',
        'failed' => ':type failed to set.',
        'validation' => ':type you must select one access type.',
    ],
    'changeMsg' => [
        'success' => ':type successfully changed.',
        'failed' => ':type failed to change.',
    ],
    'statusMsg' => [
        'success' => ':type status successfully changed.',
        'failed' => ':type status failed to change.',
    ],
    'deleteMsg' => [
        'success' => ':type deleted successfully.',
        'failed' => ':type failed to delete.',
    ],
    'defaultMsg' => [
        'success' => ':type set as default successfully.',
        'failed' => ':type failed to set as default.',
    ],
    'existMsg' => [
        'success' => 'Your :type is already exist.',
        'failed' => 'Your :type is not exist.',
    ],
    'changeOriginMsg' => [
        'success' => 'Your :type is already exist.',
        'failed' => 'Your :type the previous selected types defied we found there with same type other data present pleas make its yeas ans than change.',
    ],
    'otpMsg' => [
        'success' => 'OTP send successfully.',
        'failed' => 'Failed to send otp.',
    ],
    'otpVerifyMsg' => [
        'success' => 'OTP verified successfully.',
        'failed' => 'Failed to verify otp.',
    ],
    'resetMsg' => [
        'success' => ':type reset successfully.',
        'failed' => 'Failed to reset :type.',
    ],
    'createUserMsg' => [
        'success' => 'Successfully create user to complete the registration process.',
        'failed' => 'Failed to create user to complete the registration process, please try again.',
    ],
    'noProfileDataMsg' => [
        'success' => 'Successfully profile data fetched.',
        'failed' => 'No profile data found.',
    ],
    'registerSuccess' => 'Successfully registered, just need to verify your OTP.',
    'loginSuccess' => 'Successfully logged in.',
    'logoutSuccess' => 'Successfully logged out.',
    'unauthenticatedMsg' => 'You are not authorized. Please login with you credential to get access.',
    'requiredFiend' => '*',
];
