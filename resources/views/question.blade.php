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

        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        

        <script type="text/javascript">
        $(document).ready(function(){

            var page = 1;
            var max = {{$max_que}};

            $('#btn_finish').hide();
            display(page);

            function display(page){

                if(page > max){
                    page = max;
                }

                $('[name=ques]').hide();
                $('#ques_'+page).show();

                if(page == 1)
                    $('#btn_prev').attr('disabled','disabled');
                else
                    $('#btn_prev').removeAttr('disabled');

                if(page == max){
                    $('#btn_next').attr('disabled','disabled');
                    $('#btn_finish').show();
                }
                else{
                    if($('#ques_'+page+' [name^=opt]:checked').length > 0) {
                        $('#btn_next').removeAttr('disabled');
                    }else{
                        $('#btn_next').attr('disabled','disabled');
                    }
                }
            }


            $('[name^=opt]').click(function(){
                if(page != max)
                    $('#btn_next').removeAttr('disabled');
            });

            $('#btn_prev').click(function(){
                display(--page);
            });

            $('#btn_next').click(function(){
                display(++page);
            });

            $('#btn_finish').click(function(){
                $('#question_form').submit();
            });

            
        });
        </script>
    </head>
    <body>
        <p>Hi {{ $username }} | Test Attempt : {{ $attempt }} 
        <div class="position-ref full-height">
               <form id="question_form" action="{{ URL::asset('submit') }}" method="POST">
                
               @foreach ($data as $qid => $qinfo)
               <div id="ques_{{ $qid }}" name="ques">
                {{ $qinfo['question'] }} <br/>
                @foreach ($qinfo['options'] as $oid => $oinfo)
                    <input type="radio" name="opt_{{ $qid }}" value="{{ $oid }}" /> {{ $oinfo['option_text'] }} <br/>
                @endforeach
                </div>
               @endforeach
               {{ csrf_field() }}
               </form>
               <br/>
               <button id="btn_prev" >Previous</button>
               <button id="btn_next" disabled="disabled">Next</button>
               <button id="btn_finish">Submit Test</button>
        </div>
    </body>
</html>
