<?php

namespace App\Filament\Resources\TicketResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';
    protected static ?string $title = 'Messages';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('content')
                ->required()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('from')
                ->label('From')
                ->maxLength(255),

            Forms\Components\Repeater::make('attachments')
                ->relationship('attachments')
                ->schema([
                    Forms\Components\FileUpload::make('file')
                        ->disk('public') // اگر دیسک فرق داره عوضش کن
                        ->directory('tickets/attachments')
                        ->preserveFilenames()
                        ->required()
                        ->label('File'),

                    Forms\Components\TextInput::make('original_file_name')
                        ->label('Original name')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->columnSpanFull()
                ->label('Attachments'),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('from')->label('From')->sortable(),
                Tables\Columns\TextColumn::make('content')->limit(60)->wrap(),
                Tables\Columns\TextColumn::make('attachments_count')
                    ->counts('attachments')
                    ->label('Files')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Add message'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
