$(function(){
    var sendOk = false; // 要る？
    const messages = {
        name:{required:'氏名 の入力は必須です。'},
        kana:{required:'氏名カタカナ の入力は必須です。',regex:'全角カタカナで入力してください。'},
        email:{required:'メールアドレス の入力は必須です。', regex:'メールアドレスの形式で入力してください。'},
        class:{required:'問合せ種別 の選択は必須です'},
        date:{regex:'正しい日付の形式で入力してください。'},
        query:{required:'問合せ内容 の入力は必須です。'}

    }


    // 送信不可にする
    function disableSend() {
        $('#send').prop('disabled',true);
    }
    // ロード時は非活性にしておく。
    disableSend();

    // カレンダーの日本語化
    $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );

    $('#date').datepicker({
        dateFormat: 'yy/mm/dd(D)',
        firstDay: 1, //0?6　0が日曜、1が月曜、2が火曜・・・・6が土曜
        // monthNames:
        changeMonth: true,
        changeYear: true,
        //   yearRange: '-2:+6',
        minDate: '-1w',
        maxDate: '+1m +10d',
        //   maxDate: '+1y',
        selectOtherMonths: true
    });

    // 入力フォームの空チェック
    function emptyCheck(inputBody,emptyMessage){
        if(inputBody.val().trim() == "") {
            $(inputBody).removeClass('is-valid');
            $(inputBody).addClass('is-invalid');
            $(inputBody).parent().find('.invalid-feedback').text(emptyMessage);
            return true;
        }
        return false;
    }


    // 全角カナの判定
    function isZenkakuKana(str) {
        ('str: ' + str);
        return str.match(/^[ァ-ヶー　]*$/u);  // 「　」は全角スペースです.
    }

    // メールアドレスの判定
    function isValidMail(mailAddress) {
        var reg = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
        return mailAddress.match(reg);
    }

    // 日付の判定
    function isValidDate(date) {
        var reg = /^\d{4}\/\d{2}\/\d{2}\(.\)$/u;
        return date.match(reg);
    }


    // 送信可能な状態か確認する
    function checkForm() {
        // エラー箇所があったら非活性のまま
        if($('.is-invalid').length > 0) {
            return;
        }
        // 必須項目が入力されているか
        if($('#name').val() == "" || $('#kana').val() == ""
        || $('#email').val() == "" || $('input[name="class"]:checked').val() == undefined
        || $('#query').val() == "") {
            $('#send').prop('disabled', true);
            return;
        }

        // 送信ボタンを活性化
        $('#send').prop('disabled', false);
    }

    // 適性な入力であることを表示する
    function addValidProp(inputBody) {
        inputBody.removeClass('is-invalid');
        inputBody.addClass('is-valid');
        inputBody.parent().find('.invalid-feedback').text('');
    }

    // 入力エラーであることを表示する
    function addInvalidProp(inputBody,displayMessage) {
        inputBody.addClass('is-invalid');
        inputBody.removeClass('is-valid');
        inputBody.parent().find('.invalid-feedback').text(displayMessage);
    }

    // 「氏名」の入力チェック内容
    function nameCheck(nameForm) {
        var resultEmpty = emptyCheck(nameForm,messages['name']['required']);
        if(resultEmpty){
            disableSend();
            return;
        }
        addValidProp(nameForm)
    }

    // 「氏名」の入力チェック
    $('#name').keyup(function() { nameCheck($(this)) });
    $('#name').change(function() { nameCheck($(this)) });


    // 「氏名カタカナ」の入力チェック内容
    function kanaCheck(kanaForm) {
        var resultEmpty = emptyCheck(kanaForm,messages['kana']['required']);
        if(resultEmpty){
            disableSend();
            return;
        }
        if(isZenkakuKana(kanaForm.val())) {
            addValidProp(kanaForm, messages['kana']['required']);
            checkForm();
            return;
        }
        addInvalidProp(kanaForm, messages['kana']['regex']);
        disableSend();
    }

    // 「氏名カタカナ」の入力チェック
    $('#kana').keyup(function(){ kanaCheck($(this)) });
    $('#kana').change(function(){ kanaCheck($(this)) });

    // 「メールアドレス」の入力チェック内容
    function emailCheck(emailForm) {
        var resultEmpty = emptyCheck(emailForm,messages['email']['required']);
        if(resultEmpty){
            disableSend();
            return;
        }
        if(isValidMail(emailForm.val())) {
            addValidProp(emailForm);
            checkForm();
            return;
        }
        addInvalidProp(emailForm, messages['email']['regex']);
        disableSend();
    }

    // 「メールアドレス」の入力チェック
    $('#email').keyup(function() { emailCheck($(this)) });
    $('#email').change(function() { emailCheck($(this)) });



    // 「問合せ種別」の選択チェック
    $('input[name="class"]').change(function() {
        $(this).parent().find('input').each(function() {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
        });
        $(this).parent().find('.invalid-feedback').text('');
        checkForm();
    });

    // 「回答希望日」の入力チェック
    $('#date').change(function(){
        if(isValidDate($(this).val())) {
            addValidProp($(this));
            checkForm();
            return;
        }
        addInvalidProp($(this), messages['date']['regex']);
        disableSend();
    });


    // 「問合せ内容」の入力チェック内容
    function queryCheck(queryForm) {
        var resultEmpty = emptyCheck(queryForm, messages['query']['required']);
        if(resultEmpty){
            disableSend();
            return;
        }
        addValidProp(queryForm);
        checkForm();
    }

    // 「問合せ内容」の入力チェック
    $('#query').keyup(function(){ queryCheck($(this)) });
    $('#query').change(function(){ queryCheck($(this)) });



    // 送信ボタン押下
    $('#send').click(function() {
        // 連打防止
        // disableSend();

        var date = "";
        if($('#date').val() != ""){
            var split_calender = $('#date').val().split('/');
            var date = split_calender[0] + split_calender[1] + split_calender[2].replace(/\(.\)/g,'');
        }

        var postData = {
            'name': $('#name').val(),
            'kana': $('#kana').val(),
            'email': $('#email').val(),
            'class': $('input[name="class"]:checked').val(),
            'date': date,
            'query': $('#query').val()
        }

        // var dataKeys = Object.keys(postData);

        // submit時のajax
        $.ajax({
            type: 'GET',
            url: '/api/query',
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            dataType : 'json',
            data: postData,
        }).done(function(res) {
            if(res['data']['success']) {
                // トースト表示（成功ver)
                $('#success-icon').show();
                $('#error-icon').hide();
                $('.toast-body').addClass('error').text('問合せ完了しました。');
                $('.toast').css({'opacity' : 1}).animate({opacity: 0,},4000);

                return;
            }

            var errors = res['data']['errors'];

            $.each(errors, function(key,index) {
                if(key != 'class'){
                    // エラークラスを追加
                    var inputSelector = `#${key}`;
                    $(inputSelector).addClass('is-invalid');
                } else {
                    var inputSelector = `#${key}_1,#${key}_2`;
                    $(inputSelector).addClass('is-invalid');
                }
                // エラーメッセージを表示
                var messageSelector = `.${key}-error`;
                $(messageSelector).text(errors[key]);

            });

            // トースト表示（エラーver)
            $('#success-icon').hide();
            $('#error-icon').show();
            $('.toast-body').addClass('error').text('修正後再度送信してください。');
            $('.toast').css({opacity : 1})
            .animate({
                opacity: 0,
            },4000);

        }).fail(function() {
            alert('ページエラーが発生しました。');
        })
    });

});
