<?php

namespace App\Orchid\Layouts\Client;

use App\Orchid\Filters\CityFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ClientFiltersLayout extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            CityFilter::class,
        ];
    }
}
