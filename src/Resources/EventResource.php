<?php

namespace Vormkracht10\FilamentMails\Resources;

use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Vormkracht10\FilamentMails\Resources\EventResource\Pages\ListEvents;
use Vormkracht10\FilamentMails\Resources\EventResource\Pages\ViewEvent;
use Vormkracht10\Mails\Enums\EventType;
use Vormkracht10\Mails\Models\MailEvent;

class EventResource extends Resource
{
    protected static ?string $model = MailEvent::class;

    protected static ?string $slug = 'mails/events';

    protected static bool $isScopedToTenant = false;

    protected static bool $shouldRegisterNavigation = true;

    public function getTitle(): string
    {
        return __('Events');
    }

    public static function getNavigationParentItem(): ?string
    {
        return __('Emails');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Emails');
    }

    public static function getNavigationLabel(): string
    {
        return __('Events');
    }

    public static function getLabel(): ?string
    {
        return __('Event');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Events');
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-calendar';
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make(__('Event Details'))
                    ->icon('heroicon-o-information-circle')
                    ->compact()
                    ->collapsible()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('type')
                                    ->label(__('Type'))
                                    ->badge()
                                    ->color(fn (EventType $state): string => match ($state) {
                                        EventType::DELIVERED => 'success',
                                        EventType::CLICKED => 'clicked',
                                        EventType::OPENED => 'info',
                                        EventType::SOFT_BOUNCED => 'danger',
                                        EventType::HARD_BOUNCED => 'danger',
                                        EventType::COMPLAINED => 'warning',
                                        EventType::UNSUBSCRIBED => 'danger',
                                        EventType::ACCEPTED => 'success',
                                    })
                                    ->formatStateUsing(function (EventType $state) {
                                        return ucwords(str_replace('_', ' ', $state->value));
                                    }),
                                TextEntry::make('mail.subject')
                                    ->label(__('Mail')),
                                TextEntry::make('occurred_at')
                                    ->since()
                                    ->dateTimeTooltip('d-m-Y H:i')
                                    ->label(__('Occurred At')),
                            ]),

                    ]),
                Section::make(__('User Information'))
                    ->icon('heroicon-o-user-circle')
                    ->compact()
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
                    ->compact()
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
                    ->compact()
                    ->collapsible()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('link')
                                    ->default(__('Unknown'))
                                    ->label(__('Link'))
                                    ->limit(50)
                                    ->url(fn ($state) => $state)
                                    ->openUrlInNewTab(),
                                TextEntry::make('tag')
                                    ->default(__('Unknown'))
                                    ->label(__('Tag')),
                                TextEntry::make('payload')
                                    ->label(__('Payload'))
                                    ->formatStateUsing(function ($state) {
                                        return json_encode($state, JSON_PRETTY_PRINT);
                                    })
                                    ->columnSpanFull()
                                    ->copyable()
                                    ->copyMessage(__('Copied'))
                                    ->copyMessageDuration(1500),
                                TextEntry::make('payload')
                                    ->label(__('Metadata'))
                                    ->formatStateUsing(function ($state) {
                                        if (
                                            ! is_object($state) || ! property_exists($state, 'Metadata') || empty($state->Metadata)
                                        ) {
                                            return __('No metadata available');
                                        }

                                        $metadata = (array) json_decode(json_encode($state->Metadata), true);
                                        unset($metadata[config('mails.headers.uuid')]);

                                        return json_encode($metadata, JSON_PRETTY_PRINT);
                                    })
                                    ->columnSpanFull()
                                    ->copyable()
                                    ->copyMessage(__('Copied'))
                                    ->copyMessageDuration(1500),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction('view')
            ->recordUrl(null)
            ->defaultSort('occurred_at', 'desc')
            ->paginated([50, 100, 'all'])
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->sortable()
                    ->badge()
                    ->color(fn (EventType $state): string => match ($state) {
                        EventType::DELIVERED => 'success',
                        EventType::CLICKED => 'clicked',
                        EventType::OPENED => 'info',
                        EventType::SOFT_BOUNCED => 'danger',
                        EventType::HARD_BOUNCED => 'danger',
                        EventType::COMPLAINED => 'warning',
                        EventType::UNSUBSCRIBED => 'danger',
                        EventType::ACCEPTED => 'success',
                    })
                    ->formatStateUsing(function (EventType $state) {
                        return ucwords(str_replace('_', ' ', $state->value));
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail.subject')
                    ->label(__('Subject'))
                    ->searchable(['subject', 'payload']),
                Tables\Columns\TextColumn::make('occurred_at')
                    ->label(__('Occurred At'))
                    ->dateTime('d-m-Y H:i')
                    ->since()
                    ->tooltip(fn (MailEvent $record) => $record->occurred_at->format('d-m-Y H:i'))
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(null)
                    ->modal()
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
            'view' => ViewEvent::route('/{record}/view'),
        ];
    }
}
