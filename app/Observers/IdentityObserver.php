<?php

namespace App\Observers;

use App\Models\Identity;
use Intervention\Image\Facades\Image;
use Storage;

class IdentityObserver
{
    /**
     * Handle the identity "created" event.
     *
     * @param  \App\Models\Identity  $identity
     * @return void
     */
    public function created(Identity $identity)
    {
        //
    }

    /**
     * Handle the identity "updated" event.
     *
     * @param  \App\Models\Identity  $identity
     * @return void
     */
    public function updated(Identity $identity)
    {
        //
    }

    public function saving(Identity $identity)
    {
        $identity->first_name = strtolower($identity->first_name);
        $identity->last_name = strtolower($identity->last_name);

        if (isset($identity->photo)) {
            $img = Image::make($identity->photo);
            $img->save($path = Storage::path('portraits/' . $identity->user_id));

            $identity->photo_url = $path;
            unset($identity->photo);
        }
    }

    /**
     * Handle the identity "deleted" event.
     *
     * @param  \App\Models\Identity  $identity
     * @return void
     */
    public function deleted(Identity $identity)
    {
        //
    }

    /**
     * Handle the identity "restored" event.
     *
     * @param  \App\Models\Identity  $identity
     * @return void
     */
    public function restored(Identity $identity)
    {
        //
    }

    /**
     * Handle the identity "force deleted" event.
     *
     * @param  \App\Models\Identity  $identity
     * @return void
     */
    public function forceDeleted(Identity $identity)
    {
        //
    }
}
