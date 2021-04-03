<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Basic -->
<meta charset="utf-8"/>

<title>{{trim($siteSettings['site_name']->value_fa)}}| @yield('title')</title>

<meta property="og:title" content=" {{trim($siteSettings['site_name']->value_fa)}}| @yield('title')"/>
@hasSection ('seo')
    @yield('seo')
@else
    <meta property="og:description" content=" {!! trim($siteSettings['site_description']->value_fa) !!}"/>

    <meta property="og:type" content="website"/>
    <meta property="og:locale" content="fa"/>
    <meta property="og:site_name" content="{{trim($siteSettings['site_name']->value_fa)}}"/>
    <meta property="og:url"
          content=""/>
    @yield('image')
    <meta property="og:image"
          content="@yield('image')"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="{{trim($siteSettings['site_name']->value_fa)}}| @yield('title')"/>
    <meta name="twitter:description" content="{!! trim($siteSettings['site_description']->value_fa) !!}"/>
    <meta name="twitter:site" content="@Aysa"/>
    <meta name="twitter:image"
          content="@yield('image')"/>
@endif
