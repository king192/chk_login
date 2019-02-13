create table `web_admin_login_history` (
	`id` int unsigned not null auto_increment primary key,
	`userID` int unsigned default null,
	`username` varchar(30) not null,
	`loginStatus` tinyint(1) not null comment '登录状态 0登录失败 1登录成功',
	`loginVerify` tinyint not null default 1 comment '1有效登录(进行数据校验) 0无效登录（无效登录就是直接阻止，不进行数据校验）',
	`createTime` int not null,
	key (`username`, `loginVerify`)
) engine=InnoDB default charset=utf8;