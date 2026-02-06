<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Schemas\Schema;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPhoneFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function getNameFormComponent(): TextInput
    {
        return TextInput::make('name')
            ->label('IFSH')
            ->required()
            ->maxLength(255)
            ->autofocus();
    }


    protected function getPhoneFormComponent(): TextInput
    {
        return TextInput::make('phone_number')
            ->label('Telefon raqami')
            ->prefix('+998')
            ->placeholder('90 123 45 67')
            ->mask('99 999 99 99')
            ->tel()
            ->required()
            ->maxLength(12)
            ->minLength(12)
//            ->helperText('Telefon raqamingizni +998 prefiksi bilan kiriting')
            ->rules([
                'regex:/^[0-9\s]+$/',
            ])
            ->validationMessages([
                'regex' => 'Telefon raqami faqat raqamlardan iborat bo\'lishi kerak.',
                'required' => 'Telefon raqami majburiy.',
                'max' => 'Telefon raqami 11 ta belgidan oshmasligi kerak.',
                'min' => 'Telefon raqami kamida 9 ta belgidan iborat bo\'lishi kerak.',
            ]);
    }
}





