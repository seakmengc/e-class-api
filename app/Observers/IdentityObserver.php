<?php

namespace App\Observers;

use App\Models\Identity;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class IdentityObserver
{
    public function saving(Identity $identity)
    {
        $identity->first_name = ucwords(strtolower(trim($identity->first_name)));
        $identity->last_name = ucwords(strtolower(trim($identity->last_name)));

        if (!is_null($identity->photo)) {
            $img = Image::make($identity->photo);
            $path = Storage::path(Identity::$photoPath);

            if (!file_exists($path))
                exec("mkdir -p {$path}");

            $img->save($path . $identity->user_id . '.jpg', 90, 'jpg');

            $identity->photo_url = Identity::$photoPath . $identity->user_id . '.jpg';
        }

        unset($identity->photo);
    }
}
