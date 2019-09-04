# 感情認識APIご利用ガイド

# 感情分析API
## API仕様
## 解析可能な音声ファイル
* 拡張子
wav, mp3, aiff, wma

* mimeタイプ
audio/x-wav, audio/mpeg, , audio/x-aiff, audio/x-ms-wma

* ファイルサイズ
上限：120MB

* 音声ファイルの長さ
上限：10分

## 月のリクエスト上限に達した場合
* APIはご利用いただけますが、超過リクエスト分の費用が発生いたします
* 超過した場合は、レスポンスにその旨のメッセージが返却されます

## エンドポイント
`https://api.pas-ta.io/feeling/v1`

## リクエスト

### URI
`[POST] https://api.pas-ta.io/feeling/v1/analysis`

### ヘッダー
|ヘッダー|値|サンプル|
|----|----|----|
|Content-Type|multipart/form-data | Content-Type: multipart/form-data|
|Authorization|Bearer <access_token> | Authorization: Bearer <access_token>|

### パラメータ
|パラメータ|型|説明|
|----|----|----|
|file|file|音声ファイル|

### cURL
```
curl -X POST <URI> -H 'Authorization: Bearer <AccessToken>' -F 'file=@/audio/sample.wav'
```

## レスポンス
|パラメータ|型|説明|
|----|----|----|
|code|数値|HTTPレスポンスコード|
|message|文字列|通常はsuccess。利用回数の上限に達していた場合は警告メッセージ（Usage upper limit exceeded）を表示する|
|results|配列|解析結果の配列|
|　id|数値|ID|
|　result|真偽|1区間の解析判定|
|　from|数値|解析区間の始点(秒)|
|　to|数値|解析区間の始点(秒)|
|　count|数値|解析区間中の解析できた数(0.1秒単位)|
|　feeling|数値|感情結果|
|　level|数値|感情段階レベル（lv.0弱〜lv.3強）|
|  clipping|数値|クリッピング(音割れ)有無（0=なし、1=あり）|
|　f1|数値|発話区間の声の周波数（だいたい250Hz以下なら男性）|
|　sps|数値|解析音源サンプリングレート|
|　bit|数値|解析音源量子化ビット深度|
|　msg|文字列|解析結果メッセージ|

```
{
	"code": 200,
	"results": [
		{
			"bit": 16,
			"clipping": 0,
			"count": 30,
			"f1": 1100,
			"feeling": "happy",
			"from": 0,
			"id": 0,
			"level": 4,
			"msg": "Process Successful",
			"result": true,
			"sps": 44100,
			"to": 3.5
		},
		{
			"bit": 16,
			"clipping": 0,
			"count": 2,
			"f1": 270,
			"feeling": "no result",
			"from": 3.9,
			"id": 1,
			"level": 4,
			"msg": "Not enough analyzed data",
			"result": true,
			"sps": 44100,
			"to": 4.1
		}
	],
	"status": {
		"limit": 50,
		"remaining": 20,
		"used": 30,
	},
	"message": "Usage upper limit exceeded"
}

```

### エラーレスポンス
|パラメータ|型|説明|
|----|----|----|
|code|数値|HTTPレスポンスコード|
|error|配列|エラー|
|　message|文字列|エラーメッセージ|

```
{
	"code": 401,
	"error": {
		"message": "Authorization failed"
	}
}
```

### 処理結果ステータス
|ステータス|メッセージ|説明|
|----|----|----|
|200|success|成功|
|400|uploadFile is required|リクエストの内容に誤りがあります|
|401|Authorization failed|認証ヘッダーがありません|
|403|For bidden|認証Tokenが誤っています|
|404|Not Found|リソースが見つかりません|
|405|Method Not Allowed|許可されていないメソッドです|
|413|File size limit exceeded|送信した音声ファイルのサイズが大きすぎます|
|413|Exceeded maximum number of seconds of sound source that can be analyzed|送信した音声ファイルの秒数が長すぎます|
|415|The file formats that can be analyzed are wav, mp3, aiff, wmv|送信した音声ファイルの形式が誤っています|
|415|The file extensions that can be analyzed are wav, mp3, aiff, wmv|送信した音声ファイルの拡張子が誤っています|
|500|Internal Server Error|サーバー内部エラーが発生しました|

# 利用状況確認API
## API仕様

## エンドポイント
`https://api.pas-ta.io/feeling/v1`

## リクエスト

### URI
`[GET] https://api.pas-ta.io/feeling/v1/status`

### ヘッダー
|ヘッダー|値|サンプル|
|----|----|----|
|Content-Type|application/json | Content-Type: application/json|
|Authorization|Bearer <access_token> | Authorization: Bearer <access_token>|

### cURL
```
curl -X GET <URI> -H 'Authorization: Bearer <AccessToken>'
```

## レスポンス
|パラメータ|型|説明|
|----|----|----|
|code|数値|HTTPレスポンスコード|
|results|オブジェクト|結果|
|　limit|数値|当月リクエスト上限数|
|　remaining|数値|当月リクエスト残数|
|　used|数値|当月リクエスト数|
```
{
	"code": 200,
	"results": {
		"limit": 50,
		"remaining": 20,
		"used": 30,
	}

```

### エラーレスポンス
|パラメータ|型|説明|
|----|----|----|
|code|数値|HTTPレスポンスコード|
|error|配列|エラー|
|　message|文字列|エラーメッセージ|

```
{
	"code": 401,
	"error": {
		"message": "Authorization failed"
	}
}
```

### 処理結果ステータス
|ステータス|メッセージ|説明|
|----|----|----|
|200|success|成功|
|401|Authorization failed|認証ヘッダーがありません|
|403|For bidden|認証Tokenが誤っています|
|404|Not Found|リソースが見つかりません|
|405|Method Not Allowed|許可されていないメソッドです|
|500|Internal Server Error|サーバー内部エラーが発生しました|

