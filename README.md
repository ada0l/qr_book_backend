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

[example json output]
{
  "data": {
    "id": 1,
    "name": "Andrey",
    "email": "ada0l@gmail.com",
    "role": {
      "name": "common",
      "permissions": [
        "create qr code",
        "writing feedback"
      ]
    }
  }
}
```

```
POST /user - create new user. Required fields is email, name, password.

[json input]
"name": length(2, 50)
"email": legth(2, 50)
"password": length(8, 50)

[example json output]
{
  "data": "The user is updated"
}
```

```
PUT /user - update authorized user. Required fields is email, name.

[json input]
"name": length(2, 50)
"email": length(2, 50)

[example json output]
{
  "data": "The user is created"
}
```

```
GET /image?hash=... - get image of user

[get variables input]
"hash"
```

```
POST /image?hash=... - set image of user

[example mulitipart form input]
"image"
```

## qr's

```
GET /qr - get list of qr's of user.

[get variables input]
"order": "ASC" or "DESC"

[example json output]
{
  "data": [
    {
      "id": 8,
      "date_create": "2021-12-12 14:30:03.950018"
      "date_update": "2021-12-12 14:30:03.950018",
      "title": "Title example",
      "text": "text example",
      "uuid": null,
      "user_id": 1,
      "light_color": "111111",
      "dark_color": "111111",
      "frame_id": 1,
      "frame_text": "example",
      "frame_color": "111111",
      "frame_text_color": "111111",
      "quality": "M"
    }
  ]		
}
```

```
GET /qr?id=10 - get qr of user, which id is 10.

[get variables input]
"order": "ASC" or "DESC"
"id": int

[example json output]
{
  "data": {
    "id": 8,
    "date_create": "2021-12-12 14:30:03.950018",
    "date_update": "2021-12-12 14:30:03.950018",
    "title": "Title example",
    "text": "text example",
    "uuid": null,
    "user_id": 1,
    "light_color": "111111",
    "dark_color": "111111",
    "frame_id": 1,
    "frame_text": "example",
    "frame_color": "111111",
    "frame_text_color": "111111",
    "quality": "M"
  }
}
```

```
POST /qr - create new qr.

[json input]
"title": length(3, 50)
"text": length(3, 255)
"light_color": hex color
"dark_color": hex color
"isURL": bool
"frame_id": int in range[1, 6]
"frame_text": length(1, 32)
"frame_color": hex color
"frame_text_color": hex color
"quality": "L" or "M" or "Q" or "H"

[example json output]
{
  "data": {
    "id": 10,
    "date_create": "2021-12-13 14:00:31.925011",
    "date_update": "2021-12-13 14:00:31.925011",
    "title": "asdasdasd",
    "text": "https:\/\/google.com",
    "uuid": "7b6babe4-c22b-d22e-c5fe-ee2f51d34959",
    "user_id": 1,
    "light_color": "111111",
    "dark_color": "111111",
    "frame_id": 1,
    "frame_text": "asd",
    "frame_color": "111111",
    "frame_text_color": "111111",
    "quality": "M"
  }
}
```

```
PUT /qr?id=10 - update qr of user, which id is 10.

[json input]
the same as with the post method 

[example json output]
the same as with the post method 

```

```
DELETE /qr?id=10 - delete qr of user, which id is 10.

[get variables input]
"id": int

[example json output]
{
  "data": "The object is deleted"
}
```

```
GET /link?uuid=... - redirect from qr to user link

[get variables input]
"uuid": md5 hash

```

## comments

```
GET /comment - get all comments.

[get variables input]
"order": "ASC" or "DESC"
"id": int

[example json output]
{
  "data": {
    "comments":
      [
        {
          "id": 22,
          "date_create": "2021-12-13 05:47:27.186034",
          "date_update": "2021-12-13 05:47:27.186034",
          "text": "Мне не нравится",
          "user_id": 3,
          "mark": 5
        },
        {
          "id": 23,
          "date_create": "2021-12-13 05:47:59.329058",
          "date_update": "2021-12-13 05:47:59.329058",
          "text": "Круто",
          "user_id": 4,
          "mark": 5
        }
      ]
    "stats": {
      "0": {
        "mark": 5,
        "count": 1
      },
      "1": {
        "mark": 1,
        "count": 5
      },
      "mean": "5"
    }
  }
}
```

```
GET /comment?id=10 - get all comments, which id is 10.

[get variables input]
"order": "ASC" or "DESC"
"id": int

[example json output]
{
  "data": {
    "id": 22,
    "date_create": "2021-12-13 05:47:27.186034",
    "date_update": "2021-12-13 05:47:27.186034",
    "text": "Мне не нравится",
    "user_id": 3,
    "mark": 5
  }
}
```

```
POST /comment - create comment

[json input]
{
  "text": "Мне не нрdавится",
  "mark": 5
}

[example json output]
{
  "data": {
    "id": 23,
    "date_create": "2021-12-13 05:47:59.329058",
    "date_update": "2021-12-13 05:47:59.329058",
    "text": "Cool",
    "user_id": 4,
    "mark": 5
  }
}
```

```
PUT /comment?id=10 - update comment of user, which id is 10.

[get variables input]
"id": int

[json input]
the same as with the post method 

[example json output]
the same as with the post method 

```

```
DELETE /comment?id=10 - delete comment of user, which id is 10.

[get variables input]
"id": int

```

## others

```
GET /stats - get statistic of site

[example json output]
{
  "data": {
    "count_of_users": {
      "count": 1
    },
    "count_of_qrs": {
      "count": 10
    }
  }
}
```

# TO DO endpoints

## admin panel

```
GET /admin/list - get list of not verified qr'r
```

```
POST /admin/verify?id=10 - verify qr, which id is 10.
```

```
POST /admin/reject?id=10 - reject qr, which id is 10.
```
