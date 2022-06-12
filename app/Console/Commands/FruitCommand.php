<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Fruit;
use App\Models\Etag;
use App\Models\ParentChild;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FruitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:fruit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a regular query on to the https://dev.shepherd.appoly.io/fruit.json API location';

    protected $depth = 0;

    protected $last = 1;

    protected $indent = 0;

    protected $children = false;

    protected $name = false;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $headers = Http::head('https://dev.shepherd.appoly.io/fruit.json');

        $res =  $this->etag($headers->header('Etag'));

        if ($res == 0) {
            Log::info(now(). " : API has not changed");
            return 0;
        }

        $response = Http::get('https://dev.shepherd.appoly.io/fruit.json');
        //$this->info(print_r($response->body()), true);

        if ($response->successful()) {
            $this->object_recursion($response->object()->menu_items);
        }

        if ($response->serverError()) {
            Log::error($response->serverError());
            return 0;
        }

        if ($response->clientError()) {
            Log::error($response->clientError());
            return 0;
        }

        if ($response->failed()) {
            Log::error($response->failed());
            return 0;
        }
        $this->depth = 0;

        return 0;
    }

    function object_recursion($object) {
        foreach ($object as $key => $value) {
            if(empty($value)) {
                continue;
            }

            if (is_object($value) || is_array($value)) {
                if (array_key_first((array) $value))
                    $this->depth += 1;
                $this->object_recursion($value);
                if (array_key_last((array) $value))
                    $this->depth -= 1;
            } else {
                if (!$this->compareFruit($value))
                    continue;

                if ($this->last == $this->depth)
                    $this->indent=$this->indent;
                else if ($this->last < $this->depth)
                    $this->indent+=4;
                else
                    $this->indent-=4;

                $emoji = $this->matchingEmoji($value);

                $fruit = Fruit::create([
                    'original_name' => $value,
                    'name' => $value,
                    'depth' => 'padding-' . $this->indent,
                    'emoji' => $emoji,
                ]);

                //$this->info($key);
                $this->last = $this->depth;
            }
        }
    }

    function setparent($parent) {
        $this->parent = $parent;
    }

    function compareFruit($fruit) {
        $match = DB::table('fruits')
            ->where('name', $fruit)
            ->orWhere('original_name', $fruit)
            ->get();
        if ($match)
            return 1;
        return 0;
    }

    function matchingEmoji($fruit) {
        $emojis = [
            "Grapes" => "\u{1f347}",
            "Melons" => "\u{1f348}",
            "Watermelon" => "\u{1f349}",
            "Oranges" => "\u{1f34A}",
            "Lemons" => "\u{1f34B}",
            "Bananas" => "\u{1f34C}",
            "Pineapples" => "\u{1f34D}",
            "Apples" => "\u{1f34E}",
            "Apples" => "\u{1f34F}",
            "Pears" => "\u{1f350}",
            "Peaches" => "\u{1f351}",
            "Cherries" => "\u{1f352}",
            "Strawberries" => "\u{1f353}",
            "Kiwis" => "\u{1f95D}",
            "Mangos" => "\u{1f96D}"
            ];

        $emoji = array_key_exists($fruit, $emojis) ? $emojis[$fruit] : "\u{1f377}";
        return $emoji;
    }

    function etag($etag) {
        if (!Etag::find(1)) {
            Etag::create([
                'etag' => $etag
            ]);
        } else {
            if ($etag == Etag::first()->etag) {
                return 0;
            }

            Etag::update([
                'etag' => $etag
            ]);
        }
        return 1;
    }
}
