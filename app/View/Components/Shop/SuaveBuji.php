<?php

namespace App\View\Components\Shop;
use Illuminate\View\Component;

class SuaveBuji extends Component
{
    public $item;
    public $class;

    public function __construct($item, $class = null)
    {
        $this->item = $item;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.shop.suave-buji');
    }
}
