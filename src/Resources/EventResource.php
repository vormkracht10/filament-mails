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
use Vormkracht10\Mails\Enums\WebhookEventType;
use Vormkracht10\Mails\Models\MailEvent;

class EventResource extends Resource
{
    protected static ?string $model = MailEvent::class;

    protected static ?string $slug = 'mails/events';

    protected static ?string $recordTitleAttribute = 'subject';

    protected static bool $isScopedToTenant = false;

    protected static bool $shouldRegisterNavigation = true;

    public static function getNavigationParentItem(): ?string
    {
        return __('Mails');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Mails');
    }

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
                                    ->label(__('Mail')),
                                TextEntry::make('occurred_at')
                                    ->since()
                                    ->dateTimeTooltip('d-m-Y H:i')
                                    ->label(__('Occurred At')),
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
                    ->collapsible()
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
                                TextEntry::make('payload')
                                    ->label(__('Payload'))
                                    ->formatStateUsing(function ($state) {
                                        return json_encode($state, JSON_PRETTY_PRINT);
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
            ->recordAction(null)
            ->defaultSort('created_at', 'desc')
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
                Tables\Columns\TextColumn::make('mail.subject')
                    ->url(fn (MailEvent $record) => route('filament.admin.resources.mails.view', $record->mail))
                    ->label(__('Subject'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('occurred_at')
                    ->label(__('Occurred At'))
                    ->dateTime('d-m-Y H:i')
                    ->since()
                    ->tooltip(fn (MailEvent $record) => $record->occurred_at?->format('d-m-Y H:i'))
                    ->sortable()
                    ->searchable(),
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
