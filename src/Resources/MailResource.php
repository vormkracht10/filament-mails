<?php

namespace Vormkracht10\FilamentMails\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Tabs;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs\Tab;
use Vormkracht10\FilamentMails\Models\Mail;
use Filament\Infolists\Components\TextEntry;
use Vormkracht10\FilamentMails\Resources\MailResource\Pages\ListMails;

class MailResource extends Resource
{
    protected static ?string $model = Mail::class;

    protected static ?string $slug = 'mails';

    protected static ?string $recordTitleAttribute = 'subject';

    protected static bool $isScopedToTenant  = false;

    public static function getNavigationLabel(): string
    {
        return __('Mails');
    }

    public static function getLabel(): ?string
    {
        return __('Mail');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Mails');
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-envelope';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
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
                    ->collapsible()
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
                                    ]),
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
                    ->columnSpanFull(), // Add this line
                Section::make('Statistics')
                    ->collapsible()
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('opens')
                                    ->label(__('Opens')),
                                TextEntry::make('clicks')
                                    ->label(__('Clicks')),
                                TextEntry::make('sent_at')
                                    ->label(__('Sent At'))
                                    ->dateTime('d-m-Y H:i'),
                                TextEntry::make('resent_at')
                                    ->label(__('Resent At'))
                                    ->dateTime('d-m-Y H:i'),
                                TextEntry::make('delivered_at')
                                    ->label(__('Delivered At'))
                                    ->dateTime('d-m-Y H:i'),
                                TextEntry::make('last_opened_at')
                                    ->label(__('Last Opened At'))
                                    ->dateTime('d-m-Y H:i'),
                                TextEntry::make('last_clicked_at')
                                    ->label(__('Last Clicked At'))
                                    ->dateTime('d-m-Y H:i'),
                                TextEntry::make('complained_at')
                                    ->label(__('Complained At'))
                                    ->dateTime('d-m-Y H:i'),
                                TextEntry::make('soft_bounced_at')
                                    ->label(__('Soft Bounced At'))
                                    ->dateTime('d-m-Y H:i'),
                                TextEntry::make('hard_bounced_at')
                                    ->label(__('Hard Bounced At'))
                                    ->dateTime('d-m-Y H:i'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->recordAction('view')
            // ->recordUrl(null)
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
                        'Clicked' => 'success',
                        'Opened' => 'success',
                        'Delivered' => 'success',
                        'Sent' => 'info',
                        'Resent' => 'info',
                        'Pending' => 'gray',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label(__('Subject'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('to')
                    ->label(__('Recipient'))
                    ->formatStateUsing(fn($state) => self::formatEmailAddress($state))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sent_at')
                    ->label(__('Sent At'))
                    ->dateTime('d-m-Y H:i')
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

        if (!is_array($data)) {
            return (string) $state; // Return the original state if it's not valid JSON
        }

        return implode(', ', array_map(function ($email, $name) {
            return $name === null ? $email : "$name <$email>";
        }, array_keys($data), $data));
    }
}