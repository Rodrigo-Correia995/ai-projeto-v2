<?php
namespace App\View\Components\Cards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{


    public function __construct(
        public string $filterAction,
        public string $resetUrl,
        public ?int $id = null,
        public ?int $card_number = null,

    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.filter-card');
    }
}
