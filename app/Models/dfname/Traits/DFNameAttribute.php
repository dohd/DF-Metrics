<?php

namespace App\Models\dfname\Traits;

trait DFNameAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            null,
            $this->getEditButtonAttribute('dfnames.edit', 'edit-cohort'),
            $this->getDeleteButtonAttribute('dfnames.destroy', 'delete-cohort'),
        );
    }
}
