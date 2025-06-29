<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="{{ $settings['favicon'] }}">

        <title>{{ $settings['title'] }}</title>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.0-dev.3/quill.snow.min.css" rel="stylesheet">
        <link href="https://unpkg.com/quill-better-table@1.2.8/dist/quill-better-table.css" rel="stylesheet">

        <meta name="author" content="William & Lily Foundation" />
        <meta name="description" content="William & Lily Foundation, yayasan filantropi berdiri sejak 2009 di Jakarta. Kami mendukung pendidikan, pengentasan kemiskinan, dan pemberdayaan masyarakat melalui program dan donasi bermitra dengan stakeholder lokal.">
        <meta name="keywords" content="William & Lily Foundation, yayasan filantropi, filantropi Indonesia, pendidikan, kemiskinan, pemberdayaan masyarakat, grant making, WLF">
        
        <meta property="og:title" content="William & Lily Foundation – Yayasan Filantropi di Indonesia Sejak 2009">
        <meta property="og:description" content="Dukung pendidikan, pengentasan kemiskinan & pemberdayaan masyarakat di Indonesia bersama William & Lily Foundation.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://wlf.or.id/">
        <meta property="og:image" content="{{ $settings['logo'] }}">
        <meta property="og:site_name" content="William & Lily Foundation">

        @routes
        @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
</html>