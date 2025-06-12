<?php
namespace App\View\Components\Products;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    public array $listCategories;

    public function __construct(
        public array $categories,
        public string $filterAction,
        public string $resetUrl,
        public ?string $category = null,
        public ?string $name = null,
        public ?float $priceMin = null,
        public ?float $priceMax = null,
        public ?bool $stockAlertOnly = false,
        public ?bool $showDeleted = false,
    ) {
        $this->listCategories = $categories;
        $this->showDeleted = $showDeleted ?? false;
    }

    public function render(): View|Closure|string
    {
        return view('components.products.filter-card');
    }
}
