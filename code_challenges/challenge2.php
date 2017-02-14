<!-- Get All names of users that are admins in reverse alphabetical order -->
<?php "SELECT users.username
FROM users
WHERE is_admin = 1
ORDER BY username DESC"
?>

<!-- Get the names of all people who commented on post 2 -->
<?php "SELECT comments.name
FROM comments
WHERE post_id = 2"
?>

<!-- Get post titles, post bodies, and author name for all published posts, most recent posts first -->
<?php "SELECT posts.title, posts.body, users.username, posts.is_published
FROM posts, users
WHERE posts.user_id = users.user_id
AND posts.is_published = 1
ORDER BY posts.date DESC"
?>

<!-- Get post titles and category names of the latest 3 posts -->
<?php "SELECT posts.title, categories.name
FROM posts, categories
WHERE posts.category_id = categories.category_id
ORDER BY posts.date DESC
LIMIT 3
"
?>

<!-- Get a count of posts published by user_id 1 -->
<?php "SELECT COUNT(*) AS total
FROM posts
WHERE user_id = 1
AND is_published = 1
"
?>

<!-- Get post title, author, and category name for the latest 10 published posts -->
<?php "SELECT posts.title, users.username, categories.name
FROM posts, categories, users
WHERE posts.user_id = users.user_id
AND posts.category_id = categories.category_id
AND posts.is_published
ORDER BY posts.date ASC
LIMIT 10"
?>
