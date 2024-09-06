<?php

namespace Vormkracht10\FilamentMails\Resources;

use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Vormkracht10\FilamentMails\Resources\EventResource\Pages\ListEvents;
use Vormkracht10\Mails\Enums\WebhookEventType;
use Vormkracht10\Mails\Models\MailEvent;

class EventResource extends Resource
{
    protected static ?string $model = MailEvent::class;

    protected static ?string $slug = 'events';

    protected static ?string $recordTitleAttribute = 'subject';

    protected static bool $isScopedToTenant = false;

    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationLabel(): string
    {
        return __('Events');
    }

    public static function getLabel(): ?string
    {
        return __('Events');
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-calendar';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return __('Events');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make(__('Event Details'))
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('type')
                                    ->label(__('Type'))
                                    ->badge()
                                    ->color(fn (WebhookEventType $state): string => match ($state) {
                                        WebhookEventType::DELIVERY => 'success',
                                        WebhookEventType::CLICK => 'info',
                                        WebhookEventType::OPEN => 'success',
                                        WebhookEventType::BOUNCE => 'danger',
                                        WebhookEventType::COMPLAINT => 'danger',
                                        default => 'gray',
                                    }),
                                TextEntry::make('mail.subject')
                                    ->label(__('Mail Subject')),
                                TextEntry::make('occurred_at')
                                    ->label(__('Occurred At'))
                                    ->dateTime(),
                            ]),

                    ]),
                Section::make(__('User Information'))
                    ->icon('heroicon-o-user-circle')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('ip_address')
                                    ->default(__('Unknown'))
                                    ->label(__('IP Address')),
                                TextEntry::make('hostname')
                                    ->default(__('Unknown'))
                                    ->label(__('Hostname')),
                                TextEntry::make('platform')
                                    ->default(__('Unknown'))
                                    ->label(__('Platform')),
                                TextEntry::make('os')
                                    ->default(__('Unknown'))
                                    ->label(__('Operating System')),
                                TextEntry::make('browser')
                                    ->default(__('Unknown'))
                                    ->label(__('Browser')),
                                TextEntry::make('user_agent')
                                    ->default(__('Unknown'))
                                    ->label(__('User Agent'))
                                    ->limit(50)
                                    ->tooltip(fn ($state) => $state),
                            ]),
                    ]),
                Section::make(__('Location'))
                    ->icon('heroicon-o-map-pin')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('city')
                                    ->default(__('Unknown'))
                                    ->label(__('City')),
                                TextEntry::make('country_code')
                                    ->default(__('Unknown'))
                                    ->label(__('Country Code')),
                            ]),
                    ]),
                Section::make(__('Additional Information'))
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('link')
                                    ->default(__('Unknown'))
                                    ->label(__('Link'))
                                    ->url(fn ($state) => $state)
                                    ->openUrlInNewTab(),
                                TextEntry::make('tag')
                                    ->default(__('Unknown'))
                                    ->label(__('Tag')),
                                // KeyValueEntry::make('payload')
                                //     ->label(__('Payload')),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            // ->defaultGroup('mail_id')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->sortable()
                    ->badge()
                    ->color(fn (WebhookEventType $state): string => match ($state) {
                        WebhookEventType::DELIVERY => 'success',
                        WebhookEventType::CLICK => 'clicked',
                        WebhookEventType::OPEN => 'success',
                        WebhookEventType::BOUNCE => 'danger',
                        WebhookEventType::COMPLAINT => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(function (WebhookEventType $state) {
                        return ucfirst($state->value);
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail_id')
                    ->label(__('Mail ID'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail.subject')
                    ->label(__('Subject'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('occurred_at')
                    ->label(__('Occured At'))
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->slideOver()
                    ->label(__('View'))
                    ->hiddenLabel()
                    ->tooltip(__('View')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
        ];
    }
}