CREATE TABLE "migrations" (
    "id" integer primary key autoincrement not null, 
    "migration" varchar not null, 
    "batch" integer not null
    );

CREATE TABLE "users" (
    "id" integer primary key autoincrement not null, 
    "name" varchar not null, 
    "email" varchar not null, 
    "email_verified_at" datetime, 
    "password" varchar not null, 
    "remember_token" varchar, 
    "created_at" datetime, 
    "updated_at" datetime
    );

CREATE TABLE "password_reset_tokens" (
    "email" varchar not null, 
    "token" varchar not null, 
    "created_at" datetime, 
    primary key ("email")
    );

CREATE TABLE "sessions" (
    "id" varchar not null, 
    "user_id" integer, 
    "ip_address" varchar, 
    "user_agent" text, 
    "payload" text not null, 
    "last_activity" integer not null, 
    primary key ("id")
    );

CREATE TABLE "cache" (
    "key" varchar not null, 
    "value" text not null, 
    "expiration" integer not null, 
    primary key ("key")
    );

CREATE TABLE "cache_locks" (
    "key" varchar not null, 
    "owner" varchar not null, 
    "expiration" integer not null, 
    primary key ("key")
    );

CREATE TABLE "jobs" (
    "id" integer primary key autoincrement not null, 
    "queue" varchar not null, 
    "payload" text not null, 
    "attempts" integer not null, 
    "reserved_at" integer, 
    "available_at" integer not null, 
    "created_at" integer not null
    );

CREATE TABLE "job_batches" (
    "id" varchar not null, 
    "name" varchar not null, 
    "total_jobs" integer not null, 
    "pending_jobs" integer not null, 
    "failed_jobs" integer not null, 
    "failed_job_ids" text not null, 
    "options" text, 
    "cancelled_at" integer, 
    "created_at" integer not null, 
    "finished_at" integer, 
    primary key ("id")
    );

CREATE TABLE "failed_jobs" (
    "id" integer primary key autoincrement not null, 
    "uuid" varchar not null, 
    "connection" varchar not null, 
    "queue" varchar not null, 
    "payload" text not null, 
    "exception" text not null, 
    "failed_at" datetime not null default CURRENT_TIMESTAMP
    );

