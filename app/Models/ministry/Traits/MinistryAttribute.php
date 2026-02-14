<?php

namespace App\Models\ministry\Traits;

trait MinistryAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            null,
            $this->getEditButtonAttribute('ministries.edit', 'edit-programme'),
            $this->getDeleteButtonAttribute('ministries.destroy', 'delete-programme'),
        );
    }
}
