<?php

namespace Vormkracht10\FilamentMails\Resources;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages\ListSuppressions;
use Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages\ViewSuppression;
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

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction('view')
            ->recordUrl(null)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('mail.to')
                    ->label(__('Email address'))
                    ->formatStateUsing(fn (MailEvent $record) => key($record->mail->to))
                    ->searchable(['to']),
                Tables\Columns\TextColumn::make('occurred_at')
                    ->label(__('Suppressed At'))
                    ->dateTime('d-m-Y H:i')
                    ->since()
                    ->tooltip(fn (MailEvent $record) => $record->occurred_at->format('d-m-Y H:i'))
                    ->sortable()
                    ->searchable(),
            ])
            ->modifyQueryUsing(fn ($query) => $query->where('type', EventType::HARD_BOUNCED))
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
            'index' => ListSuppressions::route('/'),
            'view' => ViewSuppression::route('/{record}/view'),
        ];
    }
}
