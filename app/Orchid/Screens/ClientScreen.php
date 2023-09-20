<?php

namespace App\Orchid\Screens;

use App\Exports\ClientsExport;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Imports\ClientsImport;
use App\Models\City;
use App\Models\Client;

use App\Orchid\Layouts\Client\{ClientCityLayout, ClientFiltersLayout, ClientListLayout};
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ClientScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'clients' => Client::With('city')->filters(ClientFiltersLayout::class)->latest()->simplePaginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Clients';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {

        return [
            ModalToggle::make(__('Add Client'))
                ->modal('clientModal')
                ->method('create')
                ->icon('plus'),
            ModalToggle::make(__('Import Clients'))
                ->modal('importClientsModal')
                ->method('uploadFile')
                ->icon('cloud-upload'),
            Button::make(__('Export Clients'))
                ->method('downloadFile')
                ->icon('cloud-download'),


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
            ClientFiltersLayout::class,
            ClientListLayout::class,

            Layout::modal('clientModal', ClientCityLayout::class)
                ->title(__('Create Client'))
                ->applyButton('Save Client')
                ->async('asyncGetClient'),

            Layout::modal('importClientsModal', Layout::rows([
                Input::make(__('upload'))
                    ->type('file')
                    ->title(__('clients')),
            ]))
                ->title(__('Upload Clients'))
                ->applyButton('Save Clients'),
        ];
    }

    public function asyncGetClient(Client $client, City $city): iterable
    {
        return [
            'client' => $client,

        ];
    }

    public function create(CreateClientRequest $request){

        $data = $request->validated();
        $client = new Client($data['client']);
        $client->save();
        Toast::info(__('Client was saved.'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $data = $request->validated();
        $client->fill($data['client'])->save();
        Toast::info(__('client was updated.'));
    }

    public function remove(Client $client): void
    {
        Client::findOrFail($client->id)->delete();

        Toast::info(__('client was removed'));
    }

    public function uploadFile(Request $request){
        Toast::info(__('Loading...'));

        Excel::queueImport(new ClientsImport, $request->file('upload')->getPathname())->chain([
            fn() => Toast::success(__('File succesfully imported!'))
        ])->onQueue('imports');

    }

    public function downloadFile(){
        Excel::queue(new ClientsExport, 'clients.xlsx')->chain([
            fn() => Toast::success(__('Downloading!'))
        ])->onQueue('exports');



    }
}
