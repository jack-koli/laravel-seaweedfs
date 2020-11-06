<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Upload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '上传测试';

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
        $this->upload2filer();
    }

    function upload2filer() {
        $imgpath = storage_path('temp/doraemon_1.png');
        $this->output->writeln("path: {$imgpath}");
        $filerUrl = env('SEAWEED_FILER');
        $response = Http::attach('img', file_get_contents($imgpath))
            ->post($filerUrl.'/temp/doraemon_1.png');

        var_dump($response->json());
        // http://192.168.8.240:7777/temp/doraemon_1.png
    }

    function upload2volume() {
        $imgpath = storage_path('temp/doraemon_1.png');
        $this->output->writeln("path: {$imgpath}");


        $masterUrl = env('SEAWEED_MASTER');
        $this->output->writeln("masterUrl: {$masterUrl}");
        $resp = Http::get($masterUrl.'/dir/assign');
        $respJson = $resp->json(); // fid, url , publicUrl, count
        $uploadUrl = $respJson['url']; // 192.168.8.240:8081
        $fid = $respJson['fid']; // 3,0241b7ce0d

        $url = "http://{$uploadUrl}/{$fid}";
        $this->output->writeln("post url: {$url}");
        $response2 = Http::attach('file', file_get_contents($imgpath))
            ->post($url);

        var_dump($response2->json());
        return 0;
    }
}
