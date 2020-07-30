# Smarty デザインテンプレート開発環境

GMO MakeShop、カラーミーショップのデザインテンプレート開発環境です。(非公式)

## セットアップ

```
$ cd makeshop-smarty/
$ docker-compose up
```

localhost:8080 でアクセス

### 一部 Linux 環境で Permission Error が発生する件

一部の Linux 環境ではコンテナ内の Apache 実行ユーザーをコンテナ実行ユーザーに合わせる必要があります。

```bash
$ docker exec -it makeshop-smarty_php_1 bash
$ usermod -u 1000 www-data ; groupmod -g 1000 www-data ; /etc/init.d/apache2 reload
```

## ディレクトリ構成

`html`ディレクトリ内に`theme`ディレクトリを作成し、データファイル(.json)、テンプレート(.tpl)を配置します。

- app/
- html/
  - **theme/**
    - assets/
      - style.css
    - **data/** : テンプレートから呼び出すデータ
      - data1.json
      - data2.json
      - data3.json
      - ...
    - **templates/** : テンプレートファイル
      - module/ : モジュール (テンプレートから`{$module.header}`等で呼び出し可能)
        - header.tpl
        - footer.tpl
        - side_bar.tpl
        - ...
      - page1.tpl
      - page2.tpl
      - page2.tpl
      - ...
  - .htaccess
  - index.php
  - makeshop.php

`theme/`以下のファイルには`/`でアクセス可能です。

## サンプル

### データファイル (data.json)

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

### テンプレート (top.tpl)

```html
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title><{$page.title}></title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="<{$page.css}>" />
  </head>
  <body></body>
</html>
```

## License

MIT
