<?php

namespace App\Observers;

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Identity;

class IdentityObserver
{
    public function saving(Identity $identity)
    {
        $identity->first_name = ucwords(strtolower(trim($identity->first_name)));
        $identity->last_name = ucwords(strtolower(trim($identity->last_name)));

        if (isset($identity['photo'])) {
            $identity->addMedia($identity['photo'])->toMediaCollection();
        } elseif ($identity->getMedia()->count() === 0) {
            $avatar = new InitialAvatar();
            $image = $avatar->autoFont()->rounded()->smooth()->background('#21CCF7')->color('#FFFFFF')->size(128)->name($identity->full_name)->generate();
            $identity->addMediaFromBase64($image->encode('data-url', 100))->toMediaCollection();
        }

        unset($identity['photo']);
    }
}
