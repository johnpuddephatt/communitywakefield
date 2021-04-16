<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuitabilityResource\Pages;
use App\Filament\Resources\SuitabilityResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class SuitabilityResource extends Resource
{
    public static $icon = 'heroicon-o-emoji-happy';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('title'),
                Components\TextInput::make('slug'),
                Components\Select::make('type')->options(['activity' => 'Activity', 'course' => 'Courses and education', 'event' => 'Events', 'service' => 'Services', 'volunteering' => 'Volunteering opportunities']) // Set the key-value array of available options to pick from.
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('title')->primary(),
                Columns\Text::make('type')->primary(),
            ])
            ->filters([
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
            Pages\ListSuitabilities::routeTo('/', 'index'),
            Pages\CreateSuitability::routeTo('/create', 'create'),
            Pages\EditSuitability::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
