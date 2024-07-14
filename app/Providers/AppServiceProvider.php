<?php

namespace App\Providers;

use App\Domain\Book\Repositories\BookRepositoryInterface;
use App\Domain\Book\Services\BookService;
use App\Domain\Book\Services\BookServiceInterface;
use App\Domain\Borrow\Repositories\IBorrowRepository;
use App\Domain\Borrow\Services\BorrorService;
use App\Domain\Borrow\Services\BorrowService;
use App\Domain\Borrow\Services\IBorrowService;
use App\Domain\Member\Repositories\MemberRepositoryInterface;
use App\Domain\Member\Services\IMemberService;
use App\Domain\Member\Services\MemberService;
use App\Infrastructure\Book\Repositories\EloquentBookRepository;
use App\Infrastructure\Borrow\Repositories\BorrowRepository;
use App\Infrastructure\Member\Repositories\MemberRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
        
        // Book
        $this->app->bind(BookRepositoryInterface::class,EloquentBookRepository::class);
        $this->app->bind(BookServiceInterface::class,BookService::class);

        // Member
        $this->app->bind(IMemberService::class,MemberService::class);
        $this->app->bind(MemberRepositoryInterface::class,MemberRepository::class);
        
        // Borrow
        $this->app->bind(IBorrowService::class,BorrowService::class);
        $this->app->bind(IBorrowRepository::class,BorrowRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
