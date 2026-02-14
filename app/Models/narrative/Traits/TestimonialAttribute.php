<?php

namespace App\Models\narrative\Traits;

trait TestimonialAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            $this->getViewButtonAttribute('narratives.show', ''),
            $this->getEditButtonAttribute('narratives.edit', ''),
            $this->getDeleteButtonAttribute('narratives.destroy', ''),
        );
    }
}
