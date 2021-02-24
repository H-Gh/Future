<?php

namespace App\Providers;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Http\Redirector;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->app->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
            $resolved->validateResolved();
        });
        $this->app->resolving(FormRequest::class, function ($request, $app) {
            $this->initializeRequest($request, $app['request']);
            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
        });
    }

    /**
     * Initialize the form request with data from the given request.
     *
     * @param FormRequest $form
     * @param Request     $current
     *
     * @return void
     */
    protected function initializeRequest(FormRequest $form, Request $current)
    {

        $files = $current->files->all();
        $files = is_array($files) ? array_filter($files) : $files;
        $form->initialize($current->query->all(), $current->request->all(), $current->attributes->all(),
            $current->cookies->all(), $files, $current->server->all(), $current->getContent());
        $form->setJson($current->json());
        if ($session = $current->getSession()) {
            $form->setLaravelSession($session);
        }
        $form->setUserResolver($current->getUserResolver());
        $form->setRouteResolver($current->getRouteResolver());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
