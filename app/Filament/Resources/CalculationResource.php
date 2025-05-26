<?php
namespace App\Filament\Resources;

use App\Filament\Resources\CalculationResource\Pages;
use App\Models\Calculation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CalculationResource extends Resource
{
    protected static ?string $model = Calculation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('gender')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('age')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(120)
                    ->suffix('tahun'),
                Forms\Components\TextInput::make('weight')
                    ->required()
                    ->numeric()
                    ->minValue(20)
                    ->maxValue(200)
                    ->suffix('kg'),
                Forms\Components\TextInput::make('height')
                    ->required()
                    ->numeric()
                    ->minValue(100)
                    ->maxValue(220)
                    ->suffix('cm'),
                Forms\Components\Select::make('activity')
                    ->options([
                        'Rendah' => 'Rendah',
                        'Sedang' => 'Sedang',
                        'Tinggi' => 'Tinggi',
                    ])
                    ->required(),
                Forms\Components\Select::make('goal')
                    ->options([
                        'Menurunkan Berat Badan' => 'Menurunkan Berat Badan',
                        'Menjaga Berat Badan' => 'Menjaga Berat Badan',
                        'Meningkatkan Berat Badan' => 'Meningkatkan Berat Badan',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('bmi')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Forms\Components\TextInput::make('status_bmi')
                    ->required(),
                Forms\Components\Textarea::make('macronutrient_needs')
                    ->json()
                    ->helperText('Masukkan data makronutrien dalam format JSON, misalnya: {"protein": 50, "carbs": 200, "fat": 30}'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('Umur')
                    ->suffix(' tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('weight')
                    ->label('Berat Badan')
                    ->suffix(' kg')
                    ->sortable(),
                Tables\Columns\TextColumn::make('height')
                    ->label('Tinggi Badan')
                    ->suffix(' cm')
                    ->sortable(),
                Tables\Columns\TextColumn::make('activity')
                    ->label('Aktivitas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('goal')
                    ->label('Tujuan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bmi')
                    ->label('BMI')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_bmi')
                    ->label('Status BMI')
                    ->sortable(),
                Tables\Columns\TextColumn::make('macronutrient_needs')
                    ->label('Kebutuhan Makronutrien')
                    ->formatStateUsing(fn ($state) => json_encode($state, JSON_PRETTY_PRINT))
                    ->html(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCalculations::route('/'),
        ];
    }
}