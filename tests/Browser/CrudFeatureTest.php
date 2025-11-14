<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CrudFeatureTest extends DuskTestCase
{
    protected $testProductName = 'Produk Uji Coba Dusk';
    protected $testProductPrice = 150000;
    protected $testProductPriceUpdated = 200000;

    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');
    }


    /**
     * Test Login
     */
    public function test_1_UserCanLogin(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->type('email', 'diaz@example.com')
                ->type('password', '12345')
                ->press('LOG IN')
                ->assertPathIs('/dashboard');
        });
    }

    /**
     * Test Create Data
     */
    public function test_2_UserCanCreateData(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'diaz@example.com')
                ->type('password', '12345')
                ->press('LOG IN')
                ->assertPathIs('/dashboard');

            $browser->visit('/products/create')
                ->type('#name', 'IKI')
                ->type('#price', '10000')
                ->press('@btn-simpan')
                ->waitForText('Data berhasil ditambahkan', 10)
                ->assertSee('Data berhasil ditambahkan');
        });
    }

    /**
     * Test Read Data
     */
    // public function test_3_UserCanReadData(): void
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/products')
    //             ->assertSee($this->testProductName)
    //             ->assertSee('Rp ' . number_format($this->testProductPrice, 0, ',', '.'));
    //     });
    // }

    // /**
    //  * Test Update Data
    //  */
    // public function test_4_UserCanUpdateData(): void
    // {
    //     $this->browse(function (Browser $browser) {

    //         $browser->visit('/products')
    //             ->click(WebDriverBy::xpath("//tr[td[contains(text(), '{$this->testProductName}')]]//a[contains(@class,'btn-edit')]"))
    //             ->assertPathStartsWith('/products/')
    //             ->clear('price')  // FIXED
    //             ->type('price', $this->testProductPriceUpdated)
    //             ->press('Update')
    //             ->assertPathIs('/products')
    //             ->assertSee('Data berhasil diperbarui')
    //             ->assertSee($this->testProductName)
    //             ->assertSee('Rp ' . number_format($this->testProductPriceUpdated, 0, ',', '.'));
    //     });
    // }

    // /**
    //  * Test Delete Data 
    //  */
    // public function test_5_UserCanDeleteData(): void
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/products')
    //             ->click(WebDriverBy::xpath("//tr[td[contains(text(), '{$this->testProductName}')]]//button[contains(@class,'btn-delete')]"))
    //             ->acceptDialog()
    //             ->assertPathIs('/products')
    //             ->assertSee('Data berhasil dihapus')
    //             ->assertDontSee($this->testProductName);
    //     });
    // }
}
