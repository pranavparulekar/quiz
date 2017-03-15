<!DOCTYPE html>
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Quiz</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
                <div class="top-right links">
                    
                </div>

            <div class="content">
                <div class="title m-b-md">
                QUIZ
                </div>

                <form method="POST" action="login">
                    <input type="text" name="username" value="" />
                    <input type="password" name="password" value="" />
                    <button>Login</button>
                    {{ csrf_field() }}
                </form>
                

                @if (isset($errors))
                    @foreach($errors->all() as $error)
                        <p style="color:red;">{{$error}}</p>
                    @endforeach
                @endif

                @if (session('status'))
                    <p style="color:red;"> {{ session('status') }}</p>
                @endif

            </div>
        </div>
    </body>
</html>
