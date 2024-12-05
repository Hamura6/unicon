<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: rgb(2, 2, 23);
            font-family: "Comic Sans MS";
            font-weight: 600;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 20px;
            padding: 5px 20px;
        }
        .btn{
            padding: 7px 45px;
            font-size: 12px;
            color: white;
            background: radial-gradient(circle at 89.74% 46.52%, rgb(17, 17, 75) 0, rgb(8, 8, 54) 25%, rgb(7, 7, 49) 50%, rgb(4, 4, 36) 75%, rgb(2, 2, 23) 100%);
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition:background 4s ;
        }
        .btn:hover{
            background: radial-gradient(circle at 89.74% 46.52%,rgb(2, 2, 23)  0,rgb(4, 4, 36) 25%, rgb(7, 7, 49) 50%,rgb(8, 8, 54)  75%,rgb(17, 17, 75)  100%);
        }
        .numeric{
            font-size: 100px;
            text-shadow: 4px 4px 2px rgb(128, 127, 127);
            letter-spacing: 5px;
        }

    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="numeric">
                @yield('code')
            </div>
            <div style="font-size: 27px">
                <strong>Ooops!</strong>
            </div>
            <div class="title">
                @yield('message')
            </div>
            <div style="margin: 10px 0">
                <a href="{{route('profile.edit')}} " class="btn btn-primary">Perfil</a>
            </div>
        </div>
    </div>

</body>

</html>
