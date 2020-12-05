<?php

namespace App\Console\Commands;

use Aws\S3\S3Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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
//        $this->uploadByAws();
        $this->uploadByFileSystem();
    }

    function uploadByFileSystem() {
        // $composer require league/flysystem-aws-s3-v3:1.0.29
        // 在 .env 增加下面内容
        // FILESYSTEM_DRIVER=s3
        //AWS_DEFAULT_REGION=ap-southeast-1
        $imgpath = storage_path('temp/doraemon_1.png');
        Storage::disk('s3')->put('avatar/1.png', file_get_contents($imgpath));

        $url = Storage::temporaryUrl('avatar/1.png', now()->addMinutes(20));
        $this->output->writeln("s3: {$url}");
    }

    function uploadByAws(){
        // composer require aws/aws-sdk-php
        // composer require aws-sdk-php-laravel

        $imgpath = storage_path('temp/doraemon_1.png');
        $this->output->writeln("path: {$imgpath}");
        /** @var S3Client $s3 */
        $s3 = \Aws::createClient('s3');
        $this->output->writeln("s3 class:".get_class($s3));
//        $result = $s3->putObject([
//            'Bucket' => 'front-otc',
//            'Key' => 'doraemon-sign.png',
//            'SourceFile' => storage_path('temp/doraemon_1.png'),
//
//        ]);
//
//        var_dump($result);
        $cmd = $s3->getCommand('GetObject',[
            'Bucket' > 'front-otc',
            'Key' => 'doraemon-sign.png',
        ]);


        $request = $s3->createPresignedRequest($cmd, '+20 minutes');
        $presignUrl = (string) $request->getUri();
        echo $presignUrl;
//        $s3->
    }
}
