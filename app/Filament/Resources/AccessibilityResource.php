<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccessibilityResource\Pages;
use App\Filament\Resources\AccessibilityResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class AccessibilityResource extends Resource
{
    public static $icon = 'heroicon-o-eye';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('title'),
                Components\TextInput::make('slug'),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('title')->primary(),
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
            Pages\ListAccessibilities::routeTo('/', 'index'),
            Pages\CreateAccessibility::routeTo('/create', 'create'),
            Pages\EditAccessibility::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
