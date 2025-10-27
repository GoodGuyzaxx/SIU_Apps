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
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;


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
        $value = Mahasiswa::where('id_user', auth()->user()->id)
            ->with('user')
            ->first();

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
                            ->weight(FontWeight::Bold)
                            ,

                        TextEntry::make('npm')
                            ->label('NPM (Nomor Pokok Mahasiswa)')
                            ->icon('heroicon-m-identification')
                            ->copyable()
                            ->badge()
                            ->default('-')
                            ->color('success'),

                        TextEntry::make('program_studi')
                            ->label('Program Studi')
                            ->icon('heroicon-m-academic-cap')
                            ->badge()
                            ->color(Color::Blue)
                            ->default('-'),

                        TextEntry::make('jenjang')
                            ->label('Jenjang Pendidikan')
                            ->icon('heroicon-m-flag')
                            ->badge()
                            ->color(Color::Violet)
                            ->default('-'),

                        TextEntry::make('kelas')
                            ->label('Kelas')
                            ->icon('heroicon-m-building-storefront')
                            ->badge()
                            ->color(Color::Orange)
                            ->default('-'),

                        TextEntry::make('nomor_hp')
                            ->label('Nomor HP / WhatsApp')
                            ->icon('heroicon-m-phone')
                            ->copyable()
                            ->copyMessage('Nomor HP berhasil disalin!')
                            ->url(fn ($record) => $record ? 'https://wa.me/62' . ltrim($record->nomor_hp, '0') : null)
                            ->openUrlInNewTab()
                            ->default('-')
                            ->color(Color::Emerald),

                        TextEntry::make('agama')
                            ->label('Agama')
                            ->icon('heroicon-m-sparkles')
                            ->badge()
                            ->default('-')
                            ->color(fn (string $state): string => match ($state) {
                                'Islam' => 'success',
                                'Kristen' => 'blue',
                                'Katolik' => 'indigo',
                                'Hindu' => 'warning',
                                'Buddha' => 'purple',
                                'Konghucu' => 'gray',
                                default => 'gray',
                            }),
                    ])
                    ->columns(2)
                    ->columnSpan(2),

                Section::make('Informasi Akademik')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        TextEntry::make('program_studi')
                            ->label('Program Studi')
                            ->icon('heroicon-m-book-open')
                            ->weight(FontWeight::SemiBold)
                            ->color(Color::Blue),

                        TextEntry::make('jenjang')
                            ->label('Jenjang')
                            ->icon('heroicon-m-arrow-trending-up')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'D3' => 'green',
                                'S1' => 'blue',
                                'S2' => 'purple',
                                'S3' => 'red',
                                default => 'gray',
                            }),

                        TextEntry::make('kelas')
                            ->label('Kelas')
                            ->icon('heroicon-m-user-group')
                            ->badge()
                            ->color(Color::Orange),
                    ])
                    ->columns(3)
                    ->columnSpan(2),

                Section::make('Informasi Akun')
                    ->icon('heroicon-o-at-symbol')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Username')
                            ->icon('heroicon-m-user-circle')
                            ->color(Color::Gray),

                        TextEntry::make('user.email')
                            ->label('Email')
                            ->icon('heroicon-m-envelope')
                            ->copyable()
                            ->copyMessage('Email berhasil disalin!')
                            ->color(Color::Gray),

                        TextEntry::make('created_at')
                            ->label('Terdaftar Sejak')
                            ->icon('heroicon-m-calendar')
                            ->dateTime('d F Y, H:i')
                            ->badge()
                            ->color(Color::Gray),

                        TextEntry::make('updated_at')
                            ->label('Terakhir Diupdate')
                            ->icon('heroicon-m-clock')
                            ->since()
                            ->color(Color::Amber),
                    ])
                    ->columns(2)
                    ->columnSpan(2),
            ]);
    }
}
