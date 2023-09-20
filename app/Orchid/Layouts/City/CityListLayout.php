<?php

namespace App\Orchid\Layouts\City;


use App\Models\City;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

use Orchid\Screen\Actions\ModalToggle;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CityListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'cities';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide(),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (City $city) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        ModalToggle::make(__('Update'))
                            ->icon('bs.pencil')
                            ->modal('cityModal')
                            ->modalTitle(__('Update City'))
                            ->method('update')
                            ->asyncParameters([
                                'city' => $city->id,
                            ]),

                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Are you sure to delete this city?.'))
                            ->method('remove', [
                                'city' => $city->id,
                            ]),
                    ])),
        ];
    }
}
