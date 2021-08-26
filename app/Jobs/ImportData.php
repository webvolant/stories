<?php

namespace App\Jobs;

use App\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Http;

class ImportData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /*public function retryUntil()
    {
        return now()->addHours(12);
    }*/

    public $tries = 3;
    //public $maxExceptions = 3;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*$response = Http::get($this->domain . 'estate/search',[
            'key' => $this->key,
        ]);
        $json = $response->getBody();
        $result = json_decode($json, true);

        dd($result);*/

        for($i=1; $i<=2; $i++){
            $log = new \App\Log();
            $log->text = $i;
            $log->save();

            /*if($i==1){
                return $this->release(10); //seconds 10
            }*/
        }

        /*foreach($result['streets'] as $res){
            //checking exist in db
            $item = Street::find($res['id']);
            if(empty($item)){
                $item = new Street;
                $item->fill($res);
                $item->save();
            }
        }*/
    }
}
