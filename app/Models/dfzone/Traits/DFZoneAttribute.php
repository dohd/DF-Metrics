<?php

namespace App\Models\dfzone\Traits;

trait DFZoneAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            null,
            $this->getEditButtonAttribute('dfzones.edit', 'edit-cohort'),
            $this->getDeleteButtonAttribute('dfzones.destroy', 'delete-cohort'),
        );
    }
}
