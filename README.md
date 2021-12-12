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

## user

```
GET /user - return profile of current user
```

```
POST /user - create new user. Required fields is email, name, password.
```

```
PUT /user - update authorized user. Required fields is email, name.
```

## qr's

```
GET /qr - get list of qr's of user.
```

```
GET /qr?id=10 - get qr of user, whose id is 10.
```

```
POST /qr - create new qr.
```

```
PUT /qr?id=10 - update qr of user, whose id is 10.
```

```
DELETE /qr?id=10 - delete qr of user, whose id is 10.
```

```
GET /link?uuid=... - redirect from qr to user link
```

# TO DO endpoints

## admin panel

```
GET /admin/list - get list of not verified qr'r
```

```
POST /admin/verify?id=10 - verify qr, whose id is 10.
```

```
POST /admin/reject?id=10 - reject qr, whose id is 10.
```

## comments

```
GET /comment - get all comments.
```

```
GET /comment?id=10 - get all comments, whose id is 10.
```

```
PUT /comment?id=10 - update comment of user, whose id is 10.
```

```
DELETE /comment?id=10 - delete comment of user, whose id is 10.
```

## others

```
GET /stats - get statistic of site
```
