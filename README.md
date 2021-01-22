# LTW 2020/2021 - Buddy Resc

## Group G73 elements

| Name                 | Number    | E-Mail             |
| -------------------- | --------- | ------------------ |
| Daniel Garcia Silva  | 201806524 |up201806524@fe.up.pt|
| Mariana Truta        | 201806543 |up201806543@fe.up.pt|
| Miguel Azevedo Lopes | 201704590 |up201704590@fe.up.pt|
| Rita Peixoto         | 201806257 |up201806257@fe.up.pt|

----
# Credentials (username/password (role))
* MariaMariana/1234 (user)
* JohnDoe/1234 (user)
* KanKan/1234 (user)
* SafeHome/1234 (shelter)
* ArkansasAnimals/1234 (shelter)


----
# Libraries:
- FontAwesome was used to add icons to the project
- GoogleFonts   

----
# Features:
 - Security
     - XSS: yes
     - CSRF: yes
     - SQL using prepare/execute: yes
     - Passwords: created and verified with php's password_hash and password_verify, using bcrypt
     - Data Validation: regex / php / html (type of the file) / javascript (regex, not empty and file size)
 - Technologies
     - Separated logic/database/presentation: yes
     - Semantic HTML tags: yes
     - Responsive CSS: yes
     - Javascript: yes
     - Ajax: yes
     - REST API: no
     - Other:
  Usability:
     - Error/success messages: yes
     - Forms don't lose data on error: in some of them


----
# Aditional notes:
The database schema and population can be found in the database/buddy-resc.sql file. This file includes a few examples for each sql table.
Also, because of the photo upload handling do not forget to uncomment the "extension=gd" line on php.init file.

[Mockups](documentation/Mockups.pdf)

[Database Schema Initial Draft](documentation/database.png)

[Database Schema](documentation/database_schema.png)
