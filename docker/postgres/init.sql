CREATE TABLE "userinfo" (
                            "id" integer PRIMARY KEY,
                            "username" varchar(255) UNIQUE,
                            "email" varchar(255),
                            "password" varchar(255),
                            "created_at" datetime,
                            "updated_at" datetime,
);

CREATE TABLE "log_userinfo" (
                                "id" integer PRIMARY KEY,
                                "username" varchar(255) UNIQUE,
                                "email" varchar(255),
                                "password" varchar(255),
                                "created_at" datetime,
                                "deleted_at" datetime,
);

CREATE TABLE "posts" (
                         "id" integer PRIMARY KEY,
                         "user_id" integer,
                         "posted_at" datetime,
                         "updated_at" datetime,
                         "title" varchar(255),
                         "body" text,
);

CREATE TABLE "log_posts" (
                             "id" integer PRIMARY KEY,
                             "user_id" integer,
                             "posted_at" datetime,
                             "deleted_at" datetim
                                 "title" varchar(255),
                             "body" text,
);

CREATE TABLE "thumb_image" (
                               "post_id" integer PRIMARY KEY,
                               "image_id" integer
);

CREATE TABLE "post_images" (
                               "id" integer PRIMARY KEY
                                   "img_url" text
);

CREATE TABLE "post_tags" (
                             "post_id" integer PRIMARY KEY,
                             "tag_id" integer
);

CREATE TABLE "tags" (
                        "id" integer PRIMARY KEY,
                        "tag_name" char
);

SELECT * FROM posts RIGHT OUTER JOIN post_tags ON posts.id = post_tags.post_id;
SELECT * FROM posts RIGHT OUTER JOIN thumb_image ON posts.id = thumb_image.post_id;
SELECT * FROM log_posts RIGHT OUTER JOIN post_tags ON log_posts.id = post_tags.post_id;

ALTER TABLE "userinfo" ADD FOREIGN KEY ("id") REFERENCES "posts" ("user_id");

ALTER TABLE "log_userinfo" ADD FOREIGN KEY ("id") REFERENCES "log_posts" ("user_id");

ALTER TABLE "posts" ADD FOREIGN KEY ("id") REFERENCES "post_tags" ("post_id");

ALTER TABLE "posts" ADD FOREIGN KEY ("id") REFERENCES "thumb_image" ("post_id");

ALTER TABLE "post_images" ADD FOREIGN KEY ("id") REFERENCES "thumb_image" ("image_id");

ALTER TABLE "log_posts" ADD FOREIGN KEY ("id") REFERENCES "post_tags" ("post_id");

ALTER TABLE "log_posts" ADD FOREIGN KEY ("id") REFERENCES "post_image" ("post_id");

ALTER TABLE "tags" ADD FOREIGN KEY ("id") REFERENCES "post_tags" ("tag_id");
