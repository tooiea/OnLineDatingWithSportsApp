$(function () {

    // 「科目」のセレクトボックスが変更された場合

    $('#prefecture').on('change', function () {
        // value属性の値を取得
        let prefecture_val = $(this).val();

        // tag_name_valをHomeControllerへ渡す
        $.ajax({
            headers: {
                'X-API-KEY': 'ZvDihyeuqc2GZEsVUUbI7nWt7sr9OQF1ztEXu5Hz'
            },
            type: "GET",
            url: "https://opendata.resas-portal.go.jp/api/v1/cities?prefCode",
            dataType: "JSON",
            data: {
                prefCode: prefecture_val
            }
        })
            .done(function (data) {
                // 初期化
                $('#city > option').remove();
                $('#city').append($('<option>').html("選択してください").val(""));
                $.each(data['result'], function (index, value) {
                    // コントローラ側で取得した課題のデータをセレクトボックスに追加する
                    $('#city').append($('<option>').val(value.cityName).text(value.cityName));
                })
            })
            .fail(function () {
                // 失敗した際の処理を記述
            })

    })

})
