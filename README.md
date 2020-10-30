## Auto delivery system
### 受発注業務自動化WEBアプリ開発

### Programming Languages
`PHP`

### Frameworks
`Laravel`

### Environments
`Laradock` `MYSQL` `Sublime Text`

### Other Skills
`command task Scheduler` `Google Spreadsheet API` `Google Gmail API` `SplFileObject READ_CSV` `CSV streamDownload API`

## 機能説明
##### トップページ
![top](https://user-images.githubusercontent.com/68208676/96365974-8a13bc00-117f-11eb-90da-efd150a36813.jpg)

##### 倉庫業、商社様の毎日の作業を、自動化します。　複雑なロット管理も自動です。
##### 万が一在庫が足りなかった時は処理をストップし、データベースロールバックします。
##### 注文or在庫調整後、再度出荷指示を実行できます。
![main_function](https://user-images.githubusercontent.com/68208676/96365987-9d268c00-117f-11eb-9993-cd3f75a996f2.jpg)

##### CSV注文書、入荷品在庫登録画面　この2つを登録すれば、毎日10：00 に2日後の出荷指示を作成します。
![csv](https://user-images.githubusercontent.com/68208676/96367479-078ffa00-1189-11eb-9dbb-f03ce1ed5460.jpg)

##### スプレッドシートで生成された出荷指示書です。
![sheet](https://user-images.githubusercontent.com/68208676/96367882-65bddc80-118b-11eb-8c8a-f56e704a433f.jpg)

##### 出荷指示が完了したことを、関係者へメールでお知らせ。
![ok_maik](https://user-images.githubusercontent.com/68208676/96367879-635b8280-118b-11eb-9ec0-ad014b1e1ea9.jpg)

##### 在庫が足りなかった場合は、どのロットを最後に在庫が足りなくなったかお知らせ。
![ng_mail](https://user-images.githubusercontent.com/68208676/96367480-0ced4480-1189-11eb-922b-debec50f0456.jpg)

##### 必要に応じて手動で出荷指示することもできます。出荷日2日前より前に指示した場合は、定期連絡の時に再連絡します。
![temporary](https://user-images.githubusercontent.com/68208676/96367598-cd732800-1189-11eb-9ba2-5c99d155362b.jpg)

##### 出荷をキャンセルする機能もあります。（出荷指示の取消or返品処理)
![cancel](https://user-images.githubusercontent.com/68208676/96367591-c77d4700-1189-11eb-98af-31493e2615e1.jpg)

##### E-R図
![e-r](https://user-images.githubusercontent.com/68208676/96369021-702fa480-1192-11eb-9718-5102cca2d37f.jpg)

#### 画面設計
![views](https://user-images.githubusercontent.com/68208676/96368519-2abda800-118f-11eb-9129-e67286cdebc1.jpg)

#### フローチャート（自動出荷処理)
![flow](https://user-images.githubusercontent.com/68208676/96368522-2db89880-118f-11eb-814e-cda4539a6b19.jpg)