## 画像のダミーデータ
public/imagesフォルダ内に
sample1.jpg~sample7.jpgとして保存しています。

`php artisan storage:link`でstorageフォルダにリンク後、

`storage/app/public/pictures`フォルダ内に保存すると表示されます。

ショップ画像も表示する場合は、`storage/app/public/shops`フォルダを作成し
画像を保存してください。

## 決済
決済のテストとしてstripeを利用しています。
必要な場合は`.env`にstripeの情報を追記してください。

## メール
メールテストとしてmailtrapを利用しています。
必要な場合は、`.env`にmailtrapの情報を追記してください。

メール処理には時間がかかるので、キューを使用しています。

必要な場合は、`php artisan queue:work`でワーカーを立ち上げて
動作確認するようにしてください。