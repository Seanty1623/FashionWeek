<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AuthSessionStatus extends Component
{
    /**
     * The status message.
     */
    public ?string $status;

    /**
     * Create a new component instance.
     */
    public function __construct(?string $status = null)
    {
        $this->status = $status ?? session('status');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View|string
    {
        return view('components.auth-session-status');
    }
}