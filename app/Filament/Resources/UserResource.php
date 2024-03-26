<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->required()
                ->email()
                ->maxLength(255),
            Forms\Components\TextInput::make('rfid')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('role')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('image')
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->sortable(),
            ImageColumn::make('image')
                ->disk('public'),
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
            Tables\Columns\TextColumn::make('rfid')
                ->label('RFID')
                ->searchable(),
            Tables\Columns\TextColumn::make('role')
                ->searchable()
                ->sortable()
                ->formatStateUsing(function ($record) {
                    $roleMapping = [
                        0 => 'Admin',
                        1 => 'Faculty',
                        2 => 'Staff',
                        3 => 'Student',
                    ];
            
                    // Access the role attribute of the record (row object)
                    $roleValue = $record->role;

                    // Return the corresponding label from the mapping, or a default value if not found
                    return array_key_exists($roleValue, $roleMapping) ? $roleMapping[$roleValue] : 'Unknown Role';
                })
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
