# User microservice

## PHP framework
Lumen PHP Framework

## Test framework
PHPUnit

## Database
Mysql 5.7

## Docker Containers
-  **web** - Web application container (Ubuntu 20.04, php-fpm, nginx, composer)
-  **db** - MySQL container
-  **test-db** - MySQL container for testing.

## Setup Steps
If docker compose has not been installed, please follow this documentation to install it for your operational system.
https://docs.docker.com/compose/install/

1. Go to the folder you normally set up projects and run ```git clone git@github.com:yao9394/user-microservice.git```
2. Next, open a new terminal and run 
    ```
    cd user-microservice/
    ```
3. Run 
    ```
    docker-compose up --build
    ```
4. Open another terminal in the same folder and run 
    ```
    sudo ./setup.sh 
    ```
5. Visit http://localhost to see the version of Lumen

## User microservice user guide
This application consists of 5 API endpoints

1. List all users
    Get http://localhost/user
    - Response
    ```
    [
    {
        "id": 1,
        "name": "Mr. Johnson Strosin",
        "email": "zula62@example.com",
        "created_at": "2021-01-10T14:53:41.000000Z",
        "updated_at": "2021-01-10T14:53:41.000000Z"
    },
    {
        "id": 2,
        "name": "Travon Hartmann",
        "email": "gboehm@example.org",
        "created_at": "2021-01-10T14:53:41.000000Z",
        "updated_at": "2021-01-10T14:53:41.000000Z"
    },
    ]
    ```
2. Display a user
    Get http://localhost/user/1
    - Response
        ```
        {
            "id": 1,
            "name": "Mr. Johnson Strosin",
            "email": "zula62@example.com",
            "created_at": "2021-01-10T14:53:41.000000Z",
            "updated_at": "2021-01-10T14:53:41.000000Z"
        }
        ```
3. Add a new user
    Post http://localhost/user
    - Request
        ```
        {
            "name": "test",
            "email": "test123@test.com"
        }
        ```
    - Response
        ```
        {
            "name": "test",
            "email": "test123@test.com",
            "updated_at": "2021-01-10T15:26:58.000000Z",
            "created_at": "2021-01-10T15:26:58.000000Z",
            "id": 51
        }
        ```
4. Update a user
    Put/Patch http://localhost/user/update/{id}
    - Request (same as Add a new user)
    - Response (same as Add a new user)

5. Delete a user
    Delete http://localhost/user/delete/{id}
    - Request (same as Add a new user)
    - Response (same as Add a new user)

## Testing
In a terminal, run 
```
docker exec -it user-microservice_web_1 bash
```
and then
```
cd siteroot/
```
next
```
root@b76b9e1b8e17:/siteroot/siteroot# vendor/bin/phpunit 
PHPUnit 9.5.0 by Sebastian Bergmann and contributors.

......                                                              6 / 6 (100%)

Time: 00:00.712, Memory: 24.00 MB

OK (6 tests, 76 assertions)

```
