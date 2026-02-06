<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Buyurtma ma\'lumotlari')
                    ->description('Tarjima buyurtmasi haqida asosiy ma\'lumotlar')
                    ->icon('heroicon-o-document-text')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('work.title')
                            ->label('Asar nomi')
                            ->icon('heroicon-o-book-open')
                            ->iconColor('primary')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->copyMessage('Nomi nusxalandi')
                            ->copyMessageDuration(1500),

                        TextEntry::make('work_id')
                            ->label('Asl til')
                            ->icon('heroicon-o-globe-alt')
                            ->iconColor('success')
                            ->badge()
                            ->color('success')
                            ->formatStateUsing(function ($record) {
                                return $record->work?->originalLanguage?->lang_name ?? 'Noma\'lum';
                            }),

                        TextEntry::make('work_id')
                            ->label('Asar muallifi')
                            ->icon('heroicon-o-user-circle')
                            ->iconColor('info')
                            ->weight(FontWeight::SemiBold)
                            ->formatStateUsing(fn ($record) => $record->work?->author_name ?? 'Noma\'lum')
                            ->copyable(),

                        TextEntry::make('status')
                            ->label('Holat')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'accepted' => 'info',
                                'rejected' => 'danger',
                                'in_progress' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'gray',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'Kutilmoqda',
                                'accepted' => 'Qabul qilindi',
                                'rejected' => 'Rad etildi',
                                'in_progress' => 'Jarayonda',
                                'completed' => 'Yakunlandi',
                                'cancelled' => 'Bekor qilindi',
                                default => $state,
                            })
                            ->icon(fn (string $state): string => match ($state) {
                                'pending' => 'heroicon-o-clock',
                                'accepted' => 'heroicon-o-check-circle',
                                'rejected' => 'heroicon-o-x-circle',
                                'in_progress' => 'heroicon-o-arrow-path',
                                'completed' => 'heroicon-o-check-badge',
                                'cancelled' => 'heroicon-o-no-symbol',
                                default => 'heroicon-o-question-mark-circle',
                            }),
                    ]),

                Section::make('Ishtirokchilar')
                    ->description('Buyurtma ishtirokchilari ma\'lumotlari')
                    ->icon('heroicon-o-users')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Mijoz')
                            ->icon('heroicon-o-user')
                            ->iconColor('success')
                            ->weight(FontWeight::SemiBold)
                            ->placeholder('Aniqlanmagan'),

                        TextEntry::make('user.email')
                            ->label('Mijoz email')
                            ->icon('heroicon-o-envelope')
                            ->iconColor('gray')
                            ->copyable()
                            ->placeholder('Email yo\'q'),

                        TextEntry::make('user.phone_number')
                            ->label('Mijoz telefon raqam')
                            ->icon('heroicon-o-phone')
                            ->iconColor('green')
                            ->copyable()
                            ->formatStateUsing(fn (?string $state): string => $state ? '+998 ' . $state : 'Telefon raqami yo\'q')
                            ->placeholder('Telefon raqami yo\'q'),

                        TextEntry::make('translator.user.name')
                            ->label('Tarjimon')
                            ->icon('heroicon-o-academic-cap')
                            ->iconColor('primary')
                            ->weight(FontWeight::SemiBold)
                            ->placeholder('Tayinlanmagan'),

                        TextEntry::make('translator.user.email')
                            ->label('Tarjimon email')
                            ->icon('heroicon-o-envelope')
                            ->iconColor('gray')
                            ->copyable()
                            ->placeholder('Email yo\'q'),

                        TextEntry::make('translator.user.phone_number')
                            ->label('Tarjimon telefon raqam')
                            ->icon('heroicon-o-phone')
                            ->iconColor('blue')
                            ->copyable()
                            ->formatStateUsing(fn (?string $state): string => $state ? '+998 ' . $state : 'Telefon raqami yo\'q')
                            ->placeholder('Telefon raqami yo\'q'),
                    ]),

                Section::make('Texnik ma\'lumotlar')
                    ->description('Til va muddatlar haqida ma\'lumot')
                    ->icon('heroicon-o-cog')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextEntry::make('language.lang_name')
                            ->label('Tarjima so\'ralgan tili')
                            ->icon('heroicon-o-language')
                            ->iconColor('info')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('deadline')
                            ->label('Tugash muddati')
                            ->icon('heroicon-o-calendar')
                            ->iconColor('danger')
                            ->dateTime('d M Y, H:i')
                            ->badge()
                            ->color(fn ($state) => $state && now()->gt($state) ? 'danger' : 'warning'),

                        TextEntry::make('created_at')
                            ->label('Yaratilgan')
                            ->icon('heroicon-o-calendar-days')
                            ->dateTime('d M Y, H:i')
                            ->since()
                            ->tooltip(fn ($state) => $state?->format('d M Y, H:i:s'))
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label('Yangilangan')
                            ->icon('heroicon-o-arrow-path')
                            ->dateTime('d M Y, H:i')
                            ->since()
                            ->tooltip(fn ($state) => $state?->format('d M Y, H:i:s'))
                            ->placeholder('-'),
                    ])
            ]);
    }
}
