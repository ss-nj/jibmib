<?php


namespace App\Traits;


use function sprintf;

trait Social
{

    public $map = [
        'google_plus' => ['Http://Plus.Google.Com/Share?Url=%s&Amp;T=%s', 'fa fa-google-plus', 'btn-share btn-share-google-plus'],
        'twitter' => ['http://twitter.com/home?status=%s&amp;title=%s', 'fa fa-twitter', 'btn-share btn-share-twitter'],
        'facebook' => ['http://www.facebook.com/share.php?u=%s&amp;t=%s', 'fa fa-facebook', 'btn-share btn-share-facebook'],
        'telegram' => ['https://telegram.me/share/url?url=%s&text=%s', 'fa fa-paper-plane', 'btn-share btn-share-twitter']
    ];

    /**
     * @param $route
     * @param $title
     * @param null $class
     * @return string
     */
    public function googlePlus($route, $title, $class = null): string
    {

        $route = sprintf($this->map['google_plus'][0], $route, $title);
        $icon = $this->map['google_plus'][1];
        $class = $class ?? $this->map['google_plus'][2];

        return "<li><a  class='$class' href='$route' target='_blank'><i class='$icon'></i></a></li>";
    }

      /**
     * @param $route
     * @param $title
     * @param null $class
     * @return string
     */
    public function facebook($route, $title, $class = null): string
    {

        $route = sprintf($this->map['facebook'][0], $route, $title);
        $icon = $this->map['facebook'][1];
        $class = $class ?? $this->map['facebook'][2];

        return "<li ><a  class='$class' href='$route' target='_blank'><i class='$icon'></i></a></li>";
    }

      /**
     * @param $route
     * @param $title
     * @param null $class
     * @return string
     */
    public function tweeter($route, $title, $class = null): string
    {

        $route = sprintf($this->map['twitter'][0], $route, $title);
        $icon = $this->map['twitter'][1];
        $class = $class ?? $this->map['twitter'][2];

        return "<li ><a  class='$class' href='$route' target='_blank'><i class='$icon'></i></a></li>";
    }

      /**
     * @param $route
     * @param $title
     * @param null $class
     * @return string
     */
    public function telegram($route, $title, $class = null): string
    {

        $route = sprintf($this->map['telegram'][0], $route, $title);
        $icon = $this->map['telegram'][1];
        $class = $class ?? $this->map['telegram'][2];

        return "<li ><a  class='$class' href='$route' target='_blank'><i class='$icon'></i></a></li>";

    }

}