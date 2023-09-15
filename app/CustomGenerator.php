<?php

namespace App;

use Statamic\StaticSite\Generator;

class CustomGenerator extends Generator
{
    protected function createPage($content)
    {
        return new CustomPage($this->files, $this->config, $content);
    }
}
