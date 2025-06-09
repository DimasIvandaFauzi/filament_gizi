<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->hiddenOn('edit'),
                Forms\Components\Toggle::make('is_admin')
                    ->required(),
                Forms\Components\FileUpload::make('profile_photo')
                    ->image()
                    ->disk('public')
                    ->directory('profile_photos')
                    ->hiddenOn('create') // Opsional: Sembunyikan saat membuat user baru
                    ->hiddenOn('edit')  // Opsional: Sembunyikan saat edit jika tidak ingin diubah
                    ->label('Profile Photo')
                    ->required(false) // Tidak wajib jika user tidak harus mengunggah foto
                    ->previewable(true) // Tampilkan preview saat memilih file
                    ->imageResizeTargetWidth('300') // Sesuaikan ukuran gambar
                    ->imageResizeTargetHeight('300'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo')
                    ->disk('public') // Tentukan disk tempat file disimpan
                    ->defaultImageUrl(asset('images/default-avatar.png')) // Gambar default jika tidak ada foto
                    ->label('Photo')
                    ->circular() // Opsional: Membuat gambar menjadi bulat
                    ->size(50) // Ukuran gambar dalam piksel
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('is_admin'),
                Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ManageUsers::route('/'),
        ];
    }

    // Override method untuk menyimpan path relatif ke model
    public static function getModel(): string
    {
        return User::class;
    }
}