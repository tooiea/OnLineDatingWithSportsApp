document.addEventListener("DOMContentLoaded", () => {
    const url = "https://opendata.resas-portal.go.jp/api/v1/cities?prefCode";
    const api_key = "ZvDihyeuqc2GZEsVUUbI7nWt7sr9OQF1ztEXu5Hz"; // 自分のAPIキーを設定

    const input = document.getElementById("prefecture"); // 入力欄の要素を取得
    console.info(input);
    const list = document.getElementById("address"); // 補完リストの要素を取得
    console.info(list);

    // 都道府県名に対応する都道府県コードを取得する関数
    async function getPrefectureCode(prefectureName) {
        const response = await fetch("https://opendata.resas-portal.go.jp/api/v1/prefectures", {
            headers: { "X-API-KEY": api_key },
            type: "GET",
        });
        const data = await response.json();
        const prefecture = data.result.find(prefecture => prefecture.prefName === prefectureName);
        return prefecture.prefCode;
    }

    // 都道府県コードを指定して、市町村区のリストを取得する関数
    async function getCities(prefectureCode) {
        const response = await fetch(`${url}=${prefectureCode}`, {
            headers: { "X-API-KEY": api_key },
            type: "GET",
        });
        const data = await response.json();
        const cities = data.result.map(city => city.cityName);
        return cities;
    }

    // 入力欄にフォーカスがあたったときのイベントリスナーを設定
    input.addEventListener("focus", async () => {
        const prefectureName = input.value; // 入力値を取得
        const prefectureCode = await getPrefectureCode(prefectureName); // 都道府県名に対応する都道府県コードを取得
        if (prefectureCode) {
            const cities = await getCities(prefectureCode); // 市町村区のリストを取得
            console.info(cities);
            list.innerHTML = ""; // 補完リストをリセット
            cities.forEach(city => {
                const option = document.createElement("option");
                option.value = city;
                list.appendChild(option);
            });
        }
    });
});
