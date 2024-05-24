CREATE TABLE "userinfo" (
                            "id" integer PRIMARY KEY,
                            "username" varchar(255) UNIQUE,
                            "email" varchar(255),
                            "password" varchar(255),
                            "created_at" timestamp,
                            "updated_at" timestamp
);

CREATE TABLE "posts" (
                         "id" SERIAL PRIMARY KEY,
                         "user_id" integer,
                         "posted_at" timestamp,
                         "updated_at" timestamp,
                         "title" varchar(255),
                         "body" text
);

CREATE TABLE "log_userinfo" (
                                "id" SERIAL PRIMARY KEY,
                                "username" varchar(255) UNIQUE,
                                "email" varchar(255),
                                "password" varchar(255),
                                "created_at" timestamp,
                                "deleted_at" timestamp
);

CREATE TABLE "log_posts" (
                             "id" SERIAL PRIMARY KEY,
                             "user_id" integer,
                             "posted_at" timestamp,
                             "deleted_at" timestamp,
                             "title" varchar(255),
                             "body" text
);

CREATE TABLE "thumb_image" (
                               "post_id" integer PRIMARY KEY,
                               "image_id" integer UNIQUE
);

CREATE TABLE "post_images" (
                               "id" integer PRIMARY KEY,
                               "img_url" text
);

CREATE TABLE "post_tags" (
                             "post_id" integer PRIMARY KEY,
                             "tag_id" integer UNIQUE
);

CREATE TABLE "tags" (
                        "id" integer PRIMARY KEY,
                        "tag_name" char(32)
);

ALTER TABLE "userinfo" ADD FOREIGN KEY ("id") REFERENCES "posts" ("user_id");
ALTER TABLE "posts" ADD FOREIGN KEY ("id") REFERENCES "post_tags" ("post_id");
ALTER TABLE "tags" ADD FOREIGN KEY ("id") REFERENCES "post_tags" ("tag_id");
ALTER TABLE "posts" ADD FOREIGN KEY ("id") REFERENCES "thumb_image" ("post_id");
ALTER TABLE "log_posts" ADD FOREIGN KEY ("id") REFERENCES "post_tags" ("post_id");
ALTER TABLE "log_posts" ADD FOREIGN KEY ("user_id") REFERENCES "log_userinfo" ("id");
ALTER TABLE "post_images" ADD FOREIGN KEY ("id") REFERENCES "thumb_image" ("image_id");
