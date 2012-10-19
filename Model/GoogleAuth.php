<?php
/**
 * Google Auth Model
 * @url https://developers.google.com/accounts/docs/OAuth2
 * @url http://code.google.com/p/google-api-php-client/wiki/OAuth2
 */
class GoogleAuth extends AppModel
{
    public static function getClient()
    {
        $client = new apiClient();
        $client->setClientId(GOOGLE_CLIENT_ID);
        $client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);
        $client->setDeveloperKey(GOOGLE_DEVELOPER_KEY);

        return $client;
    }

    /**
     * 認証するためのGoogleのURLを取得する
     * このURLにリダイレクトすることでGoogleアカウントの認証画面を表示する
     */
    public static function getAuthUrl()
    {
        $client = self::getClient();
        $oauth2 = new apiOauth2Service($client);
        return $client->createAuthUrl();
    }

    /**
     * Googleアカウントの認証結果を確認する
     * ユーザが認証を拒否した場合はAuthDeniedExceptionを発生させる
     * 認証は成功しても指定されたドメイン|メールアドレスではない場合PermissionDeniedExceptionを発生させる
     */
    public static function verify($code)
    {
        if (!$code) {
            throw new InvalidArgumentException();
        }

        $client = self::getClient();
        $oauth2 = new apiOauth2Service($client);

        $client->authenticate();
        $token = $client->getAccessToken();

        $user = $oauth2->userinfo->get();
        if (!self::isAllowed($user)) {
            throw new PermissionDeniedException();
        }

        $user['email'] = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
        $user['token'] = $token;
        return $user;
    }

    /**
     * 指定されたドメイン|メールアドレスであるかを確認する
     */
    public static function isAllowed($user)
    {
        $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
        $tmp = explode('@', $email);
        $domain = array_pop($tmp);
        $is_set_allow_domains = true;
        $is_set_allow_emails = true;

        $allow_domains = explode(',', GOOGLE_ALLOW_DOMAINS);
        if (current($allow_domains) == '') {
            $is_set_allow_domains = false;
        }
        foreach ($allow_domains as $v) {
            if ($domain === trim($v)) {
                return true;
            }
        }

        $allow_emails = explode(',', GOOGLE_ALLOW_EMAILS);
        if (current($allow_emails) == '') {
            $is_set_allow_emails = false;
        }
        foreach ($allow_emails as $v) {
            if ($email === trim($v)) {
                return true;
            }
        }

        if (!$is_set_allow_domains && !$is_set_allow_emails) {
            return true;
        }

        return false;
    }
}
