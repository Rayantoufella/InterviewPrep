<?php

namespace App\Providers;

use App\Models\Concept;
use App\Models\Domain;
use App\Models\Question;
use App\Policies\ConceptPolicy;
use App\Policies\DomainPolicy;
use App\Policies\QuestionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Domain::class, DomainPolicy::class);
        Gate::policy(Concept::class, ConceptPolicy::class);
        Gate::policy(Question::class, QuestionPolicy::class);
    }
}