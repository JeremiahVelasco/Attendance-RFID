<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentsResource\Pages;
use App\Filament\Resources\StudentsResource\RelationManagers;
use App\Models\Students;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $modelLabel = 'Student';

    protected static ?int $navigationSort = 1;

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
        // TODO : Should only return the Users with the role of STUDENT
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->sortable(),
            Tables\Columns\ImageColumn::make('image')
                ->width(200)
                ->height(50),
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
                }),
            Tables\Columns\TextColumn::make('attendance')
                ->sortable(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudents::route('/create'),
            'edit' => Pages\EditStudents::route('/{record}/edit'),
        ];
    }
}
