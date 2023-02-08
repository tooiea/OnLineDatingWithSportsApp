<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h3 class="pb-3">招待チーム検索</h3>
        <div class="container">
            <h4 class="pb-3">気になる拠点</h4>
            <div>
                <form action="" method="get">
                    <div class="container mb-5">
                        <div class="form-group row d-flex justify-content-around">
                            <label for="prefecture" class="col-sm-3 col-form-label">都道府県</label>
                            <div class="col-sm-7">
                                <select name="prefecture" class="form-control @error('prefecture') is-invalid @enderror"
                                    id="prefecture" aria-describedby="nameHelp">
                                    <option value="" disabled selected>選択してください</option>
                                    @foreach (\App\Constants\FormConstant::PREFECTURES as $key => $value)
                                    <option value="{{ $key }}" @if(old('prefecture')==$key || $prefecture==$key)
                                        selected @endif>{{ $value
                                        }}
                                    </option>
                                    @endforeach
                                </select>
                                <small id="prefectureHelp" class="form-text text-muted">検索したいチームの都道府県を選択してください。</small>
                                @error('prefecture')<div class="invalid-feedback" role="alert"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row d-flex justify-content-around">
                            <label for="address" class="col-sm-3 col-form-label">市町村区</label>
                            <div class="col-sm-7">
                                <input type="text" name="address" value="{{ old('address')  . $address }}" id="address"
                                    aria-describedby="nameHelp"
                                    class="form-control @error('address') is-invalid @enderror" placeholder="例：宮崎市">
                                <small id="nameHelp" class="form-text text-muted">市町村区を入力してください。</small>
                                @error('address')<div class="invalid-feedback" role="alert"> {{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mt-5">
                            <input type="submit" value="検索する" class="btn btn-primary btn-lg btn-block">
                        </div>
                    </div>
                </form>
                <div class="container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>チーム名</th>
                                <th>チームの拠点</th>
                                <th>招待リンク</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teams as $key => $value)
                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $value->team_name }}</td>
                                <td>{{ \App\Constants\FormConstant::PREFECTURES[$value->prefecture] . $value->address }}
                                </td>
                                <td><a href="{{ sprintf(url(__('route_const.consent_link') . " %s"), $value->id)
                                        }}">{{ sprintf(url(__('route_const.consent_link') . "%s"), $value->id) }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $teams->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>