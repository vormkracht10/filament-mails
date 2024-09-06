<?php

namespace Vormkracht10\FilamentMails\Resources;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Tabs;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs\Tab;
use Vormkracht10\FilamentMails\Models\Mail;
use Filament\Infolists\Components\TextEntry;
use Vormkracht10\Mails\Enums\WebhookEventType;
use Filament\Infolists\Components\RepeatableEntry;
use Vormkracht10\FilamentMails\Resources\MailResource\Pages\ListMails;

class MailResource extends Resource
{
    protected static ?string $model = Mail::class;

    protected static ?string $slug = 'mails';

    protected static ?string $recordTitleAttribute = 'subject';

    protected static bool $isScopedToTenant = false;

    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationLabel(): string
    {
        return __('Mails');
    }

    public static function getLabel(): ?string
    {
        return __('Mail');
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-envelope';
    }

    public function getTitle(): string
    {
        return __('Mails');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('General')
                    ->icon('heroicon-o-envelope')
                    ->collapsible()
                    ->schema([
                        Tabs::make('')
                            ->schema([
                                Tab::make(__('Sender Information'))
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextEntry::make('subject')
                                                    ->columnSpanFull()
                                                    ->label(__('Subject')),
                                                TextEntry::make('from')
                                                    ->label(__('From'))
                                                    ->formatStateUsing(fn($state) => self::formatEmailAddress($state)),
                                                TextEntry::make('to')
                                                    ->label(__('Recipient'))
                                                    ->formatStateUsing(fn($state) => self::formatEmailAddress($state)),
                                                TextEntry::make('cc')
                                                    ->label(__('CC'))
                                                    ->default('-')
                                                    ->formatStateUsing(fn($state) => self::formatEmailAddress($state)),
                                                TextEntry::make('bcc')
                                                    ->label(__('BCC'))
                                                    ->default('-')
                                                    ->formatStateUsing(fn($state) => self::formatEmailAddress($state)),
                                                TextEntry::make('reply_to')
                                                    ->default('-')
                                                    ->label(__('Reply To'))
                                                    ->formatStateUsing(fn($state) => self::formatEmailAddress($state)),
                                            ]),
                                    ]),
                                Tab::make(__('Statistics'))
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextEntry::make('opens')
                                                    ->label(__('Opens')),
                                                TextEntry::make('clicks')
                                                    ->label(__('Clicks')),
                                                TextEntry::make('sent_at')
                                                    ->label(__('Sent At'))
                                                    ->since()
                                                    ->dateTimeTooltip('d-m-Y H:i'),
                                                TextEntry::make('resent_at')
                                                    ->since()
                                                    ->dateTimeTooltip('d-m-Y H:i')
                                                    ->label(__('Resent At')),
                                                TextEntry::make('delivered_at')
                                                    ->label(__('Delivered At'))
                                                    ->since()
                                                    ->dateTimeTooltip('d-m-Y H:i'),
                                                TextEntry::make('last_opened_at')
                                                    ->label(__('Last Opened At'))
                                                    ->since()
                                                    ->dateTimeTooltip('d-m-Y H:i'),
                                                TextEntry::make('last_clicked_at')
                                                    ->label(__('Last Clicked At'))
                                                    ->since()
                                                    ->dateTimeTooltip('d-m-Y H:i'),
                                                TextEntry::make('complained_at')
                                                    ->label(__('Complained At'))
                                                    ->since()
                                                    ->dateTimeTooltip('d-m-Y H:i'),
                                                TextEntry::make('soft_bounced_at')
                                                    ->label(__('Soft Bounced At'))
                                                    ->since()
                                                    ->dateTimeTooltip('d-m-Y H:i'),
                                                TextEntry::make('hard_bounced_at')
                                                    ->label(__('Hard Bounced At'))
                                                    ->since()
                                                    ->dateTimeTooltip('d-m-Y H:i'),
                                            ]),
                                    ]),
                                Tab::make(__('Events'))
                                    ->schema([
                                        RepeatableEntry::make('events')
                                            ->hiddenLabel()
                                            ->schema([
                                                TextEntry::make('type')
                                                    ->label(__('Type'))
                                                    ->badge()
                                                    ->color(fn(WebhookEventType $state): string => match ($state) {
                                                        WebhookEventType::DELIVERY => 'success',
                                                        WebhookEventType::CLICK => 'info',
                                                        WebhookEventType::OPEN => 'success',
                                                        WebhookEventType::BOUNCE => 'danger',
                                                        WebhookEventType::COMPLAINT => 'danger',
                                                        default => 'gray',
                                                    }),
                                                TextEntry::make('occurred_at')
                                                    ->since()
                                                    ->dateTimeTooltip('d-m-Y H:i')
                                                    ->label(__('Occurred At')),
                                            ])
                                            ->columns(2)
                                    ]),
                            ])

                    ]),
                Section::make('Content')
                    ->icon('heroicon-o-document')
                    ->collapsible()
                    ->schema([
                        Tabs::make('Content')
                            ->label(__('Content'))
                            ->columnSpanFull()
                            ->tabs([
                                Tab::make('Preview')
                                    ->schema([
                                        TextEntry::make('html')
                                            ->hiddenLabel()
                                            ->label(__('HTML Content'))
                                            ->html()
                                            ->columnSpanFull(),
                                    ])->columnSpanFull(),
                                Tab::make('HTML')
                                    ->schema([
                                        TextEntry::make('html')
                                            ->hiddenLabel()
                                            ->copyable()
                                            ->copyMessage('Copied!')
                                            ->copyMessageDuration(1500)
                                            ->label(__('HTML Content'))
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Text')
                                    ->schema([
                                        TextEntry::make('text')
                                            ->hiddenLabel()
                                            ->copyable()
                                            ->copyMessage('Copied!')
                                            ->copyMessageDuration(1500)
                                            ->label(__('Text Content'))
                                            ->columnSpanFull(),
                                    ]),
                            ])->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Hard Bounced' => 'danger',
                        'Soft Bounced' => 'warning',
                        'Complained' => 'danger',
                        'Clicked' => 'clicked',
                        'Opened' => 'success',
                        'Delivered' => 'success',
                        'Sent' => 'info',
                        'Resent' => 'info',
                        'Pending' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('subject')
                    ->label(__('Subject'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('to')
                    ->label(__('Recipient'))
                    ->formatStateUsing(fn($state) => self::formatEmailAddressForTable($state))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('opens')
                    ->label(__('Opens'))
                    ->tooltip(fn(Mail $record) => __('Last opened at :date', ['date' => $record->last_opened_at?->format('d-m-Y H:i')]))
                    ->sortable(),
                Tables\Columns\TextColumn::make('clicks')
                    ->label(__('Clicks'))
                    ->tooltip(fn(Mail $record) => __('Last clicked at :date', ['date' => $record->last_clicked_at?->format('d-m-Y H:i')]))
                    ->sortable(),
                Tables\Columns\TextColumn::make('sent_at')
                    ->label(__('Sent At'))
                    ->dateTime('d-m-Y H:i')
                    ->since()
                    ->tooltip(fn(Mail $record) => $record->sent_at?->format('d-m-Y H:i'))
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
            'index' => ListMails::route('/'),
        ];
    }

    private static function formatEmailAddress($state): string
    {
        if (empty($state)) {
            return '-';
        }

        $data = json_decode($state, true);

        if (! is_array($data)) {
            return (string) $state; // Return the original state if it's not valid JSON
        }

        return implode(', ', array_map(function ($email, $name) {
            return $name === null ? $email : "$name <$email>";
        }, array_keys($data), $data));
    }

    private static function formatEmailAddressForTable($state): string
    {
        if (empty($state)) {
            return '-';
        }

        $data = json_decode($state, true);

        if (! is_array($data)) {
            return (string) $state;
        }

        return implode(', ', array_keys($data));
    }
}