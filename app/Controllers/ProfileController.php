<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\Login\LoginService;
use App\Services\Login\LoginServiceRequest;
use App\Services\ProfileService;
use App\Template;

class ProfileController
{
    public function showProfile(): Template
    {
        return new Template('profile.twig');
    }

    public function changePasswordForm(): Template
    {
        return new Template('changeProfile.twig');
    }

    public function changePassword(): Redirect
    {
        $profileService = new ProfileService();
        $user = $profileService->getAllUserData();


        if ($_POST['new_name'] == $user->getName()) {
            $_SESSION['errors']['nameDifference'] = false;
        }

        if ($_POST['new_email'] == $user->getEmail()) {
            $_SESSION['errors']['correctEmail'] = false;
        }

        if (! password_verify($_POST['old_password'], $user->getPassword())) {
            $_SESSION['errors']['oldPasswordsMatch'] = false;
        }

        if ($_POST['new_password'] !== $_POST['new_password_repeat']) {
            $_SESSION['errors']['newPasswordsMatch'] = false;
        }

        if ( ! empty($_SESSION['errors'])) {
            return new Redirect('profile_change');
        }

        $profileService->updateUserData($_POST['new_name'], $_POST['new_email'], $_POST['new_password']);

        return new Redirect('profile');
    }
}