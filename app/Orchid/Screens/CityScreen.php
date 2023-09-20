<?php

namespace App\Orchid\Screens;

use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use App\Orchid\Layouts\City\CityListLayout;



use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CityScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'cities' => City::latest()->simplePaginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Cities';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Add City')
                ->modal('cityModal')
                ->method('create')
                ->icon('plus'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CityListLayout::class,
            Layout::modal('cityModal', Layout::rows([
                Input::make(__('city.name'))
                    ->type('text')
                    ->title(__('Name'))
                    ->placeholder(__('Enter city name')),
            ]))
                ->title(__('Create City'))
                ->applyButton('Add City')
                ->async('asyncGetCity'),
        ];
    }
    /**
     * @return array
     */
    public function asyncGetCity(City $city): iterable
    {
        return [
            'city' => $city,
        ];
    }
    public function create(CreateCityRequest $request){
        $data = $request->validated();
        $city = new City($data['city']);
        $city->save();
        Toast::info(__('City was saved.'));
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $data = $request->validated();
        $city->fill($data['city'])->save();
        Toast::info(__('City was updated.'));
    }

    public function remove(City $city): void
    {
        City::findOrFail($city->id)->delete();

        Toast::info(__('City was removed'));
    }
}
