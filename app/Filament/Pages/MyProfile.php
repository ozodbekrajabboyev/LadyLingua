<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Translators\Schemas\TranslatorsForm;
use App\Models\TranslatorPortfolio;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    protected static ?string $navigationLabel = 'Mening Profilim';

    protected static ?string $title = 'Mening Profilim';

    protected string $view = 'filament.pages.my-profile';

    public ?array $data = [];

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->role === 'translator';
    }

    public function mount(): void
    {
        $portfolio = TranslatorPortfolio::with('languages')->firstOrCreate(
            ['user_id' => Auth::id()],
            ['total_earnings' => 0, 'average_rating' => 0]
        );

        $formData = $portfolio->toArray();
        $formData['user_id'] = $portfolio->user_id;

        // Prepare language proficiency for repeater
        $formData['languageProficiency'] = $portfolio->languages->map(function ($language) {
            return [
                'available_language_id' => $language->id,
                'proficiency_level' => $language->pivot->proficiency_level ?? 'intermediate',
            ];
        })->toArray();

        $this->form->fill($formData);
    }

    protected function getFormSchema(): array
    {
        return TranslatorsForm::configure(new Schema)->getComponents();
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    protected function getFormModel(): string
    {
        return TranslatorPortfolio::class;
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $portfolio = TranslatorPortfolio::where('user_id', Auth::id())->first();

        // Extract language proficiency data
        $languageProficiency = $state['languageProficiency'] ?? [];
        unset($state['languageProficiency']);
        unset($state['languages']); // Remove if exists

        // Update portfolio
        $portfolio->update($state);

        // Sync languages with proficiency
        if (! empty($languageProficiency)) {
            $syncData = [];
            foreach ($languageProficiency as $langData) {
                if (isset($langData['available_language_id'])) {
                    $syncData[$langData['available_language_id']] = [
                        'proficiency_level' => $langData['proficiency_level'] ?? 'intermediate',
                    ];
                }
            }
            $portfolio->languages()->sync($syncData);
        }

        Notification::make()
            ->title('Profil muvaffaqiyatli yangilandi!')
            ->success()
            ->send();
    }
}
