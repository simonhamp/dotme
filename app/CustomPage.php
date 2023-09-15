<?php

namespace App;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Statamic\StaticSite\GeneratedPage;
use Statamic\StaticSite\Page;
use Torchlight\Middleware\RenderTorchlight;

class CustomPage extends Page
{
    protected function write($request)
    {
        $response = (new RenderTorchlight())->handle($request, function ($request) {
            try {
                $response = $this->content->toResponse($request);
            } catch (HttpResponseException $e) {
                $response = $e->getResponse();
                throw_unless($response instanceof RedirectResponse, $e);
            }

            // This has to be set/overridden, as additional pages being generated
            // by Statamic SSG will have a `null` content type and Torchlight
            // relies on this to return the full response instead of Blade.
            $response->headers->set('content-type', 'html');

            return $response;
        });

        $html = $response->getContent();

        if (! $this->files->exists($this->directory())) {
            $this->files->makeDirectory($this->directory(), 0755, true);
        }

        $this->files->put($this->path(), $html);

        return new GeneratedPage($this, $response);
    }
}
