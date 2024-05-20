CREATE TABLE "userinfo" (
                            "id" integer PRIMARY KEY,
                            "username" varchar UNIQUE,
                            "email" varchar,
                            "password" varchar,
                            "createdAt" date
);

CREATE TABLE "posts" (
                         "id" integer PRIMARY KEY,
                         "user_id" integer,
                         "postedAt" date,
                         "thumb_img_url" text,
                         "title" varchar,
                         "body" text,
                         "selected_tags" integer
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

ALTER TABLE "userinfo" ADD FOREIGN KEY ("id") REFERENCES "posts" ("user_id");

ALTER TABLE "posts" ADD FOREIGN KEY ("id") REFERENCES "post_tags" ("post_id");

ALTER TABLE "posts" ADD FOREIGN KEY ("id") REFERENCES "post_image" ("post_id");

CREATE TABLE "post_tags_tags" (
                                  "post_tags_tag_id" integer,
                                  "tags_id" integer,
                                  PRIMARY KEY ("post_tags_tag_id", "tags_id")
);

ALTER TABLE "post_tags_tags" ADD FOREIGN KEY ("post_tags_tag_id") REFERENCES "post_tags" ("tag_id");

ALTER TABLE "post_tags_tags" ADD FOREIGN KEY ("tags_id") REFERENCES "tags" ("id");


CREATE TABLE "posts_post_tags" (
                                   "posts_selected_tags" integer,
                                   "post_tags_tag_id" integer,
                                   PRIMARY KEY ("posts_selected_tags", "post_tags_tag_id")
);

ALTER TABLE "posts_post_tags" ADD FOREIGN KEY ("posts_selected_tags") REFERENCES "posts" ("selected_tags");

ALTER TABLE "posts_post_tags" ADD FOREIGN KEY ("post_tags_tag_id") REFERENCES "post_tags" ("tag_id");


ALTER TABLE "post_image" ADD FOREIGN KEY ("img_url") REFERENCES "posts" ("thumb_img_url");
