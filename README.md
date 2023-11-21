# PHP-Key-Panel
Key control panel written in HTML, CSS, JS, PHP
__Our panel has many functions, creating a key, binding a unique identifier (HWID), unbinding HWID, freezing / unfreezing keys, as well as deleting them. The panel is equipped with a convenient and intuitive interface.__
![Снимок экрана (5272)](https://github.com/Oifox/PHP-Key-Panel/assets/77205519/67370c4c-162f-4f35-81d2-3c63ee024a6e)

## Get started
You will need access to the server and MySQL, so we download all the files from the repository and copy to your server
### MySQL setup
Go to your database, go to the **SQL** tab and enter this command, then click **Go** at the bottom of the page and your structure will be ready.
```sql
CREATE TABLE new_table_name (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) NOT NULL,
    `hwid_bound` BOOLEAN NOT NULL DEFAULT FALSE,
    `bound_hwid` VARCHAR(255) NULL
    `expiry_date` DATE NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `frozen` BOOLEAN NOT NULL DEFAULT FALSE,
    `freeze_date` DATE NULL
);
```
The structure should look something like this:
![photo_2023-11-21_17-26-16](https://github.com/Oifox/PHP-Key-Panel/assets/77205519/1edb8c97-3dff-418c-a83d-610f9684ab83)

### PHP MySQL connection
Open the **db_config.php** file and see the configuration lines for connecting the database:
~~~php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_dbname";
~~~
Fill these lines with your table data

### Key verification request
To send a request to check the existence of a key, we make the following request to your host:
```https://localhost/check_key.php?key=XXXX-XXXX-XXXX&hwid=DEVICE_ID```
It sends the **key** and **hwid** in parameters to check for existence in the database
