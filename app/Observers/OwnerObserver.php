<?php

namespace App\Observers;

use App\Models\Owner;
use Illuminate\Support\Facades\Storage;

class OwnerObserver
{
    /**
     * Handle the Owner "created" event.
     */
    public function created(Owner $owner): void
    {
        //
       
    }

    /**
     * Handle the Owner "updated" event.
     */
    public function updated(Owner $owner): void
    {
        if($owner->isDirty('ktp_attachment') && ! is_null($owner->getOriginal('ktp_attachment'))){ 
            Storage::disk('public')->delete($owner->getOriginal('ktp_attachment'));
        }
    }

    /**
     * Handle the Owner "deleted" event.
     */
    public function deleted(Owner $owner): void
    {
        if (! is_null($owner->ktp_attachment)) {
            Storage::disk('public')->delete($owner->ktp_attachment);
        }
    }

    /**
     * Handle the Owner "restored" event.
     */
    public function restored(Owner $owner): void
    {
        //
    }

    /**
     * Handle the Owner "force deleted" event.
     */
    public function forceDeleted(Owner $owner): void
    {
        //
    }
}