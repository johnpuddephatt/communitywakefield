<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class TeamResource extends Resource
{
    public static $icon = 'heroicon-o-user-group';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('name'),
                Components\TextInput::make('email'),
                Components\TextInput::make('created_at')->disabled(true),
                Components\FileUpload::make('logo')
                    ->avatar() // Make the field suitable for uploading and displaying a circular avatar.
                    ->image() // Allow only images to be uploaded.
                    ->imageCropAspectRatio('1:1') // Crop images to this certain aspect ratio when they are uploaded, e.g: '1:1'.
                    ->panelAspectRatio('1:1') // Set the aspect ratio of the panel, e.g: '1:1'.
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([

                Columns\Image::make('logo')->rounded()->label(''),
                Columns\Text::make('name')->primary(),
                Columns\Text::make('created_at'),

                //
            ])
            ->filters([
                //
            ]);
    }

    public static function relations()
    {
        return [
            RelationManagers\SubteamsRelationManager::class,
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListTeams::routeTo('/', 'index'),
            Pages\CreateTeam::routeTo('/create', 'create'),
            Pages\EditTeam::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
