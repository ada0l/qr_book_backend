QR's
====

```
sudo docker-compose build
sudo docker-compose up
```

# Basic Auth
Service supports Basic Auth. For example

```
curl --user andrew@dvfu.ru:123 https://locahost/user
```

# Endpoints

```
GET /user - return profile of current user
```

```
POST /user - create new user. Required fields is email, name, password.
```
