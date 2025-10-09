<?php

namespace App\Filament\User\Pages\Profile;

use App\Filament\User\Pages\Profile\Pages\UserEdit;
use App\Filament\User\Pages\Profile\Pages\UserForm;
use App\Models\Mahasiswa;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;


class UserSetting extends Page implements HasSchemas
{
    use InteractsWithSchemas;
    protected string $view = 'filament.user.pages.profile.user-setting';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user';

    protected ?string $heading = 'Profile';


    protected static ?string $navigationLabel = 'Profile';

    public ?Mahasiswa $mahasiswa = null;

//    public Mahasiswa $record;

//    public function mount(Mahasiswa $record){
//        $this->record = $record;
//        dd($record);
//    }

//    public function mount(): void {
//
//        $this->mahasiswa = Mahasiswa::where('id_user', auth()->user()->id)->first();
//
//    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
            ->label('Lengkapi Data')
            ->url(UserForm::getUrl())
            ->hidden(Mahasiswa::where('id_user', auth()->user()->id)->first() != null),

            Action::make('edit')
                ->label('Edit Profile')
                ->url(UserEdit::getUrl())
                ->hidden(Mahasiswa::where('id_user', auth()->user()->id)->first() === null)
                ->color('warning'),
        ];
    }
    public static function getPages(): array
    {
        return [
            'create' => UserForm::class,
        ];
    }

    public static function infoList(Schema $schema): Schema
    {
        $value = Mahasiswa::where('id_user', auth()->user()->id)->first();

        return $schema
            ->record($value)
            ->components([
                Section::make('Informasi Pribadi')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        TextEntry::make('nama')
                            ->label('Nama Lengkap')
                            ->default('-')
                            ->icon('heroicon-m-user')
                            ->copyMessage('Nama berhasil disalin!')
                            ->weight('bold')
                            ->size('lg'),

                        TextEntry::make('npm')
                            ->label('NPM (Nomor Pokok Mahasiswa)')
                            ->icon('heroicon-m-identification')
                            ->copyable()
                            ->badge()
                            ->default('-')
                            ->color('success'),

                        TextEntry::make('nomor_hp')
                            ->label('Nomor HP / WhatsApp')
                            ->icon('heroicon-m-phone')
                            ->copyable()
                            ->copyMessage('Nomor HP berhasil disalin!')
                            ->url(fn ($record) => $record ? 'https://wa.me/62' . ltrim($record->nomor_hp, '0') : null)
                            ->openUrlInNewTab()
                            ->default('-')
                            ->color('success'),

                        TextEntry::make('agama')
                            ->label('Agama')
                            ->icon('heroicon-m-sparkles')
                            ->badge()
                            ->default('-')
                            ->color(fn (string $state): string => match ($state) {
                                'Islam' => 'success',
                                'Kristen' => 'info',
                                'Katolik' => 'warning',
                                'Hindu' => 'danger',
                                'Buddha' => 'primary',
                                'Konghucu' => 'gray',
                                default => 'gray',
                            }),
                    ])
                    ->columns(2)
                    ->columnSpan(2),

                Section::make('Informasi Akun')
                    ->icon('heroicon-o-at-symbol')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Nama User')
                            ->icon('heroicon-m-user-circle'),

                        TextEntry::make('user.email')
                            ->label('Email')
                            ->icon('heroicon-m-envelope')
                            ->copyable()
                            ->copyMessage('Email berhasil disalin!'),

                        TextEntry::make('created_at')
                            ->label('Terdaftar Sejak')
                            ->icon('heroicon-m-calendar')
                            ->dateTime('d F Y, H:i')
                            ->badge()
                            ->color('gray'),

                        TextEntry::make('updated_at')
                            ->label('Terakhir Diupdate')
                            ->icon('heroicon-m-clock')
                            ->since()
                            ->color('warning'),
                    ])
                    ->columns(2)
                    ->columnSpan(2),
            ]);

    }
}
