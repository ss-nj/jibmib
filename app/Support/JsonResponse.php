<?php


namespace App\Support;


class JsonResponse
{
    /**
     * @param $status
     * @param string $message
     * @param string $title
     * @param null|string $action
     * @param null|string $link
     * @param null $function
     * @param array|null $args
     * @return false|string
     */
    public static function sendJsonResponse($status,$title, $message,  $action = null, $link = null,$function=null,array $args=null)
    {
        //REFRESH
        //REDIRECT
        //ACTION_ALERT
        //toastr
        header('Content-Type: application/json');
        return json_encode([
            'status'=>$status,
            'title'=>$title,
            'message'=>$message,
            'action'=>$action,
            'url'=>$link,
            'color'=>'#000000',
            'function'=>$function,
            'args'=>$args,
        ]);
    }
}
