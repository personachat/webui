# PersonaChat webUI
The new GUI for PersonaChat

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