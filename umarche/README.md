##画像のダミーデータ
public/imagesフォルダ内に
sample1.jpg~sample7.jpgとして保存しています。

php artisan storage:linkでstorageフォルダにリンク後、

storage/app/public/picturesフォルダ内に保存すると表示されます。

ショップ画像も表示する場合は、storage/app/public/shopsフォルダを作成し
画像を保存してください。

##決済
決済のテストとしてstripeを利用しています。
必要な場合は.envにstripeの情報を追記してください。

##メール
メールテストとしてmailtrapを利用しています。
必要な場合は、.envにmailtrapの情報を追記してください。

メーリ処理には時間がかかるので、キューを使用しています。

必要な場合は、php artisan queue:workでワーカーを立ち上げて
動作確認するようにしてください。