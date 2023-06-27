function previewAlbumImages() {
    var preview = document.getElementById("albumPreview");
    preview.innerHTML = ""; // 一度プレビューをクリア

    var files = document.getElementById("teamAlbumAdd").files;

    function readAndPreview(file) {
        // 画像ファイルであることを確認
        if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
            var reader = new FileReader();

            reader.addEventListener("load", function () {
                var image = new Image();
                image.height = 60; // プレビュー画像の高さを設定
                image.title = file.name;
                image.src = this.result;
                preview.appendChild(image);
            });

            reader.readAsDataURL(file);
        }
    }

    if (files) {
        [].forEach.call(files, readAndPreview);
    }
}

document.getElementById("teamAlbumAdd").addEventListener("change", previewAlbumImages);


function previewImages(event) {
    event.preventDefault(); // フォームのデフォルトの送信動作をキャンセル

    var preview = document.getElementById("imagePreview");
    preview.innerHTML = ""; // 一度プレビューをクリア

    var files = document.getElementById("teamLogo").files;

    function readAndPreview(file) {
        // 画像ファイルであることを確認
        if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
            var reader = new FileReader();

            reader.addEventListener("load", function () {
                var image = new Image();
                image.height = 60; // プレビュー画像の高さを設定
                image.title = file.name;
                image.src = this.result;

                // 元のimgタグを取得し、src属性を変更する
                var originalImage = document.querySelector("#teamLogoImage");
                originalImage.src = image.src;

                // 注意文言とキャンセルボタンの表示を制御
                var noticeText = document.getElementById("updateNoticeText");
                var cancelButton = document.getElementById("cancelUploadButton");
                if (noticeText && cancelButton) {
                    noticeText.style.display = "block"; // 表示する
                    cancelButton.style.display = "inline"; // 表示する
                }
            });

            reader.readAsDataURL(file);
        }
    }

    if (files) {
        [].forEach.call(files, readAndPreview);
    }
}

document.getElementById("teamLogo").addEventListener("change", previewImages);

document.getElementById("cancelUploadButton").addEventListener("click", function (event) {
    event.preventDefault(); // ボタンのデフォルトのクリック動作をキャンセル

    // 元のimgタグのsrc属性を元の画像に戻す
    var originalImageUrl = document.getElementById("teamLogoImage").getAttribute("data-original-url");
    document.getElementById("teamLogoImage").src = originalImageUrl;

    // input要素の値を空にすることで選択したファイルをクリア
    document.getElementById("teamLogo").value = "";

    // 注意文言とキャンセルボタンの表示を制御
    var noticeText = document.getElementById("updateNoticeText");
    var cancelButton = document.getElementById("cancelUploadButton");
    if (noticeText && cancelButton) {
        noticeText.style.display = "none"; // 非表示にする
        cancelButton.style.display = "none"; // 非表示にする
    }
});

