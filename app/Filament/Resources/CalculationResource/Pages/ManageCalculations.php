<?php
namespace App\Filament\Resources\CalculationResource\Pages;

use App\Filament\Resources\CalculationResource;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Gate;

class ManageCalculations extends ManageRecords
{
    protected static string $resource = CalculationResource::class;

    public function mount(): void
    {
        parent::mount();
        Gate::authorize('manage-calculations');
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}