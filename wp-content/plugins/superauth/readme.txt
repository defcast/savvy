=== SuperAuth Passwordless Authentication===
Contributors: SuperAuth
Donate link: http://www.doctorswithoutborders.org/
Tags: username, password, passwords, no, fingerprint, superauth, auth, web, app, login, push, notification, android, iOS, windows, iPhone, iPad, phone, mobile, smartphone, computer, oauth, sso, authentication, encryption, ssl, secure, security, strong, harden, single sign-on, signon, signup, signin, login, log in, wp-login, 2 step authentication, two-factor authentication, two step, two factor, 2-Factor, 2fa, two, tfa, mfa, qr, multi-factor, multifactor
Requires at least: 4.0
Tested up to: 4.9.x
Stable tag: 1.1.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

SuperAuth is the truly passwordless authentication system. No passwords, no usernames, no typing, nothing to forget, and completely secure.

== Description ==

Are you looking for passwordless login? [SuperAuth](https://SuperAuth.com) helps your user to login without username and password with patent pending view and verify 2 factor authentication. Start passwordless login in your websites or apps within 30 seconds.

SuperAuth is focused on ease of integration, ease of use, and extensibility. SuperAuth also ensures that your site is secured and protected from phishing.

You can easily add or remove SuperAuth plugin without disturbing your user management. SuperAuth plugin works with your existing users also. 

You get mobile notification when new user logged in.

https://www.youtube.com/watch?v=K8yALTahBkI

https://www.youtube.com/watch?v=rAeueEqQmwU

= SuperAuth Features =
- **No password required**: Heck, user never USE a password or username ever again!

- **Easy integration**: No need to change your database or existing user management systems. SuperAuth users map seamlessly onto your existing users. 

- **No more 2 factor auth**: Integrated with patent pending view and verify 2 factor auth.

- **No phone? No problem**: If user don't have your phone, we'll send a temporary login link, which expires in 10 minutes, to user email. Using that link, user can login to your site.

- **Notification**: You can get mobile phone notification when new user logged into your website.

= SuperAuth Security =
SuperAuth uses a combination of best-of-breed security measures to ensure your data is secure. Our patent-pending technology encrypts every step of the authentication process. We check that both the app and the server are who they say they are, and we prove it to you with a quick visual check.

- SuperAuth never stores complete user data either in our server or in user mobile phone. Our patent pending algorithm keeps the data safe.

- The SuperAuth system doesn't only check to see if you are who you say you are. Our app also challenges the system it's trying to log into. This means that it's impossible to be ["phished"](https://en.wikipedia.org/wiki/Phishing) by fake websites trying to steal you data.

- Users verifies their website login location from the app. We never store or tracks the user location and just used for verification.

- Users verifies 2 factor token displayed in both app and website. No more typing.

- If user lost the phone, s/he can simply verify the email address from another phone. This step removes the data from old phone. 

= More Information =

Visit the <a href="https://superauth.com/">SuperAuth website</a> for documentation and support.

== Installation ==

https://www.youtube.com/watch?v=rAeueEqQmwU

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
2. Search for 'SuperAuth'
3. Activate SuperAuth from your Plugins page.

= From WordPress.org =

1. Download SuperAuth.
2. Upload the 'SuperAuth' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
3. Activate SuperAuth from your Plugins page.

= Once Activated =

Visit 'Settings > SuperAuth' and configure client id and client secret key.

1. Login to [SuperAuth.com](https://SuperAuth.com) and register your website under webapps to get API credentials.
2. During webapp creation, specify the return URL as specified in WordPress SuperAuth plugin setting page.
3. Get the client id and secret key. Configure in WordPress SuperAuth plugin setting page.

= Once Configured =

* You will see the SuperAuth login button in the login and register page.
* You can also use [superauth] shortcode to add the login button.

If you need any support, please <a href="https://superauth.com/#contact">contact us.</a>

== Frequently Asked Questions ==

= Are the SuperAuth app and plugin free? =

Yes. SuperAuth mobile app is FREE. Basic free tier allows unlimited authentication in any WordPress site.

= Will this work on WordPress multisite? =

Yes! If your WordPress installation has multisite enabled, each site needs to be configured with separate SuperAuth API credentials.

= Do you need 2 factor authentication? =

SuperAuth login uses patent pending show and verify 2 factor authentication. You do not need additional 2 factor authentication.

= Can I use my existing WordPress theme? =

Yes! SuperAuth works with nearly every WordPress theme.

= Where can I get support? =

Our community provides free support at <a href="https://superauth.com/#contact">https://SuperAuth.com</a>.

= Where can I report a bug? =

Report bugs and suggest ideas at <a href="https://superauth.com/contactus">https://superauth.com/contactus</a>.

== Screenshots ==

1. **Login Page** - WordPress login page integrated with SuperAuth passwordless login.
2. **SuperAuth Settings** - Easy integration. Just specify your API credentials in the SuperAuth settings page.
3. **Sample Website** 

== Upgrade Notice ==

= 1.1.1 =
* Add an action after wp login method.

= 1.1.0 =
* Fix to work with other security plugins.

= 1.0.0 =
* Initial version.

== Changelog ==

= 1.1.1 =
* Add an action after wp login method.

= 1.1.0 =
* Fix to work with other security plugins.

= 1.0.0 =
* Initial version.
