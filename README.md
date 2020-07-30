# Smarty デザインテンプレート開発環境

GMO MakeShop、カラーミーショップのデザインテンプレート開発環境です。(非公式)

## セットアップ

```
$ git clone https://github.com/do-mu-oi/makeshop-smarty.git
$ cd makeshop-smarty/
$ docker-compose up
```

localhost:8080 でアクセス

### 一部 Linux 環境で Permission Error が発生する件

一部の Linux 環境ではコンテナ内の Apache 実行ユーザーをコンテナ実行ユーザーに合わせる必要があります。

```bash
$ docker exec -it makeshop-smarty_php_1 bash
# コンテナ実行ユーザー 1000:1000 の場合
$ usermod -u 1000 www-data ; groupmod -g 1000 www-data ; /etc/init.d/apache2 reload
```

## ディレクトリ構成

`html/theme/data/`以下にデータファイル(.json)、`html/theme/templates/`以下にテンプレートファイル(.tpl)を配置します。

- html/ : Apache document root
  - **theme/**
    - **data/** : テンプレートから呼び出すデータ
      - data1.json
      - data2.json
      - data3.json
      - ...
    - **templates/** : テンプレートファイル
      - module/ : モジュール (テンプレートから`{$module.header}`等で呼び出し)
        - header.tpl
        - footer.tpl
        - side_bar.tpl
        - ...
      - page1.tpl
      - page2.tpl
      - page2.tpl
      - ...

`theme/`以下のファイルには`/`以下でアクセス可能です。(例: `theme/assets/style.css` -> `/assets/style.css`)

## サンプル

### データファイル (html/theme/data/data.json)

```json
{
  "page": {
    "title": "デザインテンプレート開発環境",
    "css": "/assets/style.css"
  },
  "shop": {
    "name": "ショップ名"
  }
}
```

上記pageとshopは別ファイルに分割することも出来ます。

#### data1.json

```json
{
  "page": {
    "title": "デザインテンプレート開発環境",
    "css": "/assets/style.css"
  }
}
```

#### data2.json

```json
{
  "shop": {
    "name": "ショップ名"
  }
}
```

### テンプレート (html/theme/templates/top.tpl)

```html
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title><{$page.title}></title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="<{$page.css}>" />
  </head>
  <body><{$module.header}></body>
</html>
```

### テンプレートモジュール (html/theme/templates/module/header.tpl)

```html
<h1><{$shop.name}></h1>
```

## License

MIT License
