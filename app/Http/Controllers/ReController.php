<?php

namespace App\Http\Controllers;
use App\Jobs\ImportData;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Scheduling\Schedule;

use App\Country;
use App\City;
use App\District;
use App\Street;

class ReController extends Controller
{
    //check execution_time php.ini > 560
    public $domain;
    public $key;

    public function __construct(){
        $this->domain = 'http://api.recrm.ru/json/';
        $this->key = '23e08d57e7824002910c5099f63a29cf';
    }

    public function importItems(Schedule $schedule){
        //getting list with items from estate/search date_from date_to
        //we have a date with last update or not
        //we are moving up from this date ,  send as param this date
        //getting details in foreach for 3 objects
        //in every iteration save this last date.

        //отдельно сохранена эта дата объекта
        //если дата последнего айпдейта есть - берем ее
        //если нет то просто список
        //список с уже нужными объектами 3000 тысячи например или 50
        //TODO: мы идем по списку что делаем с 3000 тысячами? execution time 0 поставить и как быть с 500 штук.(продолжать там где последняя дата сохранена. отправлять ее в запросе.)
        //edit_datetime in property of every object
        //если нас остановили мы пробуем еще через 20 минут.

        //JOB отдельно попробовать на чем нибудь
        //можно так же емаилы отправлять
        //если ошибка то пробуем через 60 мин.

        // Итог есть опция как release(3600); job повторится через час.
        // А в целом ее надо выполнять 20 минут.... интересно они размножаться их станет много или ларавел умеет проверять и контролировать сам повторы. Должен быть айди работы которая выполняется.

        //$emailJob = new MatchSendEmail();
        //$schedule->job(new ImportData())->everyMinute();//->withoutOverlapping();
        //dispatch(new ImportData());






        return 'items had imported';
    }

    public function importStreets(){
        $response = Http::get($this->domain . 'street/allstreets',[
            'key' => $this->key,
        ]);
        $json = $response->getBody();
        $result = json_decode($json, true);
        foreach($result['streets'] as $res){
            //checking exist in db
            $item = Street::find($res['id']);
            if(empty($item)){
                $item = new Street;
                $item->fill($res);
                $item->save();
            }
        }
        return 'streets had imported';
    }

    public function importDistricts(){
        $cities = City::all();
        foreach($cities as $city){
            $response = Http::get($this->domain . 'districts',[
                'key' => $this->key,
                'city_id' => $city['id'],
            ]);
            $json = $response->getBody();
            $result = json_decode($json, true);
            foreach($result['districts'] as $res){
                //checking exist in db
                $item = District::find($res['id']);
                if(empty($item)){
                    $item = new District;
                    $item->fill($res);
                    $item->save();
                }
            }
        }
        return 'districts had imported';
    }

    public function importCities(){
        $response = Http::get($this->domain . 'cities',[
            'key' => $this->key,
        ]);
        //if ($response->getBody()) {
        $json = $response->getBody();
        $result = json_decode($json, true);
        foreach($result['cities'] as $res){
            //checking exist in db
            $item = City::find($res['id']);
            if(empty($item)){
                $item = new City;
                $item->fill($res);
                $item->save();
            }
        }
        //}
        return 'cities had imported';
    }

    public function importCountries(){
        $response = Http::get($this->domain . 'countries',[
            'key' => $this->key,
        ]);
        //if ($response->getBody()) {
        $json = $response->getBody();
        $result = json_decode($json, true);
        foreach($result['countries'] as $res){
            //checking exist in db
            $item = Country::find($res['id']);
            if(empty($item)){
                $item = new Country;
                $item->fill($res);
                $item->save();
            }
        }
        //}
        return 'countries had imported';
    }

}
