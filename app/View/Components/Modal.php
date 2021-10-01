<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $modalId;
    public $modalSize;
    public $btnId;
    public $modalClose;
    public $title;
    public $formId;
    public $enctype;
    public $modalSubmit;
    public $form;

    public function __construct($modalId, $modalSize, $btnId, $title, $modalClose, $formId, $enctype, $modalSubmit, $form)
    {
        $this->modalId = $modalId;
        $this->modalSize = $modalSize;
        $this->btnId = $btnId;
        $this->title = $title;
        $this->modalClose = $modalClose;
        $this->formId = $formId;
        $this->enctype = $enctype;
        $this->modalSubmit = $modalSubmit;
        $this->form = $form;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
