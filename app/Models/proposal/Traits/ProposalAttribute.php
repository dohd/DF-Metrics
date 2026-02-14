<?php

namespace App\Models\proposal\Traits;

trait ProposalAttribute
{
    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getButtonWrapperAttribute(
            $this->getViewButtonAttribute('proposals.show', 'view-proposal'),
            $this->getEditButtonAttribute('proposals.edit', 'edit-proposal'),
            $this->getDeleteButtonAttribute('proposals.destroy', 'delete-proposal'),
        );
    }

    /**
     * Next Transaction Id
     */
    public function getNextTidAttribute()
    {
        return $this->where('ins', 1)->max('tid')+1;
    }
}
