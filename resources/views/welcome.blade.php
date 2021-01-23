<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
  {{-- <script src="{{ mix('/js/app.js') }}"></script>
  <script src="{{ mix('/js/front.js') }}"></script> --}}
    <script src='public/js/app.js'></script>
    <script src='public/js/front.js'></script>
<style>
        /* 土曜日のカラー設定 */
        .ui-datepicker-week-end a.ui-state-default{
            background: mediumaquamarine;   /* 背景色を設定 */
            /* color: #00f!important;       文字色を設定 */
        }

        /* 日曜日のカラー設定 */
        .ui-datepicker-week-end:last-child a.ui-state-default{
            background: pink !important;
        }

        .ui-widget-header {
            border: 1px solid #e78f08;
            background:pink !important;
            color: #fff;
            font-weight: bold;
        }

        input::placeholder {
            font-size: 12px;
        }

        .toast {
            width: 250px;
        }

        .toast.success {
            color: green;
        }

        .toast.error {
            color: #e61e1e;
        }

        body {
                font-family: 'Nunito';
        }

    </style>
        <title>株式会社○○　問合せフォーム</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>

        <!-- jquery -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

        <!-- jqueryUI CDN -->
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        {{-- カレンダー日本語化 --}}
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>

        <!-- jquery -->
        <script src="/public/js/jquery-ui.js"></script>
        <script src="/public/js/jquery-ui.min.js"></script>

        <!-- favicon -->
        <link rel="icon" href="{{ asset('/public/storage/img/ico_clock.gif') }}">
    </head>

    <body class="antialiased">
        <div style="width:600px; position:relative" class="p-3">

            <h3>問合せフォーム</h3>

            <div class="row mt-3">
                <div class="col-3">
                    <label for="name" class="col-form-label">氏名</label>
                </div>
                <div class="col-auto">
                    <input type="text" placeholder="氏名を入力してください" id="name" name="name"
                        class="form-control">
                    <div class="invalid-feedback name-error"></div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-3">
                    <label for="kana" class="col-form-label">氏名カタカナ</label>
                </div>
                <div class="col-auto">
                    <input type="text" placeholder="氏名カタカナを入力してください"
                    id="kana" name="kana" class="form-control">
                    <div class="invalid-feedback kana-error"></div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-3">
                    <label for="email" class="col-form-label">メールアドレス</label>
                </div>
                <div class="col-auto">
                    <input type="text" placeholder="メールアドレスを入力してください"
                    id="email" name="email" class="form-control">
                    <div class="invalid-feedback email-error"></div>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-3">
                    <label for="query">問合せ種別</label>
                </div>
                <div class="col-8">
                    <input class="form-check-input" type="radio" name="class" id="class_1" value="1">
                    <label class="form-check-label mr-2" for="class_1">
                        発送済み商品について
                    </label>
                    <input class="form-check-input" type="radio" name="class" id="class_2" value="2">
                    <label class="form-check-label" for="class_2">
                        注文前商品について
                    </label>
                    <div class="invalid-feedback class-error">選択してください</div>

                </div>
            </div>

            <div class="row mt-3">
                <div class="col-3">
                    <label for="day" class="col-form-label">回答希望日</label>
                </div>
                <div class="col-auto">
                    <input type="text" placeholder="回答希望日(任意)を入力してください"　name="date" id="date" class="form-control" readonly>
                    <div class="invalid-feedback date-error">正しい日付の形式で入力してください</div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-3">
                    <label for="query">問合せ内容</label>
                </div>
                <div class="col-8">
                    <textarea class="form-control" placeholder="問合せ内容を入力してください" id="query" name="query" rows="5"></textarea>
                    <div class="invalid-feedback query-error">正しい日付の形式で入力してください</div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-8 offset-3">
                    <button id="send" class="btn btn-success btn-block">送信</button>
                </div>
            </div>

            <div class="toast" style="position:absolute; top:10px; right:0;" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img id="success-icon" src="{{ asset('/public/storage/img/ico_light1.gif') }}" class="rounded mr-2" alt="...">
                    <img id="error-icon" src="{{ asset('/public/storage/img/ico_cone1.gif') }}" class="rounded mr-2" alt="...">
                    <strong class="mr-auto">株式会社○○</strong>
                    <small></small>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">修正後再度送信してください。</div>
            </div>

        </div>
    </body>
</html>
