<?php

namespace App\Models\narrative\Traits;

trait NarrtiveAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            // $this->getViewButtonAttribute('narratives.show', 'create-activity-narrative'),
            null,
            $this->getEditButtonAttribute('narratives.edit', 'edit-activity-narrative'),
            $this->getDeleteButtonAttribute('narratives.destroy', 'delete-activity-narrative'),
        );
    }

    /**
     * Next Transaction Id
     */
    public function getNextTidAttribute()
    {
        return $this->where('ins', 1)->max('tid')+1;
    }
}
