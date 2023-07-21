Further development has been [moved to Codeberg](https://codeberg.org/personachat/webui).

# PersonaChat webUI

A basic webUI for PersonaChat, based on the original (deprecated) webUI.

## Major Differences from Old UI

 * Written in PHP rather than Python
 * Supports authentication (login)
 * Supports chat history
 * Uses a server-side proxy so you can expose the PHP side without exposing the inference API by setting the API to 127.0.0.1.

# Notice
PersonaChat is still in beta and should not be used in production. If you like this project or want further development, **please star this repository (and the [main repository](https://github.com/personachat/PersonaChat)).** The authors of this project also work on many other projects, so stars will prompt us to continue working on this project.

## Screenshots

These screenshots may be out of date.

### Landing Page

<img width="500" alt="pchat_home" src="https://github.com/personachat/webui/assets/76186054/a667bea5-1f16-4842-befe-f01039eb8bc1">

### Dashboard

<img width="500" alt="pchat_dash" src="https://github.com/personachat/webui/assets/76186054/a189344d-735e-4616-922a-1199d5646bb4">

### Chat UI

<img width="500" alt="pchat_chat" src="https://github.com/personachat/webui/assets/76186054/5f49584c-65ce-4c57-90c3-a6d16ff9fba5">

## Usage

1. Start your PHP server in the home directory
2. Clone the [main repository](https://github.com/personachat/PersonaChat), navigate to the `pc_api` directory in your CLI, and run the `main.py` script. Please read the instructions in README of the main repository for information regarding model downloads.
3. Run the `INSTALL.sql` script in your database.
4. Modify `config.php` with your API endpoint and database setup.

## Important

An API endpoint is required to run this webUI!

The API endpoint code is located in the `pc_api` folder of the [main repository](https://github.com/personachat/PersonaChat)

Set the API endpoint in `config.php`

## Warning

The API endpoint does not use authentication. Please don't use this in a production environment unless you're fine with random people using your server for model inference (including for non-chat purposes)!
