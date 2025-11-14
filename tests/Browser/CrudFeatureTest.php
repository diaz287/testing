<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CrudFeatureTest extends DuskTestCase
{
    protected $testProductName = 'Produk Uji Coba Dusk';
    protected $testProductPrice = 150000;
    protected $testProductPriceUpdated = 200000;

    /**
     * Test Login
     */
    public function test_1_UserCanLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->pause(5000)
                ->type('#email', 'diaz@example.com')
                ->type('#password', '12345')
                ->press('Log in')
                ->assertPathIs('/dashboard');
        });
    }

    /**
     * Test Create Data
     */
    public function test_2_UserCanCreateData(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products/create')
                ->type('name', $this->testProductName)
                ->type('price', $this->testProductPrice)
                ->press('Simpan')
                ->assertPathIs('/products')
                ->assertSee('Data berhasil ditambahkan')
                ->assertSee('Rp ' . number_format($this->testProductPrice, 0, ',', '.'));
        });
    }

    /**
     * Test Read Data
     */
    public function test_3_UserCanReadData(): void
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/products')
                ->assertSee($this->testProductName)
                ->assertSee('Rp ' . number_format($this->testProductPrice, 0, ',', '.'));
        });
    }

    /**
     * Test Update Data
     */
    public function test_4_UserCanUpdateData(): void
    {
        $this->browse(function (Browser $browser) {

            // Klik tombol Edit berdasarkan nama produk via XPath
            $browser->visit('/products')
                ->clickXPath("//tr[td[contains(text(), '{$this->testProductName}')]]//a[contains(@class,'btn-edit')]")
                ->assertPathStartsWith('/products/')
                ->clear('price')
                ->type('price', $this->testProductPriceUpdated)
                ->press('Update')
                ->assertPathIs('/products')
                ->assertSee('Data berhasil diperbarui')
                ->assertSee($this->testProductName)
                ->assertSee('Rp ' . number_format($this->testProductPriceUpdated, 0, ',', '.'));
        });
    }

    /**
     * Test Delete Data 
     */
    public function test_5_UserCanDeleteData(): void
    {
        $this->browse(function (Browser $browser) {

            // Tombol delete via XPath
            $browser->visit('/products')
                ->clickXPath("//tr[td[contains(text(), '{$this->testProductName}')]]//button[contains(@class,'btn-delete')]")
                ->acceptDialog()
                ->assertPathIs('/products')
                ->assertSee('Data berhasil dihapus')
                ->assertDontSee($this->testProductName);
        });
    }
}
