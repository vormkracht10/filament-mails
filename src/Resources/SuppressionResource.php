<?php

namespace Vormkracht10\FilamentMails\Resources;

use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages\ListSuppressions;
use Vormkracht10\Mails\Enums\EventType;
use Vormkracht10\Mails\Models\MailEvent;

class SuppressionResource extends Resource
{
    protected static ?string $model = MailEvent::class;

    protected static ?string $slug = 'mails/suppressions';

    protected static bool $isScopedToTenant = false;

    protected static bool $shouldRegisterNavigation = true;

    public function getTitle(): string
    {
        return __('Suppressions');
    }

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
        return __('Suppressions');
    }

    public static function getLabel(): ?string
    {
        return __('Suppression');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Suppressions');
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-no-symbol';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', EventType::HARD_BOUNCED)
            ->where(function ($query) {
                $query->whereNull('unsuppressed_at')
                    ->orWhere('unsuppressed_at', '');
            })
            ->latest('occurred_at')
            ->orderBy('occurred_at', 'desc')
            ->latest('occurred_at')
            ->orderBy('occurred_at', 'desc');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('occurred_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('mail.to')
                    ->label(__('Email address'))
                    ->formatStateUsing(fn (MailEvent $record) => key($record->mail->to))
                    ->searchable(['to']),

                Tables\Columns\TextColumn::make('occurred_at')
                    ->badge()
                    ->label(__('Suppressed At'))
                    ->dateTime('d-m-Y H:i')
                    ->since()
                    ->tooltip(fn (MailEvent $record) => $record->occurred_at->format('d-m-Y H:i'))
                    ->sortable()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make('unsupress')
                    ->action(fn (MailEvent $record) => $record->unSuppress()),

                Tables\Actions\ViewAction::make()
                    ->url(null)
                    ->modal()
                    ->slideOver()
                    ->label(__('View'))
                    ->hiddenLabel()
                    ->tooltip(__('View'))
                    ->infolist(fn (Infolist $infolist) => EventResource::infolist($infolist)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSuppressions::route('/'),
        ];
    }
}
