<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Filament\Resources\LocationResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class LocationResource extends Resource
{
    public static $icon = "heroicon-o-collection";

    public static function form(Form $form)
    {
        return $form->schema([
            Components\TextInput::make("name"),
            Components\Textarea::make("icon"),
            Components\TextInput::make("radius"),
            Components\TextInput::make("latitude"),
            Components\TextInput::make("longitude"),
        ]);
    }

    public static function table(Table $table)
    {
        return $table->columns([Columns\Text::make("title")->primary()])->filters([
            //
        ]);
    }

    public static function relations()
    {
        return [
                //
            ];
    }

    public static function routes()
    {
        return [
            Pages\ListLocations::routeTo("/", "index"),
            Pages\CreateLocation::routeTo("/create", "create"),
            Pages\EditLocation::routeTo("/{record}/edit", "edit"),
        ];
    }
}
