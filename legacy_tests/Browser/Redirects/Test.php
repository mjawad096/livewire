<?php

namespace LegacyTests\Browser\Redirects;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Sushi\Sushi;
use LegacyTests\Browser\TestCase;

class Test extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_correctly_shows_flash_messages_before_and_after_direct()
    {
        $this->markTestSkipped(); // @flaky

        $this->browse(function ($browser) {
            $this->visitLivewireComponent($browser, Component::class)
                /*
                 * Flashing a message shows up right away, AND
                 * will show up if you redirect to a different
                 * page right after.
                 */
                ->assertNotPresent('@flash.message')
                ->waitForLivewire()->click('@flash')
                ->assertPresent('@flash.message')
                ->waitForLivewire()->click('@refresh')
                ->assertNotPresent('@flash.message')
                ->click('@redirect-with-flash')->waitForReload()
                ->assertPresent('@flash.message')
                ->waitForLivewire()->click('@refresh')
                ->assertNotPresent('@flash.message')
            ;
        });
    }
}

class Foo extends Model
{
    use Sushi;

    protected $guarded = [];

    protected $rows = [
        ['id' => 1, 'name' => 'foo'],
    ];
}
