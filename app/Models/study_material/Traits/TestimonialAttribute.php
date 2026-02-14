<?php

namespace App\Models\study_material\Traits;

trait TestimonialAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            $this->getViewButtonAttribute('study_materials.show', ''),
            $this->getEditButtonAttribute('study_materials.edit', ''),
            $this->getDeleteButtonAttribute('study_materials.destroy', ''),
        );
    }
}
