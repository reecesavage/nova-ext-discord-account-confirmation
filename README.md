# Discord Account Confirmation and Login - A [Nova](https://anodyne-productions.com/nova) Extension

<p align="center">
  <a href="https://github.com/reecesavage/nova-ext-discord-account-confirmation/releases/tag/v1.0.0"><img src="https://img.shields.io/badge/Version-v1.0.0-brightgreen.svg"></a>
  <a href="http://www.anodyne-productions.com/nova"><img src="https://img.shields.io/badge/Nova-v2.6+-orange.svg"></a>
  <a href="https://www.php.net"><img src="https://img.shields.io/badge/PHP-v5.3.0-blue.svg"></a>
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-red.svg"></a>
</p>

This extension allows allows game users to add their Discord Account to their profile. Once added the user can use Discord Auth or Nova Auth to login to the website. Also exposes an API to get the Game's Users' Names and their Discord IDs for reporting purposes.

This extension requires:

- Nova 2.6+
- Nova Extension [`jquery`](https://github.com/jonmatterson/nova-ext-jquery)

## Installation

### These instructions only cover the installation of this extension. There is far more involved in creating a Discord Bot and also an API to keep the Bot's Secret Key safe. If a Game Master or Fleet/Org wish to undertake the tasks of spinning up the backend services requires for this work please join the Sim Central discord server `https://discord.gg/simcentral` and message someone on the Hosting Support team.

- Copy the entire directory into `applications/extensions/nova_ext_discord_account_confirmation`.
- Add the following to `application/config/extensions.php`:
```
$config['extensions']['enabled'][] = 'nova_ext_discord_account_confirmation';
```
### Setup Using Admin Panel

- Navigate to your Admin Control Panel
- Choose Discord Account Confirmation under Manage Extensions
- Create Database Column by clicking "Create Column." Once column is added the message "All expected columns found in the database" will appear.
- Click Rotate API Token to create an API Token and store it.

Installation is now complete!

## Usage
### Assumed backend processes have been completed and Bot has been set via the API.

### Associate your Discord ID with your Nova Account.
- Login using Nova Auth.
- Navigate to the Control Panel.
- Under the User Section Click Discord Account.
- Click Get Auth and Authroize Discord to associate your account.
- You should now see your Discord ID in the text field. You account is now linked.

### Login with Discord - After the above steps have been completed.
- Navigate to the Nova Website Login Page.
- Click Login with Discord
- If promtped, authorize Discord to authenticate.
- You will be redirected to the Control Panel as normal.

## Issues

If you encounter a bug or have a feature request, please report it on GitHub in the issue tracker here: https://github.com/reecesavage/nova-ext-discord-account-confirmation/issues

## License

Copyright (c) 2022 Reece Savage of Sim Central.

This module is open-source software licensed under the **MIT License**. The full text of the license may be found in the `LICENSE` file.
