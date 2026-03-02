<?php

namespace Tests\Feature\Filament;


use App\Filament\Resources\SuratKeputusans\Pages\ListSuratKeputusans;
use App\Models\SuratKeputusan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SuratKeputusanResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_can_render_the_list_page(): void
    {
        Livewire::test(ListSuratKeputusans::class)->assertSuccessful();
    }

    public function test_can_list_surat_keputusans(): void
    {
        $suratKeputusans = SuratKeputusan::factory()->count(10)->create();

        Livewire::test(ListSuratKeputusans::class)
            ->assertCanSeeTableRecords($suratKeputusans);
    }
}
