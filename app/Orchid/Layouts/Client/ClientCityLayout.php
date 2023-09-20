<?php
declare(strict_types=1);
namespace App\Orchid\Layouts\Client;

use App\Models\City;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;

class ClientCityLayout extends Rows
{

    /**
     * Ghe screen's layout elements.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Input::make(__('client.name'))
                ->type('text')
                ->title(__('Name'))
                ->placeholder(__('Enter client name')),
            Select::make('client.city_id')
                ->fromModel(City::class, 'name')
                ->empty()
                ->title(__('Name city')),
        ];
    }
}
