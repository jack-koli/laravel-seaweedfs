<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class S3upload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 's3upload';

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
        // composer require aws/aws-sdk-php
        // composer require aws-sdk-php-laravel

        $imgpath = storage_path('temp/doraemon_1.png');
        $this->output->writeln("path: {$imgpath}");
        $s3 = \App::make('aws')->createClient('s3');
        $result = $s3->putObject([
            'Bucket' => 'front-otc',
            'Key' => 'doraemon.png',
            'SourceFile' => storage_path('temp/doraemon_1.png'),
        ]);

        var_dump($result);
    }
}
