# candycane-google-auth

CcGoogleAuthは、CandyCaneでGoogle Authによるログインを可能にするプラグインです。
許可するドメインやe-mailを指定できるので、Google Appsで運用している企業の
イントラ運用に効果を発揮します。

## 使い方
Google APIs ( https://code.google.com/apis/console/ )に登録する。
管理者でログインし、Settingsから、Google Auth Pluginに必要な項目を入力する。
(Google Redirect URIはhttps/httpに注意。例: http://example.com/candycane/cc_google_auth/accounts/login )

