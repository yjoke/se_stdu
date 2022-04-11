-- 用户表
CREATE TABLE users (
	user_id			char(30)	NOT NULL,
	user_flag		tinyint		NOT NULL DEFAULT 0,
	user_name		char(35),
	user_img		char(100),
	user_sex		tinyint,
	user_like_num	int,
	PRIMARY KEY (user_id)
);

INSERT INTO users (user_id) VALUES ('default');
INSERT INTO users (user_id, user_flag) VALUES ('thisistestid', 0);
INSERT INTO users VALUES ('testflagid', 1, '叁川故里', 'https://test.yjoker.work/upload/phone.jpg', 1, 34567);

-- 管理员表
CREATE TABLE admins (
	admin_id		char(10)	NOT NULL,
	password		char(18)	NOT NULL,
	PRIMARY KEY (admin_id, password)
);

INSERT INTO admins VALUES ('testid', 'testpw');

-- 帖子类型
-- 待考虑要不要直接加入进帖子里面
-- CREATE TABLE types (
-- 	type_id			tinyint		NOT NULL,
--	type_name		char(20)	NOT NULL,
--	PRIMARY KEY (type_id, type_name)
-- )

-- 帖子表
CREATE TABLE posts (  -- 自增量待考量
	post_id			int			NOT NULL AUTO_INCREMENT,
	user_id			char(30)	NOT NULL,
	post_time		char(20)	NOT NULL,
	post_type		CHAR(10)	NOT NULL,  -- 待考虑是不是需要帖子类型一个单独的表
	post_title		char(20)	NOT NULL,
	post_text		text		NOT NULL,  -- char(1000) 报错
	post_first_img	char(100)	NOT NULL,
	post_img		text		NOT NULL,
	post_like_num	int			NOT NULL DEFAULT 0,
	del_flag		tinyint		NOT NULL DEFAULT 1,
	PRIMARY KEY (post_id, user_id),
	FOREIGN KEY (user_id) REFERENCES users (user_id)
);

INSERT INTO posts (user_id, post_time, post_type, post_title, post_text, post_first_img, post_img, post_like_num)
		value ('testflagid', '2021-10-28-9-10-50', 'testtype', '水贴的标题', '水贴的文本',
			'https://test.yjoker.work/upload/phone.jpg', 'https://test.yjoker.work/upload/phone.jpg;othertest', 1234);

-- 评论表
CREATE TABLE comments (  -- 自增量待考量
	comment_id		int			NOT NULL AUTO_INCREMENT,
	user_id			char(30)	NOT NULL,
	post_id			int			NOT NULL,
	reply_id		char(30)	,-- NOT NULL,
	comment_text	char(100)	NOT NULL,
	read_flag		tinyint		NOT NULL DEFAULT 0,
	del_flag		tinyint		NOT NULL DEFAULT 1,
	PRIMARY KEY (comment_id, user_id, post_id),
	FOREIGN KEY (user_id) REFERENCES users (user_id),
	FOREIGN KEY (post_id) REFERENCES posts (post_id),
	FOREIGN KEY (reply_id) REFERENCES users (user_id)
);

INSERT INTO comments (user_id, post_id, reply_id, comment_id)
		VALUES ('default', 1, 'testflagid', '评论的内容');

-- 点赞事件表
CREATE TABLE likes (
	user_id		char(30)	NOT NULL,
	post_id		int			NOT NULL,
	read_flag	tinyint		NOT NULL default 0,
	PRIMARY KEY (user_id, post_id)
);

INSERT INTO likes (user_id, post_id) VALUES ('testflagid', 1);

-- 全局表
CREATE TABLE globals (
	super_id	char(30)	NOT NULL,
	post_num	int,
	comment_num	int,
	PRIMARY KEY (super_id)
);

INSERT INTO globals VALUES ('testflagid', 1, 1);


-- 轮播图表
CREATE TABLE slides (
	slide_id	int			NOT	NULL AUTO_INCREMENT,
	slide_name	char(30)	NOT NULL,
	slide_url	char(100)	NOT NULL,
	slide_link	char(100),
	-- slide_flag	tinyint		default 0,
	PRIMARY KEY (slide_id)
);

INSERT INTO slides (slide_name, slide_url, slide_link) VALUES ('slidename', 'https://test.yjoker.work/upload/phone.jpg', 'https://test.yjoker.work/php/test1.php');


-- alter

ALTER TABLE slide ADD slide_flag tinyint DEFAULT 0;

ALTER TABLE posts drop COLUMN del_flag;
ALTER TABLE posts ADD del_flag tinyint DEFAULT 0;

ALTER TABLE comments drop COLUMN del_flag;
ALTER TABLE comments ADD del_flag tinyint DEFAULT 0;

ALTER TABLE users drop COLUMN user_like_num;
ALTER TABLE users ADD user_like_num int DEFAULT 0;














