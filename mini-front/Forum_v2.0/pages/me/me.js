Page({
	data: {
		user: null,
		userId: null,
		userFlag: null,
		authFlag: false,
		setFlag: false,
	},
	
	onLoad(){
		if (getApp().globalData.user.userFlag == '0') {
			return;
		} else {
			this.setData({
				authFlag: true
			})
			this.init();
		}
	},

	init: function() {
		this.userFlag = getApp().globalData.user.userFlag;
		this.userId = getApp().globalData.user.userId;
		this.setData({
			userFlag: this.userFlag,
			userId: this.userId
		})
		// 已经授权, 请求数据
		var that = this;
		if (this.userFlag == '1') {
			wx.request({
				url: '"这儿是请求的后端地址，需要替换成自己的"/request/getUserInfo.php',
				header: {//json
					'content-type': 'application/x-www-form-urlencoded',
				},
				data: {
					userId: that.data.userId
				},
				method: 'POST',
				success:function(res) {
					console.log(res)
					that.setData({
						user: res.data.user
					})
				}
			})  // requext
		} 
	},
	// 授权
	close: function() {
		this.setData({
			authFlag: false
		})
	},
	auth: function() {
		var that = this
		wx.getUserProfile({
			desc: "获取你的昵称、头像、地区及性别",
			lang: "zh_CN",
			success: function(res) {
				console.log(res);
				var userInfo = res.userInfo;
				getApp().sendUserInfo(
					getApp().globalData.user.userId,
					userInfo.nickName,
					userInfo.gender,
					userInfo.avatarUrl,
				)
				that.setData({
					authFlag: true,
					user: {
						userImgUrl: userInfo.avatarUrl,
						userLikeNum: 0,
						userName: userInfo.nickName,
						userSex: userInfo.gender,
					},
					userId: getApp().globalData.userId,
					userFlag: 1,
				})
				console.log("yes")
			}
		})
	},

	set:function () {
		this.setData({
			setFlag: true
		})
	},

	setClose: function() {
		this.setData({
			setFlag: false
		})
	},

	setAuth: function() {
		var that = this
		wx.getUserProfile({
			desc: "获取你的昵称、头像、地区及性别",
			lang: "zh_CN",
			success: function(res) {
				console.log(res);
				var userInfo = res.userInfo;
				getApp().sendUserInfo(
					getApp().globalData.user.userId,
					userInfo.nickName,
					userInfo.gender,
					userInfo.avatarUrl,
				)
				that.setData({
					setFlag: false,
					user: {
						userImgUrl: userInfo.avatarUrl,
						userName: userInfo.nickName,
						userSex: userInfo.gender,
					},
				})
				console.log("yes")
			}
		})
	},

	like(){
		wx.navigateTo({
			url: '../like/like'
		})
	},
	comment(){
		wx.navigateTo({
			url: '../comment/comment'
		})
	},
	
	help() {
		wx.navigateTo({
			url: '../help/help'
		})
	},
	feedback() {
		wx.navigateTo({
			url: '../suggest/suggest'
		})
	}
})
