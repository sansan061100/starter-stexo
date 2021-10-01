<?php

namespace App\Providers;

use App\Repositories\HargaCoretRepository;
use App\Repositories\HargaTurunanRepository;
use App\Repositories\Interfaces\HargaCoretRepositoryInterface;
use App\Repositories\Interfaces\HargaTurunanRepositoryInterface;
use App\Repositories\Interfaces\JamOperasionalRepositoryInterface;
use App\Repositories\Interfaces\KategoriRepositoryInterface;
use App\Repositories\Interfaces\OutletRepositoryInterface;
use App\Repositories\Interfaces\ProdukRepositoryInterface;
use App\Repositories\Interfaces\StokRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\VoucherRepositoryInterface;
use App\Repositories\JamOperasionalRepository;
use App\Repositories\KategoriRepository;
use App\Repositories\OutletRepository;
use App\Repositories\ProdukRepository;
use App\Repositories\StokRepository;
use App\Repositories\UserRepository;
use App\Repositories\VoucherRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(KategoriRepositoryInterface::class, KategoriRepository::class);
        $this->app->bind(ProdukRepositoryInterface::class, ProdukRepository::class);
        $this->app->bind(StokRepositoryInterface::class, StokRepository::class);
        $this->app->bind(HargaCoretRepositoryInterface::class, HargaCoretRepository::class);
        $this->app->bind(OutletRepositoryInterface::class, OutletRepository::class);
        $this->app->bind(JamOperasionalRepositoryInterface::class, JamOperasionalRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(VoucherRepositoryInterface::class, VoucherRepository::class);
        $this->app->bind(HargaTurunanRepositoryInterface::class, HargaTurunanRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
