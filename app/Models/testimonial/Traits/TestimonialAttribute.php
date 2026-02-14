<?php

namespace App\Models\testimonial\Traits;

trait TestimonialAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            $this->getViewButtonAttribute('testimonials.show', ''),
            $this->getEditButtonAttribute('testimonials.edit', ''),
            $this->getDeleteButtonAttribute('testimonials.destroy', ''),
        );
    }
}
