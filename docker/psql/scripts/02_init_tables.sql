\connect qr

CREATE TABLE qr_permission (
  id SERIAL PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update timestamp without time zone default (now() at time zone 'utc'),
  text VARCHAR(255) NOT NULL
);

CREATE TABLE qr_role (
  id serial PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update timestamp without time zone default (now() at time zone 'utc'),
  text VARCHAR(255) NOT NULL
);

CREATE TABLE qr_role_permission (
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update timestamp without time zone default (now() at time zone 'utc'),
  role_id INT NOT NULL,
  permission_id INT NOT NULL,
  PRIMARY KEY(role_id, permission_id),
  CONSTRAINT "fk_role" FOREIGN KEY(role_id) REFERENCES qr_role(id) ON DELETE CASCADE,
  CONSTRAINT "fk_permission" FOREIGN KEY(permission_id) REFERENCES qr_permission(id) ON DELETE CASCADE
);

CREATE TABLE qr_user (
  id SERIAL PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update timestamp without time zone default (now() at time zone 'utc'),
  email VARCHAR(50) UNIQUE NOT NULL,
  name VARCHAR(50) NOT NULL,
  password VARCHAR(250) NOT NULL,
  role_id INT NOT NULL,
  CONSTRAINT "fk_role" FOREIGN KEY(role_id) REFERENCES qr_role(id) ON DELETE CASCADE
);

CREATE TABLE qr_card (
  id SERIAL PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update timestamp without time zone default (now() at time zone 'utc'),
  title VARCHAR(50) NOT NULL,
  text VARCHAR(255) NOT NULL,
  uuid uuid,
  user_id INT NOT NULL,
  light_color VARCHAR(6) NOT NULL,
  dark_color VARCHAR(6) NOT NULL,
  frame_id INT NOT NULL,
  frame_text VARCHAR(32) NOT NULL,
  frame_color VARCHAR(6) NOT NULL,
  frame_text_color VARCHAR(6) NOT NULL,
  quality VARCHAR(6) NOT NULL,
  CONSTRAINT "fk_user" FOREIGN KEY(user_id) REFERENCES qr_user(id) ON DELETE CASCADE
);

CREATE TABLE qr_comment (
  id SERIAL PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update timestamp without time zone default (now() at time zone 'utc'),
  text VARCHAR(255) NOT NULL,
  user_id INT NOT NULL,
  mark INT NOT NULL,
  CONSTRAINT "fk_user" FOREIGN KEY(user_id) REFERENCES qr_user(id) ON DELETE CASCADE
);

CREATE TABLE qr_warning (
  id SERIAL PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update timestamp without time zone default (now() at time zone 'utc'),
  user_id INT NOT NULL,
  CONSTRAINT "fk_user" FOREIGN KEY(user_id) REFERENCES qr_user(id) ON DELETE CASCADE
);

INSERT INTO
    qr_permission (id, text)
VALUES
    (1, 'create qr code'),
    (2, 'writing feedback'),
    (3, 'admin panel access'),
    (4, 'reject qr code');

INSERT INTO
    qr_role (id, text)
VALUES
    (1, 'admin'),
    (2, 'common'),
    (3, 'banned');

INSERT INTO
    qr_role_permission (role_id, permission_id) 
VALUES
    (1, 1), (1, 2), (1, 3), (1, 4),
    (2, 1), (2, 2);
