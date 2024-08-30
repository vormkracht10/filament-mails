<?php

namespace Vormkracht10\FilamentMails\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Vormkracht10\FilamentMails\Resources\MailResource\Pages\ListMails;
use Vormkracht10\Mails\Models\Mail;

class MailResource extends Resource
{
    protected static ?string $model = Mail::class;

    protected static ?string $slug = 'mails';

    protected static ?string $recordTitleAttribute = 'subject';

    protected static bool $isScopedToTenant = false;

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

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMails::route('/'),
        ];
    }
}
