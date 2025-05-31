<?php
namespace App\View\Components\Products;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCardCatalog extends Component
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
    ) {
        $this->listCategories = $categories;
    }

    public function render(): View|Closure|string
    {
        return view('components.products.filter-card-catalog');
    }
}
