<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500" rel="stylesheet" type="text/css">
    </head>

    <body style="font-family: montserrat, sans-serif;">
        <div style="max-width: 100%; width: calc(100% - 50px); height: auto; margin: 25px;">
            <div>
                <div style="margin-bottom: 30px; padding-bottom: 5px; border-bottom: 1px solid #ccc;">
                    <a href="{{ config('app.url') }}">
                        @if ($logo = core()->getCurrentChannel()->logo_url)
                            <img src="{{ $logo }}" alt="" style="height: 40px; width: 110px;"/>
                        @else
                            <img src="{{ bagisto_asset('images/logo.svg') }}">
                        @endif
                    </a>
                </div>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
