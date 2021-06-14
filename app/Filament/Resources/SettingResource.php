<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class SettingResource extends Resource
{
    public static $icon = 'heroicon-o-collection';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('name'),
                Components\TextInput::make('slug'),
                Components\TextInput::make('email'),
                Components\KeyValue::make('primary_navigation')
                    ->keyLabel('Label')
                    ->keyPlaceholder('The text label that will appear')
                    ->sortable(true)
                    ->valueLabel('URL')
                    ->valuePlaceholder('The URL for this link'),
                Components\KeyValue::make('footer_navigation')
                    ->keyLabel('Label')
                    ->keyPlaceholder('The text label that will appear')
                    ->sortable(true)
                    ->valueLabel('URL')
                    ->valuePlaceholder('The URL for this link')
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

    public static function relations()
    {
        return [
            //
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListSettings::routeTo('/', 'index'),
            Pages\CreateSetting::routeTo('/create', 'create'),
            Pages\EditSetting::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
