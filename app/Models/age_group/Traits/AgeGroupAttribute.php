<?php

namespace App\Models\age_group\Traits;

trait AgeGroupAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            null,
            $this->getEditButtonAttribute('age_groups.edit', 'edit-age-group'),
            $this->getDeleteButtonAttribute('age_groups.destroy', 'delete-age-group'),
        );
    }
}
