<!DOCTYPE html>
<html  lang="{{ lang }}" dir="{{ dir }}">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ title }}</title>
    {{ head }}
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Reenie+Beanie&display=swap"
      rel="stylesheet"
    />
    <script src="https://player.vimeo.com/api/player.js"></script>

    <!-- <link href="{{ url_prefix }}/css/chunk-common.css" rel="preload" as="style" />
    <link href="{{ url_prefix }}/css/chunk-vendors.css" rel="preload" as="style" />
    <link href="{{ url_prefix }}/css/live.css" rel="preload" as="style" />
    <link href="{{ url_prefix }}/js/live.js" rel="preload" as="script" /> -->
    <link href="{{ url_prefix }}/js/chunk-common.js" rel="preload" as="script" />
    <link href="{{ url_prefix }}/js/chunk-vendors.js" rel="preload" as="script" />
    <link href="{{ url_prefix }}/css/chunk-vendors.css" rel="stylesheet" />
    <link href="{{ url_prefix }}/css/chunk-common.css" rel="stylesheet" />
    <link href="{{ url_prefix }}/css/live.css" rel="stylesheet" />
  </head>
  <body>
    {{ body }}
    <div id="app"></div>
    <script src="{{ url_prefix }}/js/chunk-vendors.js"></script>
    <script src="{{ url_prefix }}/js/chunk-common.js"></script>
    <script src="{{ url_prefix }}/js/live.js"></script>
    {{ footer }}
  </body>
</html>
