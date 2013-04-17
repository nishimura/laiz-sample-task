CREATE TABLE task(
  task_id    serial primary key,
  user_name  text not null,
  subject    text not null,
  body       text,
  created_at timestamp not null,
  updated_at timestamp
);

