<?php

/**
 *   Copyright 2018 Vimeo.
 *
 *   Licensed under the Apache License, Version 2.0 (the "License");
 *   you may not use this file except in compliance with the License.
 *   You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *   Unless required by applicable law or agreed to in writing, software
 *   distributed under the License is distributed on an "AS IS" BASIS,
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *   See the License for the specific language governing permissions and
 *   limitations under the License.
 */
declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Vimeo Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */
    // https://vimeo.com/settings/videos/embed_presets/120923297 
    'connections' => [
        //orginal
        'main' => [
            'client_id' =>"d3bed1eea9b40dbc60e2bcc58f803295202442c8",
            'client_secret' => "jZCQ6r2c9ReMn+NMqBulHwS+rNBOFCZjN8r74Uwyt1zYwCx70U0ngK4fGkBPuxiOQHYpNiyxZ0geOnFE2MUWwXELVEXPBO289wRMMnICUb0OJ9H9s439qbLCx8dChjQe",
            'access_token' =>"e4dfa56d2244318feda3f379d061819d",
        ],
        //test
        // 'main' => [
        //     'client_id' =>"d5a9040038fbc22ed9919db1a71fc38b988152d8",
        //     'client_secret' => "Ypq9pQlt1PEmScUm9WgMyI8CAnUMZiGPfmWf7OjT1xNjRkoJ7NIekJPtqbWTmy0zYi39Sif2KcTggHmbUdf5fy7AONoG0viZ33oTMH6Ev7Qlsu04dflN3hvU5EACNAr3R",
        //     'access_token' =>"cda7fd476dd43fda08793cc71f488336",
        // ],

        'alternative' => [
            'client_id' => env('VIMEO_ALT_CLIENT', 'your-alt-client-id'),
            'client_secret' => env('VIMEO_ALT_SECRET', 'your-alt-client-secret'),
            'access_token' => env('VIMEO_ALT_ACCESS', null),
        ],

    ],

];
