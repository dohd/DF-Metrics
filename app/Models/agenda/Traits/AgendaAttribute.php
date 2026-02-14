<?php

namespace App\Models\agenda\Traits;

trait AgendaAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            $this->getViewButtonAttribute('agenda.show', 'view-agenda'),
            $this->getEditButtonAttribute('agenda.edit', 'edit-agenda'),
            $this->getDeleteButtonAttribute('agenda.destroy', 'delete-agenda'),
        );
    }
}
