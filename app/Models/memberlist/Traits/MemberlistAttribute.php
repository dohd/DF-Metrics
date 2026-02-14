<?php

namespace App\Models\memberlist\Traits;

trait MemberlistAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            $this->getViewButtonAttribute('memberlists.show', 'view-attendance'),
            $this->getEditButtonAttribute('memberlists.edit', 'edit-attendance'),
            $this->getDeleteButtonAttribute('memberlists.destroy', 'delete-attendance'),
        );
    }
}
