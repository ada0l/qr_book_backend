\connect qr

CREATE TABLE qr_user (
  id SERIAL PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update TIMESTAMP NOT NULL,
  email VARCHAR(50) NOT NULL,
  name VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL
);

CREATE TABLE qr_card (
  id SERIAL PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update TIMESTAMP NULL,
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
  accepted BOOL NOT NULL,
  CONSTRAINT "fk_user" FOREIGN KEY(user_id) REFERENCES qr_user(id) ON DELETE CASCADE
);

CREATE TABLE qr_comment (
  id SERIAL PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update TIMESTAMP NULL,
  text VARCHAR(255) NOT NULL,
  user_id INT NOT NULL,
  mark INT NOT NULL,
  CONSTRAINT "fk_user" FOREIGN KEY(user_id) REFERENCES qr_user(id) ON DELETE CASCADE
);

CREATE TABLE qr_permission (
  id SERIAL PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update TIMESTAMP NOT NULL,
  text VARCHAR(255) NOT NULL
);

CREATE TABLE qr_role (
  id serial PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update TIMESTAMP NULL,
  text VARCHAR(255) NOT NULL
);

CREATE TABLE qr_role_permission (
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update TIMESTAMP NOT NULL,
  role_id INT NOT NULL,
  permission_id INT NOT NULL,
  PRIMARY KEY(role_id, permission_id),
  CONSTRAINT "fk_role" FOREIGN KEY(role_id) REFERENCES qr_role(id) ON DELETE CASCADE,
  CONSTRAINT "fk_permission" FOREIGN KEY(permission_id) REFERENCES qr_permission(id) ON DELETE CASCADE
);

CREATE TABLE qr_warning (
  id SERIAL PRIMARY KEY,
  date_create TIMESTAMP without time zone default (now() at time zone 'utc'),
  date_update TIMESTAMP NOT NULL,
  user_id INT NOT NULL,
  CONSTRAINT "fk_user" FOREIGN KEY(user_id) REFERENCES qr_user(id) ON DELETE CASCADE
);
