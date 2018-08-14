# IQRA (School Management System)

The purpose of this project to provide web service to for school record management.

## Getting Started

### Pre-requisites

Following is the list of pre-requisites:-
```
- PHP >= 7.0.x
- Apache 2.4.7 with mod_rewrite module (should be enabled)
- mySQL database >= 5.6
- Redis
- Git
- Composer
```
### Required Extensions
```
- Curl
- MCrypt
- OpenSSL
- PDO
- Mbstring
- Tokenizer
- Imap
```
### Installing

Perform following steps for local setup:

1- Clone project by running the following command.

	$ git clone git@bitbucket.org:adnansiddiq/iqra-backend.git
	
2- Create a mysql database and use that database credentials in the next step 

3- Project root have a file with name .env.example, create a copy of that file with name .env and change .env file as per your credentials

#### DB credentials
    		DB_HOST = HOST
    		DB_DATABASE = DB Name
    		DB_USERNAME = Username
    		DB_PASSWORD = password

4- Open console, go to project's root directory (project-directory/VOE) and run the following command to install all package dependencies

    $ composer install
	
5- for setting up migration 

    php artisan migrate
    
6- Make following folders in public with write permissions.

      app
      
7- Following directories should be writable by your web server
    
     storage
     bootstrap/cache
     
8- Create a virtual host and map on document root, DocumentRoot of VoE is public folder.

	PATH/PROJECT-NAME/public

9- Api Docs POSTMAN.

    Import from: https://www.getpostman.com/collections/5f5c37f264bd63a213d0
    Direct View: https://documenter.getpostman.com/view/706841/collection/RVnVDzsS

## Other Information
### Setup Cron
      no cron job yet
### Cron details

    nothing
    
## Deployment

Git Deployment Process

## Packages

- JWT-Auth

## Versioning/Branches

See [branches detail](https://bitbucket.org/adnansiddiq/iqra-backend/branches/)

## Authors

- [Adnan Siddiq](https://bitbucket.org/adnansiddiq) *Working*

