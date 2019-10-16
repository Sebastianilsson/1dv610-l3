# 1dv610 assignment 3

## Run the application localy
In the following instructions I will assume that you have XAMPP installed. If you don't have XAMPP installed and would like to follow my instructions you can download and install the verion for your OP from [here](https://www.apachefriends.org/download.html). There are lots of other ways to run PHP applications localy and think my instuctions can help you even if you have got another setup.

1. Open XAMPP Controll Panel and start Apache and MySQL
![xampp control panel](https://user-images.githubusercontent.com/38331503/66950848-7956d480-f059-11e9-9e4c-dd4cb0b12aac.png)
2. Open your browser and open [phpMyAdmin](http://localhost/phpmyadmin) on localhost
3. Click on Databaser and create a new database by filling in a database name and clicking Skapa
![creating a new database](https://user-images.githubusercontent.com/38331503/66951008-c63aab00-f059-11e9-830c-8304ceca82e2.png)
4. Click on the name of the database that you created in the list to the left on the screen.
5. We are going to create four tables in our database by executing SQL-querys in the database.
6. Click on SQL fill in the SQL-querys one by one and click Kör.
SKA DET STÅ SESSIONS ELLER COOOKIES???
  * `CREATE TABLE users ( id int(5) AUTO_INCREMENT PRIMARY KEY NOT NULL, username TINYTEXT NOT NULL, password LONGTEXT NOT NULL );`
  * `CREATE TABLE sessions ( id int(5) AUTO_INCREMENT PRIMARY KEY NOT NULL, username TINYTEXT NOT NULL, password LONGTEXT NOT NULL );`
  * `CREATE TABLE posts ( id int(5) AUTO_INCREMENT PRIMARY KEY NOT NULL, username TINYTEXT NOT NULL, postTitle TEXT NOT NULL, postText LONGTEXT NOT NULL, timeStamp TINYTEST NOT NULL);`
  * `CREATE TABLE comments ( id int(5) AUTO_INCREMENT PRIMARY KEY NOT NULL, username TINYTEXT NOT NULL, commentText LONGTEXT NOT NULL, timeStamp TINYTEST NOT NULL, postId TINYTEXT NOT NULL,);`
  ![where to execute sql-querys](https://user-images.githubusercontent.com/38331503/66952295-a789e380-f05c-11e9-8e54-fbcffcb9995b.png)
