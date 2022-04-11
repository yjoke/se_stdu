-- 删除了之前的全局表

-- 全局表
CREATE TABLE globals (
	g_ident		char(16)	NOT NULL,
	g_value		char(30)	NOT NULL,
	PRIMARY KEY (g_ident)
);

INSERT INTO globals VALUES ('admin_time', '7200');
insert into globals values ('super_id', '@admin');
insert into globals values ('super_pw', '@admin');



-- 管理员登录
alter table admins add token char(30) default null;
alter table admins add times char(12) default null;  -- 时间戳

-- 全局表
-- 添加一个数据形式

-- 用户拉黑功能
alter table users add can_publish tinyint default 1;
alter table users add can_login tinyint default 1;

-- 轮播图的删除功能
alter table slides add del_flag tinyint default 0;

-- 增加一个自己的用户标识符 UID
-- alter table users add UID int auto_increment;

-- 管理员token
insert into globals values ("token", "");
insert into globals values ("stime", "");

-- 修改主键
ALTER TABLE 'admins' DROP PRIMARY KEY,
   ADD PRIMARY KEY('admin_id');
   
-- 建议表
create table suggest (
	id		int			NOT NULL AUTO_INCREMENT,
	contact	char(30)	NOT NULL,
	texts	text		NOT NULL,
	PRIMARY KEY (id)
)

-- 