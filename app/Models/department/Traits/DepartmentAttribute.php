<?php

namespace App\Models\department\Traits;

trait DepartmentAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            null,
            $this->getEditButtonAttribute('departments.edit', 'edit-programme'),
            $this->getDeleteButtonAttribute('departments.destroy', 'delete-programme'),
        );
    }
}
