<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client as Guzclient;

class Abitra extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abitra';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '１つの取引所内でコインＡを売買するルートが２種類以上あれば、そこに大きな価格差が生まれる瞬間が必ずあるんだ.';

    protected $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    function __construct($client = null)
    {
        $endpoint = 'https://api.zaif.jp';
        $this->client = is_null($client) ? new Guzclient(['base_uri' => $endpoint]) : $client;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $depth = $this->getContents('/api/1/depth/btc_jpy');
        $last = $this->getContents('/api/1/last_price/btc_jpy');
    }

    /**
     * Get contents
     */
    private function getContents($url)
    {
        $response = $this->client->get($url, []);
        $contents = $response->getBody()->getContents();
        return json_decode($contents, true);
    }
}
