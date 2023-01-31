<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\HTMLToMarkdown\HtmlConverter;
use Statamic\Facades\Entry;
use Statamic\Facades\YAML;

class MediumConverter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:medium';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $converter = new HtmlConverter(['strip_tags' => true]);

        $files = Storage::files('medium-posts');

        foreach ($files as $file) {
            // Make the filename Statamic friendly
            $filename = Str::beforeLast(Str::replaceFirst('_', '.', Str::lower(File::name($file))), '-').'.md';
            
            $published = true;
            
            if (Str::startsWith($filename, 'draft')) {
                $published = false;
                
                // Strip 'draft' from the filename
                $filename = Str::replaceFirst('draft', date('Y-m-d'), $filename);
            }

            $slug = Str::after($filename, '.');

            // Clear out the Medium CSS and meta
            $html = preg_replace('/\<head\>.*\<\/head\>/ims', '', Storage::get($file));

            $markdown = $converter->convert($html);

            $collection = collect(explode("\n", $markdown));

            $title = $collection->shift();
            $id = (string) Str::uuid();

            $collection = $collection->skipUntil(function ($item) {
               return Str::endsWith($item, '---');
            });

            $subtitle = trim(Str::replace('---', '', $collection->shift()));
            
            // Remove the Medium footer
            $collection->pop(8);

            $markdown = $collection->implode("\n");

            $frontmatter = YAML::dumpFrontMatter(compact('id', 'title', 'subtitle', 'published'));

            File::put(base_path("content/collections/articles/{$filename}"), $frontmatter.$markdown);
        }

        return 0;
    }
}
