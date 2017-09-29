<?php

namespace app\models;

use Yii;
use yii\base\Model;


class JsonParser extends Model
{
    public function parse($jsonStr)
    {
        $json = json_decode($jsonStr);
        if ($json) {
            $data = array();
            $data['title'] = implode(', ', array(
                $json->application_name,
                $json->country,
                $json->city,
                $json->app_id
            ));
            foreach ($json->events as $event)
            {
                date_default_timezone_set('Asia/Novosibirsk');
                $row = array();
                $row['event'] = mb_strtolower($event->event);
                $row['date'] = date('Y-m-d H:i', $event->timestamp/1000);
                $jsonData = json_decode($event->data);
                $row['time_on'] = $jsonData->time_on;
                $row['type'] = $jsonData->type;
                $data['events'][] = $row;
            }

            usort($data['events'], function($a, $b)
            {
                if ($a['time_on'] == $b['time_on'])
                {
                    return 0;
                }
                else if ($a['time_on'] > $b['time_on'])
                {
                    return -1;
                }
                else {
                    return 1;
                }
            });

            return $data;
        }

        return false;
    }
}