CREATE TABLE "userinfo" (
                            "id" integer PRIMARY KEY,
                            "username" varchar(255) UNIQUE,
                            "email" varchar(255),
                            "password" varchar(255),
                            "created_at" datetime,
                            "updated_at" datetime
);

CREATE TABLE "posts" (
                         "id" integer PRIMARY KEY,
                         "user_id" integer,
                         "posted_at" datetime,
                         "updated_at" datetime,
                         "thumb_img_url" text,
                         "title" varchar(255),
                         "body" text
);

CREATE TABLE "post_image" (
                              "id" integer PRIMARY KEY,
                              "post_id" integer,
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

ALTER TABLE "userinfo" ADD FOREIGN KEY ("id") REFERENCES "posts" ("user_id");

ALTER TABLE "posts" ADD FOREIGN KEY ("id") REFERENCES "post_tags" ("post_id");

ALTER TABLE "posts" ADD FOREIGN KEY ("id") REFERENCES "post_image" ("post_id");

ALTER TABLE "post_image" ADD FOREIGN KEY ("img_url") REFERENCES "posts" ("thumb_img_url");

ALTER TABLE "tags" ADD FOREIGN KEY ("id") REFERENCES "post_tags" ("tag_id");
