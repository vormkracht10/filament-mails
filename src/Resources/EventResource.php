<?php

namespace Vormkracht10\FilamentMails\Resources;

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
            ->schema([]);
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
                    ->color(fn(WebhookEventType $state): string => match ($state) {
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