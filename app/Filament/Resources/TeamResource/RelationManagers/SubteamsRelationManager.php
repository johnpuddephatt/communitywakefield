<?php

namespace App\Filament\Resources\TeamResource\RelationManagers;

use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\RelationManager;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class SubteamsRelationManager extends RelationManager
{
    public static $primaryColumn = 'name';

    public static $relationship = 'subteams';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('name'),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('name')->primary(),
            ])
            ->filters([
                //
            ]);
    }
}
