<?php

namespace App\Observers;

use App\Models\Identity;

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

        //TODO: set this
        if (isset($identity->photo)) {

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
