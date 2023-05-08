document.getElementById("button-send").addEventListener("click", function () {
    submitMessage();
});

// フォームの送信ボタンがクリックされたときに実行される関数
function submitMessage() {
    // フォームの入力内容を取得
    var message = document.getElementById("message").value;

    // metaタグのcsrfトークンを取得
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // LaravelのルートにPOSTリクエストを送信するためのURLを指定
    var url = "/api/message/reply";

    // Ajax通信を開始
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // CSRFトークンをヘッダーに設定

    // レスポンスが返ってきた時の処理
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // レスポンスから返ってきたデータを取得
            var response = JSON.parse(xhr.responseText);

            // メッセージ一覧を更新
            updateMessageList(response.messages);

            // 入力フォームを空にする
            document.getElementById("message").value = "";
        }
    }

    // リクエスト本体を作成して送信
    var data = JSON.stringify({ message: message });
    xhr.send(data);
}

// メッセージ一覧を更新する関数
function updateMessageList(messages) {
    var messageList = document.getElementById("message-list");
    messageList.innerHTML = "";

    messages.forEach(function (message) {
        var li = document.createElement("li");
        li.textContent = message;
        messageList.appendChild(li);
    });
}
