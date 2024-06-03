CREATE TABLE "userinfo" (
                            "id" SERIAL PRIMARY KEY,
                            "email" varchar(255),
                            "username" varchar(255) UNIQUE,
                            "password" varchar(255),
                            "user_image" varchar(255),
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
                                "user_image" varchar(255),
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
                               "id" SERIAL PRIMARY KEY,
                               "post_id" integer,
                               "thumb_url" text
);

CREATE TABLE "post_images" (
                               "id" SERIAL PRIMARY KEY,
                               "post_id" integer,
                               "img_url" text
);

CREATE TABLE "tags" (
                       "id" SERIAL PRIMARY KEY,
                       "tag" varchar(255)
);

CREATE TABLE "post_selected_tags" (
                            "id" SERIAL PRIMARY KEY,
                            "post_id" integer,
                            "tag_id" integer
);

INSERT INTO "tags" ("tag") VALUES ('総合'), ('テクノロジー'), ('モバイル'), ('アプリ'),
                                  ('エンタメ'), ('ビューティー'), ('ファッション'),
                                  ('ライフスタイル'), ('ビジネス'), ('グルメ'), ('スポーツ');

ALTER TABLE "posts" ADD FOREIGN KEY ("user_id") REFERENCES "userinfo" ("id");
ALTER TABLE "thumb_image" ADD FOREIGN KEY ("post_id") REFERENCES "posts" ("id");
ALTER TABLE "post_images" ADD FOREIGN KEY ("post_id") REFERENCES "posts" ("id");
ALTER TABLE "post_selected_tags" ADD FOREIGN KEY ("post_id") REFERENCES "posts" ("id");
ALTER TABLE "post_selected_tags" ADD FOREIGN KEY ("tag_id") REFERENCES "tags" ("id");
