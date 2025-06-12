<?php
namespace App\View\Components\Users;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{


    public function __construct(
        public string $filterAction,
        public string $resetUrl,
        public ?string $user = null,
        public ?int $id = null,
        public ?int $nif = null,
        public ?string $name = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.users.filter-card');
    }
}
