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
                         "user_id" integer UNIQUE,
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
