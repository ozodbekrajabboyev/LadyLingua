<?php

namespace App\Filament\Pages;

use App\Models\TranslatorPortfolio;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';

    protected string $view = 'filament.pages.my-profile';

    public ?array $data = [];

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->role === 'translator';
    }


    public function mount(): void
    {
        $portfolio = TranslatorPortfolio::firstOrCreate(
            ['user_id' => Auth::id()],
            ['total_earnings' => 0, 'average_rating' => 0]
        );

        $this->form->fill($portfolio->toArray());
    }

    /**
     * Get the form schema.
     */
    protected function getFormSchema(): array
    {
        return [
            Textarea::make('bio')
                ->label('Your Biography')
                ->placeholder('Tell us about your translation experience...')
                ->maxLength(1000)
                ->rows(6)
                ->required()
                ->columnSpanFull(),

            FileUpload::make('profile_image_url')
                ->label('Profile Photo')
                ->image()
                ->disk('public')
                ->directory('profiles')
                ->visibility('public')
                ->imageEditor()
                ->maxSize(2048) // 2MB limit
                ->columnSpanFull(),
        ];
    }


    protected function getFormStatePath(): string
    {
        return 'data';
    }


    public function save(): void
    {
        $state = $this->form->getState();

        TranslatorPortfolio::where('user_id', Auth::id())->update($state);

        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();
    }
}
